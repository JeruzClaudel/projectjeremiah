<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    //
    protected $fillable = ['name', 'description', 'consultations_id'];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultations_id');
    }
}


