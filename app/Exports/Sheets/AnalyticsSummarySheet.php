<?php

namespace App\Exports\Sheets;

use App\Models\FreedomWall;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnalyticsSummarySheet implements FromArray, WithTitle, ShouldAutoSize
{
    public function title(): string { return 'Summary'; }

    public function array(): array
    {
        $total     = FreedomWall::count();
        $today     = FreedomWall::whereDate('created_at', today())->count();
        $highRisk  = FreedomWall::where('sentiment', 'high_risk')->orWhere('ai_sentiment', 'high_risk')->orWhere('ai_flagged', true)->count();
        $positive  = FreedomWall::where('sentiment', 'positive')->count();
        $negative  = FreedomWall::where('sentiment', 'negative')->count();
        $neutral   = FreedomWall::where('sentiment', 'neutral')->count();

        return [
            ['e-Hayag Analytics Summary', 'Generated: ' . now()->format('Y-m-d H:i')],
            [],
            ['Metric', 'Value'],
            ['Total Posts', $total],
            ['Posts Today', $today],
            ['High-Risk Posts', $highRisk],
            ['Positive Posts', $positive],
            ['Negative Posts', $negative],
            ['Neutral Posts', $neutral],
        ];
    }
}
