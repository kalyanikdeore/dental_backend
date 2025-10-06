<?php
// app/Http/Controllers/Api/DoctorFaqController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoctorFaq;
use Illuminate\Http\JsonResponse;

class DoctorFaqController extends Controller
{
    public function index(): JsonResponse
    {
        $faqs = DoctorFaq::active()
            ->ordered()
            ->get()
            ->map(function ($faq) {
                return [
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $faqs
        ]);
    }
}