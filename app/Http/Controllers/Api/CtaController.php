<?php
// app/Http/Controllers/CtaController.php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Cta;
use Illuminate\Http\JsonResponse;

class CtaController extends Controller
{   
    /**
     * Get active CTA data
     */
    public function getActive(): JsonResponse
    {
        try {
            $cta = Cta::where('is_active', true)->first();
            
            if (!$cta) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active CTA found',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $cta
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch CTA data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get CTA by ID
     */
    public function show($id): JsonResponse
    {
        try {
            $cta = Cta::find($id);
            
            if (!$cta) {
                return response()->json([
                    'success' => false,
                    'message' => 'CTA not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $cta
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch CTA data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all CTAs (for admin purposes)
     */
    public function index(): JsonResponse
    {
        try {
            $ctas = Cta::all();

            return response()->json([
                'success' => true,
                'data' => $ctas
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch CTAs',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}