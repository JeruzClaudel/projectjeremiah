<?php

namespace App\Jobs;

use App\Models\FreedomWall;
use App\Services\SentimentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnalyzeFreedomWallPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $postId;

    public function __construct(int $postId)
    {
        $this->postId = $postId;
    }

    public function handle(SentimentService $sentiment): void
    {
        $post = FreedomWall::find($this->postId);

        if (! $post) {
            return;
        }

        try {
            $result = $sentiment->analyzeWithAI($post->post);

            if (! empty($result['ai_sentiment'])) {
                $post->update($result);

                if ($result['ai_sentiment'] === 'high_risk' || ($result['ai_flagged'] ?? false)) {
                    $post->update(['sentiment' => 'high_risk']);
                }
            }
        } catch (\Exception $e) {
            Log::error("AnalyzeFreedomWallPost job failed for post #{$this->postId}: " . $e->getMessage());
        }
    }
}
