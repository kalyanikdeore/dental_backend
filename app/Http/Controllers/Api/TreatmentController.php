<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use App\Models\AppointmentTreatment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class TreatmentController extends Controller
{
    /**
     * Get all treatments with related data
     */
    public function index(): JsonResponse   
    {
        try {
            Log::info('Fetching all treatments');
            
            $treatments = Treatment::with([
                'sections' => function($query) {
                    $query->orderBy('order');
                },
                'faqs' => function($query) {
                    $query->orderBy('order');
                },
                'whyChooseItems' => function($query) {
                    $query->orderBy('order');
                },
                'appointmentTreatments' // FIXED: Now matches the relationship name
            ])
            ->active()
            ->orderBy('order')
            ->get();

            Log::info('Successfully fetched ' . $treatments->count() . ' treatments');

            return response()->json([
                'success' => true,
                'data' => $treatments,
                'count' => $treatments->count()
            ]);

        } catch (Exception $e) {
            Log::error('Treatment index error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch treatments',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get treatment by slug (using route model binding)
     */
    public function show(Treatment $treatment): JsonResponse
    {
        try {
            Log::info('Fetching treatment by slug: ' . $treatment->slug);
            
            // Eager load all relationships
            $treatment->load([
                'sections' => function($query) {
                    $query->orderBy('order');
                },
                'faqs' => function($query) {
                    $query->orderBy('order');
                },
                'whyChooseItems' => function($query) {
                    $query->orderBy('order');
                },
                'appointmentTreatments' // FIXED: Now matches the relationship name
            ]);

            // Check if treatment is active
            if (!$treatment->is_active) {
                Log::warning('Treatment is inactive: ' . $treatment->slug);
                return response()->json([
                    'success' => false,
                    'message' => 'Treatment not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $treatment
            ]);

        } catch (Exception $e) {
            Log::error('Treatment show error for slug ' . $treatment->slug . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch treatment',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get FAQs for a specific treatment
     */
    public function treatmentFaqs(Treatment $treatment): JsonResponse
    {
        try {
            Log::info('Fetching FAQs for treatment: ' . $treatment->slug);
            
            if (!$treatment->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Treatment not found'
                ], 404);
            }

            $faqs = $treatment->faqs()->orderBy('order')->get();

            return response()->json([
                'success' => true,
                'data' => $faqs
            ]);

        } catch (Exception $e) {
            Log::error('Treatment FAQs error for slug ' . $treatment->slug . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch FAQs',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get why choose us items for a treatment
     */
    public function whyChooseUs(Treatment $treatment): JsonResponse
    {
        try {
            Log::info('Fetching why choose us for treatment: ' . $treatment->slug);
            
            if (!$treatment->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Treatment not found'
                ], 404);
            }

            $whyChooseItems = $treatment->whyChooseItems()->orderBy('order')->get();

            return response()->json([
                'success' => true,
                'data' => $whyChooseItems
            ]);

        } catch (Exception $e) {
            Log::error('Why choose us error for slug ' . $treatment->slug . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch why choose us data',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get appointments for a specific treatment
     */
    public function treatmentAppointments(Treatment $treatment): JsonResponse
    {
        try {
            Log::info('Fetching appointments for treatment: ' . $treatment->slug);
            
            if (!$treatment->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Treatment not found'
                ], 404);
            }

            // FIXED: Now using appointmentTreatments which matches the relationship name
            $appointments = $treatment->appointmentTreatments()->orderBy('preferred_date', 'desc')->get();

            return response()->json([
                'success' => true,
                'treatment' => $treatment->h1,
                'data' => $appointments
            ]);

        } catch (Exception $e) {
            Log::error('Treatment appointments error for slug ' . $treatment->slug . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch appointments',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get treatments for navbar dropdown
     */
    public function navbarTreatments(): JsonResponse
    {
        try {
            $treatments = Treatment::forNavbar()->get();
            
            return response()->json([
                'success' => true,
                'data' => $treatments
            ]);

        } catch (Exception $e) {
            Log::error('Navbar treatments error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch navbar treatments'
            ], 500);
        }
    }
}