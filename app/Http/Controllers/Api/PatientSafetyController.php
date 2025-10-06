<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\PatientSafetySection;
use Illuminate\Http\JsonResponse;

class PatientSafetyController extends Controller
{
    /**
     * Display a listing of patient safety sections.
     */
    public function index(): JsonResponse
    {
        $sections = PatientSafetySection::active()
            ->ordered()
            ->get();

        return response()->json($sections);
    }

    /**
     * Display the specified patient safety section.
     */
    public function show($id): JsonResponse
    {
        $section = PatientSafetySection::active()->find($id);

        if (!$section) {
            return response()->json(['error' => 'Section not found'], 404);
        }

        return response()->json($section);
    }
}