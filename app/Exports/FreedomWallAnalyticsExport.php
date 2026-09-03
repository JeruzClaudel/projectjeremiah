<?php

namespace App\Exports;

use App\Exports\Sheets\AnalyticsSummarySheet;
use App\Exports\Sheets\AnalyticsByProgramSheet;
use App\Exports\Sheets\AnalyticsByYearSheet;
use App\Exports\Sheets\AnalyticsSentimentSheet;
use App\Exports\Sheets\AnalyticsMonthlySheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FreedomWallAnalyticsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new AnalyticsSummarySheet(),
            new AnalyticsByProgramSheet(),
            new AnalyticsByYearSheet(),
            new AnalyticsSentimentSheet(),
            new AnalyticsMonthlySheet(),
        ];
    }
}
