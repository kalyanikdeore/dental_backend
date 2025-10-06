<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(GalleryCategory::class, 'clinic_id');
    }

    public function activeCategories()
    {
        return $this->categories()->where('is_active', true)->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
