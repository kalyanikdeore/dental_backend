<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicsTreatment extends Model
{
    use HasFactory;

    protected $table = 'clinics_treatments';

    protected $fillable = [
        'name', 'slug', 'address', 'phone', 'email', 
        'hours', 'map_embed', 'is_active', 'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}