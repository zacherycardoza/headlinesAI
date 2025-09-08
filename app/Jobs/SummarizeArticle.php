<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SummarizeArticle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Article $article;

    public $tries = 3;    // retry failed jobs 3 times
    public $backoff = 10; // wait 10 seconds between retries

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function handle(): void
    {
        $article = $this->article;

        if (!empty($article->summary)) {
            error_log("Skipping article {$article->id}, already summarized.");
            return;
        }

        // Log start of summarization
        error_log("Starting summarization for article {$article->id} ({$article->title})");

        try {
            $content = Str::limit($article->content, 3000);

            error_log("Content length for article {$article->id}: " . strlen($content));

            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Summarize the following article concisely:\n\n{$content}"
                    ],
                ],
            ]);

            $summary = $response->choices[0]->message->content ?? '';

            if (empty($summary)) {
                error_log("OpenAI returned empty summary for article {$article->id}");
            } else {
                $article->summary = $summary;
                $article->save();
                error_log("Article {$article->id} summarized successfully.");
            }
        } catch (\Exception $e) {
            error_log("Failed to summarize article {$article->id}: " . $e->getMessage());
            throw $e; // ensure job retries
        }
    }
}
