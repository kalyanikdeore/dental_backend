<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppointmentTreatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'treatment_id' => 'required|exists:treatments,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'clinic_location' => 'required|string',
            'preferred_date' => 'required|date',
            'preferred_time' => 'required',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $appointment = AppointmentTreatment::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Appointment booked successfully',
            'data' => $appointment
        ], 201);
    }
}