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
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically deactivate other sections when activating one
        static::updating(function ($heroSection) {
            if ($heroSection->isDirty('is_active') && $heroSection->is_active) {
                static::where('id', '!=', $heroSection->id)
                      ->where('is_active', true)
                      ->update(['is_active' => false]);
            }
        });

        // Handle creation - ensure only one active
        static::creating(function ($heroSection) {
            if ($heroSection->is_active) {
                static::where('is_active', true)->update(['is_active' => false]);
            }
        });
    }

    public function getVideoSourceAttribute()
    {
        if ($this->video_file) {
            return asset('storage/' . $this->video_file);
        }
        
        return $this->video_url;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    // Get the currently active hero section
    public static function getActive()
    {
        return static::active()->first();
    }
}