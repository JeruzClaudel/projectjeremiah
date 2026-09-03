<?php

namespace App\Exports;

use App\Models\FreedomWall;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FreedomWallExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = FreedomWall::query();

        if (! empty($this->filters['program']))    $query->where('program',    $this->filters['program']);
        if (! empty($this->filters['year_level'])) $query->where('year_level', $this->filters['year_level']);
        if (! empty($this->filters['sentiment']))  $query->where('sentiment',  $this->filters['sentiment']);
        if (! empty($this->filters['ai_flagged'])) $query->where('ai_flagged', true);
        if (! empty($this->filters['start_date'])) $query->whereDate('created_at', '>=', $this->filters['start_date']);
        if (! empty($this->filters['end_date']))   $query->whereDate('created_at', '<=', $this->filters['end_date']);

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            '#', 'Name', 'Program', 'Year Level', 'Post', 'Keyword Sentiment',
            'AI Sentiment', 'Emotion Category', 'Confidence (%)', 'Counselor Note',
            'AI Flagged', 'Date Submitted',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->postName,
            $row->program    ?? '—',
            $row->year_level ?? '—',
            $row->post,
            strtoupper(str_replace('_', ' ', $row->sentiment   ?? '—')),
            strtoupper(str_replace('_', ' ', $row->ai_sentiment ?? '—')),
            $row->ai_emotion_category ?? '—',
            $row->ai_confidence       ?? '—',
            $row->ai_counselor_note   ?? '—',
            $row->ai_flagged ? 'YES' : 'No',
            $row->created_at->format('Y-m-d H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '0A1931']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
