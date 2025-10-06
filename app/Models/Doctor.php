<?php
// app/Models/Doctor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'experience',
        'specialization',
        'achievements',
        'seo_keywords',
        'description',
        'image',
        'alt_text',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'achievements' => 'array',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}