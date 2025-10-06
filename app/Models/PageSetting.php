<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_title',
        'page_description',
        'seo_keywords',
        'cta_title',
        'cta_description',
        'phone',
        'address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}