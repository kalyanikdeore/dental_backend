<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentTreatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'treatment_id',
        'name',
        'email',
        'phone',
        'clinic_location',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'preferred_time' => 'datetime:H:i',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}