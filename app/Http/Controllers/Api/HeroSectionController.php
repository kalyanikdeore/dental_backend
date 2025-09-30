<?php

namespace App\Http\Controllers\Api;

use App\Models\HeroSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    public function index()
    {
        try {
            // Get only the active hero section
            $heroSection = HeroSection::getActive();
            
            if (!$heroSection) {
                return response()->json([
                    'success' => true,
                    'data' => null,
                    'message' => 'No active hero section found'
                ], 200);
            }

            return response()->json([
                'success' => true,
                'data' => $heroSection,
                'message' => 'Active hero section retrieved successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve hero section',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $heroSection = HeroSection::find($id);
            
            if (!$heroSection) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hero section not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $heroSection,
                'message' => 'Hero section retrieved successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve hero section',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'cta_highlight' => 'required|string|max:255',
                'appointment_link' => 'required|string',
                'video_url' => 'nullable|url',
                'video_file' => 'nullable|string',
                'is_active' => 'boolean',
                'sort_order' => 'integer'
            ]);

            $heroSection = HeroSection::create($validated);

            return response()->json([
                'success' => true,
                'data' => $heroSection,
                'message' => 'Hero section created successfully'
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create hero section',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // New method to activate a specific hero section
    public function activate($id)
    {
        try {
            $heroSection = HeroSection::find($id);
            
            if (!$heroSection) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hero section not found'
                ], 404);
            }

            $heroSection->update(['is_active' => true]);

            return response()->json([
                'success' => true,
                'data' => $heroSection,
                'message' => 'Hero section activated successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to activate hero section',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // New method to get all hero sections (for admin purposes)
    public function getAll()
    {
        try {
            $heroSections = HeroSection::ordered()->get();
            
            return response()->json([
                'success' => true,
                'data' => $heroSections,
                'message' => 'All hero sections retrieved successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve hero sections',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}