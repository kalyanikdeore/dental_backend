<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookAppointmentSubmission; // Fixed: Use correct model

class BookAppointmentController extends Controller
{
    // Optional GET endpoint to view all appointments
    public function index()
    {
        return BookAppointmentSubmission::all(); // Fixed model name
    }

    // POST endpoint to save a new appointment
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'preferred_service' => 'required|string',
            'preferred_date' => 'nullable|date',
            'preferred_clinic' => 'required|string',
            'message' => 'nullable|string',
        ]);

        $appointment = BookAppointmentSubmission::create([ // Fixed model name
            'name' => $request->name,
            'phone' => $request->phone,
            'preferred_service' => $request->preferred_service,
            'preferred_date' => $request->preferred_date,
            'preferred_clinic' => $request->preferred_clinic,
            'message' => $request->message,
        ]);

        return response()->json($appointment, 201);
    }
}