dental@gmail.com
dental@123

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookAppointmentController;


// Book appointment routes
Route::post('/book-appointment', [BookAppointmentController::class, 'store']);
Route::get('/book-appointment', [BookAppointmentController::class, 'index']);

// Test route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});
