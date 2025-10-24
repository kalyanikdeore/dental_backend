<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WelcomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

            // Add full image URLs
            $welcomeSectionData = $welcomeSection->toArray();
            $welcomeSectionData['image_1_url'] = $welcomeSection->image_1 ? Storage::disk('public')->url($welcomeSection->image_1) : null;
            $welcomeSectionData['image_2_url'] = $welcomeSection->image_2 ? Storage::disk('public')->url($welcomeSection->image_2) : null;
            $welcomeSectionData['image_3_url'] = $welcomeSection->image_3 ? Storage::disk('public')->url($welcomeSection->image_3) : null;

            return response()->json([
                'success' => true,
                'data' => $welcomeSectionData
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
            'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image uploads
        if ($request->hasFile('image_1')) {
            $validated['image_1'] = $request->file('image_1')->store('welcome-section', 'public');
        }
        if ($request->hasFile('image_2')) {
            $validated['image_2'] = $request->file('image_2')->store('welcome-section', 'public');
        }
        if ($request->hasFile('image_3')) {
            $validated['image_3'] = $request->file('image_3')->store('welcome-section', 'public');
        }

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
            'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image uploads
        if ($request->hasFile('image_1')) {
            // Delete old image
            if ($welcomeSection->image_1) {
                Storage::disk('public')->delete($welcomeSection->image_1);
            }
            $validated['image_1'] = $request->file('image_1')->store('welcome-section', 'public');
        }
        if ($request->hasFile('image_2')) {
            // Delete old image
            if ($welcomeSection->image_2) {
                Storage::disk('public')->delete($welcomeSection->image_2);
            }
            $validated['image_2'] = $request->file('image_2')->store('welcome-section', 'public');
        }
        if ($request->hasFile('image_3')) {
            // Delete old image
            if ($welcomeSection->image_3) {
                Storage::disk('public')->delete($welcomeSection->image_3);
            }
            $validated['image_3'] = $request->file('image_3')->store('welcome-section', 'public');
        }

        $welcomeSection->update($validated);

        return redirect()->route('welcome-sections.index')
            ->with('success', 'Welcome section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WelcomeSection $welcomeSection)
    {
        // Delete images before deleting the record
        if ($welcomeSection->image_1) {
            Storage::disk('public')->delete($welcomeSection->image_1);
        }
        if ($welcomeSection->image_2) {
            Storage::disk('public')->delete($welcomeSection->image_2);
        }
        if ($welcomeSection->image_3) {
            Storage::disk('public')->delete($welcomeSection->image_3);
        }

        $welcomeSection->delete();

        return redirect()->route('welcome-sections.index')
            ->with('success', 'Welcome section deleted successfully.');
    }
}