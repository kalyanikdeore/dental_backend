<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookAppointmentController;
use App\Http\Controllers\Api\DoctorAppointmentController;


// Book appointment routes
Route::post('/book-appointment', [BookAppointmentController::class, 'store']);
Route::get('/book-appointment', [BookAppointmentController::class, 'index']);
Route::get('/doctor-appointments', [DoctorAppointmentController::class, 'index']);
Route::post('/doctor-appointments', [DoctorAppointmentController::class, 'store']);



// Test route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});
