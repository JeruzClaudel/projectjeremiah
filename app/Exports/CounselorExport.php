<?php

namespace App\Exports;

use App\Models\Admin\Counselor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CounselorExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Counselor::with('schedules')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Position', 'College / Department', 'Email', 'MS Teams Account', 'Schedule'];
    }

    public function map($row): array
    {
        $schedule = $row->schedules->map(function ($s) {
            return "{$s->day_of_week}: {$s->start_time}–{$s->end_time}";
        })->implode(', ');

        return [
            $row->id,
            $row->name,
            $row->position         ?? '',
            $row->college          ?? '',
            $row->email            ?? '',
            $row->ms_teams_account ?? '',
            $schedule,
        ];
    }
}
