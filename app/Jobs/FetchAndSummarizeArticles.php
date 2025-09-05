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
                    // Cache RSS feed as a string for 15 minutes
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
                        if (Article::where('url', $articleUrl)->exists()) {
                            continue; // skip duplicates
                        }

                        // Extract image safely
                        $image = '';
                        if (isset($item->enclosure['url'])) {
                            $image = (string) $item->enclosure['url'];
                        } elseif (isset($item->children('media', true)->content)) {
                            $image = (string) ($item->children('media', true)->content->attributes()->url ?? '');
                        }

                        // Fallback: scrape article page if RSS has no image
                        if (empty($image) && !empty($articleUrl)) {
                            try {
                                $html = @file_get_contents($articleUrl);
                                if ($html) {
                                    $dom = new \DOMDocument();
                                    libxml_use_internal_errors(true);
                                    $dom->loadHTML($html);
                                    libxml_clear_errors();

                                    // Try Open Graph image
                                    $metas = $dom->getElementsByTagName('meta');
                                    foreach ($metas as $meta) {
                                        if ($meta->getAttribute('property') === 'og:image') {
                                            $image = $meta->getAttribute('content');
                                            break;
                                        }
                                    }

                                    // Fallback: first <img> on page
                                    if (empty($image)) {
                                        $imgs = $dom->getElementsByTagName('img');
                                        if ($imgs->length > 0) {
                                            $image = $imgs->item(0)->getAttribute('src');
                                        }
                                    }
                                }
                            } catch (\Exception $e) {
                                Log::warning("Failed to fetch main image from {$articleUrl}: " . $e->getMessage());
                            }
                        }

                        Log::info("Found image for article {$articleUrl}: {$image}");

                        $article = Article::create([
                            'title' => (string) ($item->title ?? 'No title'),
                            'content' => (string) ($item->description ?? ''),
                            'url' => $articleUrl,
                            'source' => parse_url($url, PHP_URL_HOST),
                            'published_at' => isset($item->pubDate) ? date('Y-m-d H:i:s', strtotime($item->pubDate)) : now(),
                            'topic_id' => $topic->id,
                            'image_url' => $image,
                        ]);

                        // Dispatch summarize job
                        SummarizeArticle::dispatch($article);

                        // Optional: small delay to avoid hitting rate limits
                        usleep(500_000); // 0.5 seconds
                    }
                } catch (\Exception $e) {
                    Log::error("Error fetching RSS feed {$url}: " . $e->getMessage());
                }
            }
        }
    }
}
