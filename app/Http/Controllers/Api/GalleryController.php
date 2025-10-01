<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display clinic gallery data for React component
     */
    public function clinicGallery($clinicSlug)
    {
        $clinic = Clinic::where('slug', $clinicSlug)
            ->active()
            ->firstOrFail();

        // Get all active categories with their active images
        $categories = $clinic->activeCategories()
            ->with(['activeImages'])
            ->get();

        // Transform data to match React component structure
        $images = [];
        foreach ($categories as $category) {
            foreach ($category->activeImages as $image) {
                $images[] = [
                    'id' => $image->id,
                    'src' => $image->image_url,
                    'alt' => $image->alt_text,
                    'category' => $category->name,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'clinic' => [
                'name' => $clinic->name,
            ],
            'images' => $images
        ]);
    }

    /**
     * Get all clinics for navigation
     */
    public function clinics()
    {
        $clinics = Clinic::active()
            ->get()
            ->map(function($clinic) {
                return [
                    'slug' => $clinic->slug,
                    'name' => $clinic->name,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $clinics
        ]);
    }

    /**
     * Get unique categories for a clinic (for filter buttons)
     */
    public function clinicCategories($clinicSlug)
    {
        $clinic = Clinic::where('slug', $clinicSlug)
            ->active()
            ->firstOrFail();

        $categories = $clinic->activeCategories()
            ->pluck('name')
            ->unique()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }
}