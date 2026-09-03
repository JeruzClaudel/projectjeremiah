<?php

namespace App\Exports\Sheets;

use App\Models\FreedomWall;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnalyticsByYearSheet implements FromArray, WithTitle, ShouldAutoSize
{
    public function title(): string { return 'By Year Level'; }

    public function array(): array
    {
        $rows   = [['Year Level', 'Total Posts', 'High Risk']];
        $groups = FreedomWall::get()->groupBy('year_level');

        foreach ($groups as $year => $posts) {
            $rows[] = [
                $year ?: 'Unknown',
                $posts->count(),
                $posts->where('sentiment', 'high_risk')->count(),
            ];
        }

        return $rows;
    }
}
