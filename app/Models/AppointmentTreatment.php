<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentTreatment extends Model
{
    use HasFactory;

    protected $table = 'appointment_treatments';

    protected $fillable = [
        'treatment_id', 'name', 'deolali_phone', 'nashik_phone',
        'preferred_date', 'preferred_time'
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}