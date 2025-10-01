<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GalleryController;


Route::prefix('api')->group(function() {
  Route::get('/gallery/clinics', [GalleryController::class, 'clinics']);
  Route::get('/gallery/clinic/{clinicSlug}', [GalleryController::class, 'clinicGallery']);
  Route::get('/gallery/clinic/{clinicSlug}/categories', [GalleryController::class, 'clinicCategories']);

});

// Route::get('/', function () {
    
//   Route::get('/hero-sections', [HeroSectionController::class, 'index']);
//   // routes/api.php
//   Route::get('/gallery/clinics', [GalleryController::class, 'clinics']);
//   Route::get('/gallery/clinic/{clinicSlug}', [GalleryController::class, 'clinicGallery']);
//   Route::get('/gallery/clinic/{clinicSlug}/categories', [GalleryController::class, 'clinicCategories']);
  
// });
