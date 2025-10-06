<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cta_highlight',
        'appointment_link',
        'video_url',
        'video_file',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getVideoSourceAttribute()
    {
        if ($this->video_file) {
            return asset('uploads/' . $this->video_file);
        }
        return $this->video_url;
    }
}
