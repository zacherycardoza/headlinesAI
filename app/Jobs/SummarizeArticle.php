<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SummarizeArticle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Article $article;

    public $tries = 3;           // Retry failed jobs up to 3 times
    public $backoff = 10;        // Wait 10 seconds between retries

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function handle(): void
    {
        $article = $this->article;

        // Skip if already summarized
        if (!empty($article->summary)) {
            return;
        }

        try {
            // Limit content to avoid token overflow
            $content = Str::limit($article->content, 3000);

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

            $article->summary = $summary;
            $article->save();

            Log::info("Article {$article->id} summarized successfully.");
        } catch (\Exception $e) {
            Log::error("Failed to summarize article {$article->id}: " . $e->getMessage());
            // Let the job retry automatically if it fails
            throw $e;
        }
    }
}
