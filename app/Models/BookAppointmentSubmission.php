<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAppointmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'preferred_service',
        'preferred_date',
        'preferred_clinic',
        'message'
    ];
}