<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index()
    {
        $treatments = Treatment::active()
            ->with(['sections', 'faqs', 'whyChooseItems'])
            ->orderBy('order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $treatments
        ]);
    }

    public function show($id)
    {
        $treatment = Treatment::with(['sections', 'faqs', 'whyChooseItems'])->find($id);

        if (!$treatment) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $treatment
        ]);
    }

    public function showBySlug($slug)
    {
        $treatment = Treatment::active()
            ->with(['sections', 'faqs', 'whyChooseItems'])
            ->where('slug', $slug)
            ->first();

        if (!$treatment) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $treatment
        ]);
    }

    public function navbarTreatments()
    {
        $treatments = Treatment::forNavbar()->get();

        return response()->json([
            'success' => true,
            'data' => $treatments
        ]);
    }

    // New method for complete navigation structure
    public function navigationMenu()
    {
        $treatments = Treatment::forNavbar()->get();

        $menu = [
            'label' => 'Treatments',
            'submenu' => $treatments->map(function ($treatment) {
                return [
                    'label' => $treatment->label,
                    'path' => "/treatments/{$treatment->slug}"
                ];
            })->toArray()
        ];

        return response()->json([
            'success' => true,
            'data' => $menu
        ]);
    }

    // Add the missing whyChooseUs method
    public function whyChooseUs($slug)
    {
        $treatment = Treatment::active()
            ->with(['whyChooseItems' => function($query) {
                $query->orderBy('order', 'asc');
            }])
            ->where('slug', $slug)
            ->first();

        if (!$treatment) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $treatment->whyChooseItems
        ]);
    }
}