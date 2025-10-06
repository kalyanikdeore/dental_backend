<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseUs;
use Illuminate\Http\JsonResponse;

class WhyChooseUsController extends Controller
{
    public function index(): JsonResponse
    {
        $reasons = WhyChooseUs::all();
        return response()->json([
            'status' => true,
            'data' => $reasons,
        ]);
    }
}
