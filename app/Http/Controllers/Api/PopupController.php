<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\JsonResponse;

class PopupController extends Controller
{
    public function getActivePopup(): JsonResponse
    {
        try {
            $popup = Popup::where('is_active', true)->first();
            
            if (!$popup) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active popup found',
                    'data' => null
                ]);
            }

            // Format features properly
            $features = collect($popup->features ?? [])->map(function ($feature) {
                return is_array($feature) ? $feature : ['text' => $feature];
            })->toArray();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $popup->id,
                    'title' => $popup->title,
                    'description' => $popup->description,
                    'image_url' => $popup->image ? asset('uploads/' . $popup->image) : null,
                    'button_text' => $popup->button_text,
                    'redirect_url' => $popup->redirect_url,
                    'features' => $features,
                    'display_delay' => $popup->display_delay,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}