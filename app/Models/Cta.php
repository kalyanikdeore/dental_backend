<?php
// app/Models/Cta.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cta extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'clinic1_name',
        'clinic1_address',
        'clinic1_phone1',
        'clinic1_phone2',
        'clinic1_hours',
        'clinic2_name',
        'clinic2_address',
        'clinic2_phone1',
        'clinic2_phone2',
        'clinic2_hours',
        'background_color',
        'text_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Get active CTA
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }
}