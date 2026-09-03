<?php

namespace App\Services;

use App\Models\SentimentKeyword;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SentimentService
{
    /**
     * Fast keyword-based sentiment analysis (no network, instant).
     */
    public function analyzeByKeywords(string $text): string
    {
        $text = strtolower($text);

        $keywords = SentimentKeyword::all();

        $scores = ['high_risk' => 0, 'negative' => 0, 'positive' => 0];

        foreach ($keywords as $kw) {
            if (str_contains($text, strtolower($kw->word))) {
                $category = $kw->category;
                if (isset($scores[$category])) {
                    $scores[$category]++;
                }
            }
        }

        if ($scores['high_risk'] > 0)  return 'high_risk';
        if ($scores['negative'] > 0)   return 'negative';
        if ($scores['positive'] > 0)   return 'positive';

        return 'neutral';
    }

    /**
     * AI-based sentiment analysis via OpenRouter.
     */
    public function analyzeWithAI(string $text): array
    {
        $apiKey  = config('services.openrouter.api_key', env('OPENROUTER_API_KEY'));
        $baseUrl = config('services.openrouter.base_url', env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1'));
        $model   = config('services.openrouter.model', env('OPENROUTER_MODEL', 'openai/gpt-4o-mini'));

        if (empty($apiKey)) {
            Log::warning('SentimentService: OPENROUTER_API_KEY not set.');
            return $this->emptyAiResult();
        }

        $prompt = <<<PROMPT
You are a mental health screening assistant for a school guidance office.
Analyze the following student post and return a JSON object with these fields:
- "ai_sentiment": one of "positive", "negative", "neutral", "high_risk"
- "ai_emotion_category": short label (e.g. "anxiety", "depression", "loneliness", "anger", "joy", "stress", "neutral")
- "ai_confidence": integer 0-100
- "ai_counselor_note": 1-2 sentence note for the guidance counselor (in English)
- "ai_flagged": true if the post shows signs of self-harm, suicidal ideation, abuse, or crisis; false otherwise

Respond ONLY with valid JSON. No explanation, no markdown.

Student post:
"""
{$text}
"""
PROMPT;

        try {
            $response = Http::withToken($apiKey)
                ->timeout(30)
                ->post("{$baseUrl}/chat/completions", [
                    'model'    => $model,
                    'messages' => [['role' => 'user', 'content' => $prompt]],
                ]);

            if (! $response->successful()) {
                Log::error('SentimentService AI error: ' . $response->body());
                return $this->emptyAiResult();
            }

            $content = $response->json('choices.0.message.content', '');
            // Strip markdown code fences if present
            $content = preg_replace('/^```(?:json)?\s*/m', '', $content);
            $content = preg_replace('/```\s*$/m', '', $content);

            $data = json_decode(trim($content), true);

            if (! is_array($data)) {
                Log::error('SentimentService: Invalid JSON from AI: ' . $content);
                return $this->emptyAiResult();
            }

            return [
                'ai_sentiment'        => $data['ai_sentiment']        ?? 'neutral',
                'ai_emotion_category' => $data['ai_emotion_category'] ?? null,
                'ai_confidence'       => isset($data['ai_confidence']) ? (int) $data['ai_confidence'] : null,
                'ai_counselor_note'   => $data['ai_counselor_note']   ?? null,
                'ai_flagged'          => (bool) ($data['ai_flagged']  ?? false),
                'ai_raw'              => $data,
            ];

        } catch (\Exception $e) {
            Log::error('SentimentService exception: ' . $e->getMessage());
            return $this->emptyAiResult();
        }
    }

    private function emptyAiResult(): array
    {
        return [
            'ai_sentiment'        => null,
            'ai_emotion_category' => null,
            'ai_confidence'       => null,
            'ai_counselor_note'   => null,
            'ai_flagged'          => false,
            'ai_raw'              => null,
        ];
    }
}
