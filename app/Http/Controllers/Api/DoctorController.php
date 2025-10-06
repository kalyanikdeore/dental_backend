<?php
// app/Http/Controllers/Api/DoctorController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;

class DoctorController extends Controller
{
    public function index(): JsonResponse
    {
        $doctors = Doctor::active()
            ->ordered()
            ->get()
            ->map(function ($doctor) {
                // Convert achievements objects to simple array of strings
                $achievements = collect($doctor->achievements ?? [])
                    ->pluck('achievement')
                    ->filter()
                    ->toArray();

                return [
                    'id' => $doctor->id,
                    'name' => $doctor->name,
                    'title' => $doctor->title,
                    'experience' => $doctor->experience,
                    'specialization' => $doctor->specialization,
                    'achievements' => $achievements,
                    'seo_keywords' => $doctor->seo_keywords,
                    'description' => $doctor->description,
                    'image' => $doctor->image ? asset('uploads/' . $doctor->image) : null,
                    'alt' => $doctor->alt_text,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $doctors
        ]);
    }

    public function show(Doctor $doctor): JsonResponse
    {
        // Convert achievements objects to simple array of strings
        $achievements = collect($doctor->achievements ?? [])
            ->pluck('achievement')
            ->filter()
            ->toArray();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'title' => $doctor->title,
                'experience' => $doctor->experience,
                'specialization' => $doctor->specialization,
                'achievements' => $achievements,
                'seo_keywords' => $doctor->seo_keywords,
                'description' => $doctor->description,
                'image' => $doctor->image ? asset('uploads/' . $doctor->image) : null,
                'alt' => $doctor->alt_text,
            ]
        ]);
    }
}