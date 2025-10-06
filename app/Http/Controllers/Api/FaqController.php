<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    public function index(): JsonResponse
    {
        $faqs = Faq::all();
        return response()->json([
            'status' => true,
            'data' => $faqs,
        ]);
    }
}
