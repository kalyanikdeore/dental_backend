<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use Illuminate\Http\Request;

class PageSettingController extends Controller
{
    /**
     * API endpoint to get page settings
     */
    public function index()
    {
        try {
            $pageSettings = PageSetting::where('is_active', true)->first();
            
            if (!$pageSettings) {
                // Return empty structure if no active settings found
                return response()->json([
                    'data' => null,
                    'message' => 'No active page settings found'
                ]);
            }

            return response()->json([
                'data' => [
                    'page' => [
                        'title' => $pageSettings->page_title,
                        'description' => $pageSettings->page_description,
                        'seo_keywords' => $pageSettings->seo_keywords,
                    ],
                    'cta' => [
                        'title' => $pageSettings->cta_title,
                        'description' => $pageSettings->cta_description,
                        'phone' => $pageSettings->phone,
                        'address' => $pageSettings->address,
                    ]
                ],
                'message' => 'Page settings retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'Error retrieving page settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activate specific page settings
     */
    public function activate($id)
    {
        try {
            // Deactivate all settings
            PageSetting::query()->update(['is_active' => false]);
            
            // Activate the selected one
            $pageSetting = PageSetting::findOrFail($id);
            $pageSetting->update(['is_active' => true]);
            
            return response()->json([
                'message' => 'Page settings activated successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error activating page settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store new page settings
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'page_title' => 'required|string|max:255',
                'page_description' => 'required|string',
                'seo_keywords' => 'required|string',
                'cta_title' => 'required|string|max:255',
                'cta_description' => 'required|string',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'is_active' => 'boolean',
            ]);

            // If setting this as active, deactivate others
            if ($request->is_active) {
                PageSetting::query()->update(['is_active' => false]);
            }

            $pageSetting = PageSetting::create($validated);

            return response()->json([
                'data' => $pageSetting,
                'message' => 'Page settings created successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating page settings: ' . $e->getMessage()
            ], 500);
        }
    }
}