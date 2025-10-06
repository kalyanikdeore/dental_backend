<?php
// app/Http/Controllers/Api/WhyChooseUsController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseUsPoint;
use Illuminate\Http\JsonResponse;

class WhyChooseUsPointController extends Controller
{
    public function index(): JsonResponse
    {
        $points = WhyChooseUsPoint::active()
            ->ordered()
            ->get()
            ->map(function ($point) {
                return [
                    'title' => $point->title,
                    'description' => $point->point, // Changed from 'point' to 'description'
                    'icon' => $point->icon,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $points
        ]);
    }
}