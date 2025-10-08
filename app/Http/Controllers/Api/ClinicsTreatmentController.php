<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClinicsTreatment;
use Illuminate\Http\Request;

class ClinicsTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $clinics = ClinicsTreatment::active()
                ->ordered()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $clinics,
                'message' => 'Clinics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve clinics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:clinics_treatments',
                'address' => 'required|string',
                'phone' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
                'hours' => 'required|string|max:255',
                'map_embed' => 'required|string',
                'latitude' => 'nullable|string|max:50',
                'longitude' => 'nullable|string|max:50',
                'is_active' => 'boolean',
                'order' => 'integer|min:0',
            ]);

            $clinic = ClinicsTreatment::create($validated);

            return response()->json([
                'success' => true,
                'data' => $clinic,
                'message' => 'Clinic created successfully'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create clinic',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $clinic = ClinicsTreatment::find($id);

            if (!$clinic) {
                return response()->json([
                    'success' => false,
                    'message' => 'Clinic not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $clinic,
                'message' => 'Clinic retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve clinic',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $clinic = ClinicsTreatment::find($id);

            if (!$clinic) {
                return response()->json([
                    'success' => false,
                    'message' => 'Clinic not found'
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'slug' => 'sometimes|string|max:255|unique:clinics_treatments,slug,' . $id,
                'address' => 'sometimes|string',
                'phone' => 'sometimes|string|max:20',
                'email' => 'nullable|email|max:255',
                'hours' => 'sometimes|string|max:255',
                'map_embed' => 'sometimes|string',
                'latitude' => 'nullable|string|max:50',
                'longitude' => 'nullable|string|max:50',
                'is_active' => 'boolean',
                'order' => 'integer|min:0',
            ]);

            $clinic->update($validated);

            return response()->json([
                'success' => true,
                'data' => $clinic,
                'message' => 'Clinic updated successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update clinic',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $clinic = ClinicsTreatment::find($id);

            if (!$clinic) {
                return response()->json([
                    'success' => false,
                    'message' => 'Clinic not found'
                ], 404);
            }

            $clinic->delete();

            return response()->json([
                'success' => true,
                'message' => 'Clinic deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete clinic',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get clinic by slug
     */
    public function showBySlug($slug)
    {
        try {
            $clinic = ClinicsTreatment::active()->where('slug', $slug)->first();

            if (!$clinic) {
                return response()->json([
                    'success' => false,
                    'message' => 'Clinic not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $clinic,
                'message' => 'Clinic retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve clinic',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}