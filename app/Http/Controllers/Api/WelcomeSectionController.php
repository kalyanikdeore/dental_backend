<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WelcomeSection;
use Illuminate\Http\Request;

class WelcomeSectionController extends Controller
{
    /**
     * Get welcome section data for API
     */
    public function getWelcomeSection()
    {
        try {
            $welcomeSection = WelcomeSection::first();
            
            if (!$welcomeSection) {
                return response()->json([
                    'success' => false,
                    'message' => 'Welcome section not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $welcomeSection
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching welcome section: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching welcome section',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $welcomeSections = WelcomeSection::all();
        return view('welcome-sections.index', compact('welcomeSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('welcome-sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'highlights' => 'required|array',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
        ]);

        WelcomeSection::create($validated);

        return redirect()->route('welcome-sections.index')
            ->with('success', 'Welcome section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WelcomeSection $welcomeSection)
    {
        return view('welcome-sections.show', compact('welcomeSection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WelcomeSection $welcomeSection)
    {
        return view('welcome-sections.edit', compact('welcomeSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WelcomeSection $welcomeSection)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'highlights' => 'required|array',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
        ]);

        $welcomeSection->update($validated);

        return redirect()->route('welcome-sections.index')
            ->with('success', 'Welcome section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WelcomeSection $welcomeSection)
    {
        $welcomeSection->delete();

        return redirect()->route('welcome-sections.index')
            ->with('success', 'Welcome section deleted successfully.');
    }
}