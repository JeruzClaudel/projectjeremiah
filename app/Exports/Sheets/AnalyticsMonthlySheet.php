<?php

namespace App\Exports\Sheets;

use App\Models\FreedomWall;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnalyticsMonthlySheet implements FromArray, WithTitle, ShouldAutoSize
{
    public function title(): string { return 'Monthly'; }

    public function array(): array
    {
        $rows = [['Month', 'Total Posts']];

        $monthly = FreedomWall::selectRaw("strftime('%Y-%m', created_at) as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        foreach ($monthly as $row) {
            $rows[] = [$row->month, $row->total];
        }

        return $rows;
    }
}
