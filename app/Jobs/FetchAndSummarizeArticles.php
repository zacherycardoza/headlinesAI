<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Topic;
use App\Jobs\SummarizeArticle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchAndSummarizeArticles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        $topics = Topic::all();

        if ($topics->isEmpty()) {
            Log::warning("No topics found. Add topics before running FetchAndSummarizeArticles.");
            return;
        }

        $rssUrls = [
            'https://techcrunch.com/feed/',
            'https://www.theverge.com/rss/index.xml',
            'http://rss.cnn.com/rss/cnn_topstories.rss',
            'https://feeds.reuters.com/Reuters/worldNews',
            'https://moxie.foxnews.com/google-publisher/world.xml',
            'https://apnews.com/hub/ap-top-news'
        ];

        foreach ($topics as $topic) {
            foreach ($rssUrls as $url) {
                try {
                    $rssContent = cache()->remember("rss_feed_" . md5($url), now()->addMinutes(15), function () use ($url) {
                        return @file_get_contents($url) ?: '';
                    });

                    if (empty($rssContent)) {
                        Log::warning("Failed to fetch RSS feed: $url");
                        continue;
                    }

                    $xml = simplexml_load_string($rssContent);
                    if (!$xml || !isset($xml->channel->item)) {
                        Log::warning("RSS feed has no items: $url");
                        continue;
                    }

                    foreach ($xml->channel->item as $item) {
                        $articleUrl = (string) ($item->link ?? '');
                        if (Article::where('url', $articleUrl)->exists()) continue;

                        // Extract image
                        $image = '';
                        if (isset($item->enclosure['url'])) {
                            $image = (string) $item->enclosure['url'];
                        } elseif (isset($item->children('media', true)->content)) {
                            $image = (string) ($item->children('media', true)->content->attributes()->url ?? '');
                        }

                        if (empty($image) && !empty($articleUrl)) {
                            try {
                                $html = @file_get_contents($articleUrl);
                                if ($html) {
                                    $dom = new \DOMDocument();
                                    libxml_use_internal_errors(true);
                                    $dom->loadHTML($html);
                                    libxml_clear_errors();

                                    foreach ($dom->getElementsByTagName('meta') as $meta) {
                                        if ($meta->getAttribute('property') === 'og:image') {
                                            $image = $meta->getAttribute('content');
                                            break;
                                        }
                                    }

                                    if (empty($image)) {
                                        $imgs = $dom->getElementsByTagName('img');
                                        if ($imgs->length > 0) $image = $imgs->item(0)->getAttribute('src');
                                    }
                                }
                            } catch (\Exception $e) {
                                Log::warning("Failed to fetch image from {$articleUrl}: " . $e->getMessage());
                            }
                        }

                        if ($item->description === null || $image === null) continue;

                        $article = Article::create([
                            'title' => (string) ($item->title ?? 'No title'),
                            'content' => (string) ($item->description ?? ''),
                            'url' => $articleUrl,
                            'source' => parse_url($url, PHP_URL_HOST),
                            'published_at' => isset($item->pubDate) ? date('Y-m-d H:i:s', strtotime($item->pubDate)) : now(),
                            'topic_id' => $topic->id, // temporary; will be overwritten by SummarizeArticle
                            'image_url' => $image,
                        ]);

                        SummarizeArticle::dispatch($article);
                        usleep(500_000); // avoid rate limits
                    }
                } catch (\Exception $e) {
                    Log::error("Error fetching RSS feed {$url}: " . $e->getMessage());
                }
            }
        }
    }
}
