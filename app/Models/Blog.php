<?php
// app/Models/Blog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category',
        'author',
        'author_role',
        'author_image',
        'published_date',
        'read_time',
        'tags',
        'is_published',
        'views',
    ];

    protected $casts = [
        'published_date' => 'date',
        'tags' => 'array',
        'is_published' => 'boolean',
    ];

    // Accessor for full image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Check if it's already a full URL (for seeded data)
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            return asset('uploads/' . $this->image);
        }
        return null;
    }

    // Accessor for full author image URL
    public function getAuthorImageUrlAttribute()
    {
        if ($this->author_image) {
            // Check if it's already a full URL (for seeded data)
            if (filter_var($this->author_image, FILTER_VALIDATE_URL)) {
                return $this->author_image;
            }
            return asset('uploads/' . $this->author_image);
        }
        return null;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_date', 'desc');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}