<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WelcomeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'highlights',
        'cta_text',
        'cta_link',
    ];

    protected $casts = [
        'highlights' => 'array',
    ];
}