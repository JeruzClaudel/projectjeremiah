<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;


class Counselor extends Model
{
    //
    protected $fillable = ['name', 'department', 'image', 'email', 'ms_teams_account'];

    public function schedules()
    {
        return $this->hasMany(CounselorSchedule::class);
    }
}
