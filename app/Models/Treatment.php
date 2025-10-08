<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'seo_key',
        'meta_title',
        'meta_description',
        'meta_url',
        'h1',
        'intro',
        'hero_image',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

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

    public function appointments(): HasMany
    {
        return $this->hasMany(AppointmentTreatment::class);
    }

    // Scope for active treatments
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for navbar (only basic info needed)
    public function scopeForNavbar($query)
    {
        return $query->active()
                    ->select('id', 'slug', 'h1 as label')
                    ->orderBy('order');
    }

    // Find by slug
    public static function findBySlug($slug)
    {
        return static::with(['sections', 'faqs', 'whyChooseItems'])->where('slug', $slug)->first();
    }
}