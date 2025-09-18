<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Topic;
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

    public $tries = 3;
    public $backoff = 10;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function handle(): void
    {
        $article = $this->article;

        if (!empty($article->summary)) {
            Log::info("Skipping article {$article->id}, already summarized.");
            return;
        }

        Log::info("Starting summarization for article {$article->id} ({$article->title})");

        try {
            $content = Str::limit($article->content, 3000);

            // Prepare JSON prompt
            $topicsList = Topic::pluck('name')->toArray();
            $prompt = "Summarize the following article concisely in one paragraph. Then choose the most relevant topic from this list: " . implode(", ", $topicsList) . ". Return a JSON object with keys 'summary' and 'topic'.\n\nArticle content:\n{$content}";

            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ],
                ],
            ]);

            $aiOutput = $response->choices[0]->message->content ?? '';
            if (empty($aiOutput)) {
                Log::warning("OpenAI returned empty response for article {$article->id}");
                return;
            }

            // Parse JSON safely
            $data = json_decode($aiOutput, true);
            if (!$data || !isset($data['summary'], $data['topic'])) {
                Log::warning("Invalid AI JSON for article {$article->id}: " . $aiOutput);
                return;
            }

            $article->summary = $data['summary'];

            // Assign topic if it exists
            $topic = Topic::where('name', $data['topic'])->first();
            if ($topic) {
                $article->topic_id = $topic->id;
                Log::info("Assigned topic '{$topic->name}' to article {$article->id}");
            } else {
                Log::warning("Suggested topic '{$data['topic']}' not found in DB for article {$article->id}");
            }

            $article->save();
            Log::info("Article {$article->id} summarized successfully.");
        } catch (\Exception $e) {
            Log::error("Failed to summarize article {$article->id}: " . $e->getMessage());
            throw $e; // ensures job retries
        }
    }
}
