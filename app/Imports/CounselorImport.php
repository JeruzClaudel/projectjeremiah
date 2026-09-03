<?php

namespace App\Imports;

use App\Models\Admin\Counselor;
use App\Models\Admin\CounselorSchedule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class CounselorImport implements ToCollection, WithHeadingRow
{
    protected int $imported = 0;
    protected int $updated  = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $row = $row->toArray();

            // Normalize keys — handle various heading formats
            $row = array_change_key_case($row, CASE_LOWER);
            $row = array_map('trim', array_map('strval', $row));

            $name = $row['name'] ?? '';

            if (empty($name)) {
                continue;
            }

            $data = [
                'position'         => $row['position']           ?? null,
                'college'          => $row['college_/_department'] ?? $row['college'] ?? null,
                'email'            => $row['email']               ?? null,
                'ms_teams_account' => $row['ms_teams_account']    ?? null,
            ];

            $counselor = Counselor::where('name', $name)->first();

            if ($counselor) {
                $counselor->update($data);
                $this->updated++;
            } else {
                $counselor = Counselor::create(array_merge(['name' => $name], $data));
                $this->imported++;
            }

            // Parse schedule column if present
            $schedule = $row['schedule'] ?? '';
            if (! empty($schedule)) {
                // Format: "Monday: 08:00-17:00, Tuesday: 09:00-18:00"
                $counselor->schedules()->delete();

                foreach (explode(',', $schedule) as $entry) {
                    $entry = trim($entry);
                    if (preg_match('/^(\w+):\s*(\d{2}:\d{2})\s*[–\-]\s*(\d{2}:\d{2})$/', $entry, $m)) {
                        CounselorSchedule::create([
                            'counselor_id' => $counselor->id,
                            'day_of_week'  => ucfirst(strtolower($m[1])),
                            'start_time'   => $m[2],
                            'end_time'     => $m[3],
                        ]);
                    }
                }
            }
        }
    }

    public function getImportedCount(): int { return $this->imported; }
    public function getUpdatedCount():  int { return $this->updated;  }
}
