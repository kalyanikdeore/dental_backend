<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_name',
        'title',
        'subtitle',
        'content',
        'image',
        'features',
        'is_active',
        'order'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Scope a query to only include active sections.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by order column.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}