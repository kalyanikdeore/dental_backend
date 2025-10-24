<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'button_text',
        'redirect_url',
        'features',
        'is_active',
        'display_delay',
    ];

    protected $attributes = [
        'features' => '[]',
        'is_active' => true,
        'display_delay' => 1000,
        'button_text' => 'Learn More',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    // Get active popup
    public static function getActivePopup()
    {
        return static::where('is_active', true)->first();
    }

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('uploads/' . $this->image);
        }
        return null;
    }
}