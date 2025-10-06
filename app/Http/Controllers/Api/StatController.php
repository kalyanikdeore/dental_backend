<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\JsonResponse;

class StatController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $stats = Stat::active()
                        ->ordered()
                        ->get();

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Stats retrieved successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve stats: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve stats',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
