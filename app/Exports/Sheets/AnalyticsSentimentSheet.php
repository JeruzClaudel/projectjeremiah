<?php

namespace App\Exports\Sheets;

use App\Models\FreedomWall;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnalyticsSentimentSheet implements FromArray, WithTitle, ShouldAutoSize
{
    public function title(): string { return 'Sentiment Breakdown'; }

    public function array(): array
    {
        $rows   = [['Keyword Sentiment', 'Count', 'AI Sentiment', 'Count']];
        $kw     = FreedomWall::get()->groupBy('sentiment');
        $ai     = FreedomWall::whereNotNull('ai_sentiment')->get()->groupBy('ai_sentiment');

        $allKeys = collect($kw->keys())->merge($ai->keys())->unique()->values();

        foreach ($allKeys as $key) {
            $rows[] = [
                strtoupper(str_replace('_', ' ', $key)),
                $kw->get($key)?->count() ?? 0,
                strtoupper(str_replace('_', ' ', $key)),
                $ai->get($key)?->count() ?? 0,
            ];
        }

        return $rows;
    }
}
