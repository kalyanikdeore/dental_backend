<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClinicsTreatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ClinicsTreatmentController extends Controller
{
    public function index()
    {
        try {
            $clinics = ClinicsTreatment::where('is_active', true)
                ->orderBy('order')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $clinics
            ]);

        } catch (Exception $e) {
            Log::error('Clinics index error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch clinics'
            ], 500);
        }
    }
}