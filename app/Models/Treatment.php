<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'seo_key', 'meta_title', 'meta_description', 'meta_url',
        'h1', 'intro', 'hero_image', 'is_active', 'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Automatically generate slug when creating/updating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($treatment) {
            if (empty($treatment->slug)) {
                $treatment->slug = $treatment->generateUniqueSlug($treatment->h1);
            }
        });

        static::updating(function ($treatment) {
            if ($treatment->isDirty('h1') && empty($treatment->slug)) {
                $treatment->slug = $treatment->generateUniqueSlug($treatment->h1, $treatment->id);
            }
        });
    }

    /**
     * Generate unique slug
     */
    public function generateUniqueSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug, $id)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if slug exists
     */
    private function slugExists($slug, $id = null)
    {
        $query = static::where('slug', $slug);
        
        if ($id) {
            $query->where('id', '!=', $id);
        }

        return $query->exists();
    }

    // Relationships
    public function sections(): HasMany
    {
        return $this->hasMany(TreatmentSection::class)->orderBy('order');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(FaqsTreatment::class)->orderBy('order');
    }

    public function whyChooseItems(): HasMany
    {
        return $this->hasMany(WhyChooseTreatment::class)->orderBy('order');
    }

    /**
     * Relationship with appointments - FIXED: Using appointmentTreatments to match your calls
     */
    public function appointmentTreatments(): HasMany
    {
        return $this->hasMany(AppointmentTreatment::class)->orderBy('preferred_date', 'desc');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForNavbar($query)
    {
        return $query->active()->orderBy('order')->select(['id', 'h1 as label', 'slug']);
    }
}