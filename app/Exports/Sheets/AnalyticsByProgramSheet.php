<?php

namespace App\Exports\Sheets;

use App\Models\FreedomWall;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnalyticsByProgramSheet implements FromArray, WithTitle, ShouldAutoSize
{
    public function title(): string { return 'By Program'; }

    public function array(): array
    {
        $rows   = [['Program', 'Total Posts', 'High Risk', 'Negative', 'Positive', 'Neutral']];
        $groups = FreedomWall::get()->groupBy('program');

        foreach ($groups as $program => $posts) {
            $rows[] = [
                $program ?: 'Unknown',
                $posts->count(),
                $posts->where('sentiment', 'high_risk')->count(),
                $posts->where('sentiment', 'negative')->count(),
                $posts->where('sentiment', 'positive')->count(),
                $posts->where('sentiment', 'neutral')->count(),
            ];
        }

        return $rows;
    }
}
