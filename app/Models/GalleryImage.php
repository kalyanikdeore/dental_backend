<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'image',
        'alt_text',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        if (file_exists(public_path('uploads/' . $this->image))) {
            return asset('uploads/' . $this->image);
        }

        return null;
    }
}
