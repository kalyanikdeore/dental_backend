<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HeroSectionController;

Route::get('/', function () {
    
  Route::get('/hero-sections', [HeroSectionController::class, 'index']);
  
});
