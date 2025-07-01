<?php

namespace App\Models\Admin;

use App\Models\Admin\Teacher;
use Illuminate\Database\Eloquent\Model;

class CounselorSchedule extends Model
{
    //
    protected $fillable = ['counselor_id', 'day_of_week', 'start_time', 'end_time'];

    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }
}
