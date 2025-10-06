<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GalleryController extends Controller
{
    public function clinics()
    {
        $clinics = Clinic::active()->get(['id', 'name', 'slug']);
        return response()->json([
            'success' => true,
            'data' => $clinics
        ]);
    }

    public function clinicGallery($clinicSlug)
    {
        try {
            $clinic = Clinic::where('slug', $clinicSlug)->active()->firstOrFail();

            $categories = $clinic->categories()->active()->with(['images' => function($q) {
                $q->active()->ordered();
            }])->ordered()->get();

            $images = [];
            foreach ($categories as $category) {
                foreach ($category->images as $image) {
                    $images[] = [
                        'id' => $image->id,
                        'src' => $image->image_url,
                        'alt' => $image->alt_text ?: $category->name,
                        'category' => $category->name,
                        'category_id' => $category->id
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'clinic' => $clinic,
                    'categories' => $categories->pluck('name'),
                    'images' => $images,
                    'total_images' => count($images)
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Clinic not found'
            ], 404);
        }
    }

    public function clinicCategories($clinicSlug)
    {
        try {
            $clinic = Clinic::where('slug', $clinicSlug)->active()->firstOrFail();
            $categories = $clinic->categories()->active()->pluck('name');
            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Clinic not found'
            ], 404);
        }
    }
}
