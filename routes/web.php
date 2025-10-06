<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\WelcomeSectionController;
use App\Http\Controllers\Api\ServiceController; 
use App\Http\Controllers\Api\WhyChooseUsController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\StatController;
use App\Http\Controllers\Api\PatientSafetyController;
use App\Http\Controllers\Api\HeroSectionController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\DoctorFaqController;
use App\Http\Controllers\Api\WhyChooseUsPointController;
use App\Http\Controllers\Api\PageSettingController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\BlogPostController;


Route::prefix('api')->group(function() {
Route::get('/gallery/clinics', [GalleryController::class, 'clinics']);
Route::get('/gallery/clinic/{slug}', [GalleryController::class, 'clinicGallery']);
Route::get('/gallery/clinic/{slug}/categories', [GalleryController::class, 'clinicCategories']);
Route::get('/hero-section', [HeroSectionController::class, 'index']); 
Route::get('/welcome-section', [WelcomeSectionController::class, 'getWelcomeSection']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/why-choose-us', [WhyChooseUsController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/faqs', [FaqController::class, 'index']);
Route::get('/stats', [StatController::class, 'index']);
Route::get('/patient-safety', [PatientSafetyController::class, 'index']);
Route::get('/patient-safety/{id}', [PatientSafetyController::class, 'show']);
Route::get('/doctors', [DoctorController::class, 'index']);
Route::get('/doctors/{doctor}', [DoctorController::class, 'show']);
Route::get('/doctor-faqs', [DoctorFaqController::class, 'index']);
Route::get('/why-choose-us-points', [WhyChooseUsPointController::class, 'index']);
Route::get('/page-settings', [PageSettingController::class, 'index']);
Route::post('/page-settings', [PageSettingController::class, 'store']);
Route::post('/page-settings/{id}/activate', [PageSettingController::class, 'activate']);
Route::get('/blog', [BlogController::class, 'index']); 
Route::get('/blog/recent', [BlogController::class, 'recent']); 
Route::get('/blog/categories', [BlogController::class, 'categories']); 
Route::get('/blog/category/{category}', [BlogController::class, 'byCategory']);
Route::get('/blog/{slug}', [BlogController::class, 'show']);
});

// Route::get('/', function () {
    
//   Route::get('/hero-sections', [HeroSectionController::class, 'index']);
//   // routes/api.php
//   Route::get('/gallery/clinics', [GalleryController::class, 'clinics']);
//   Route::get('/gallery/clinic/{clinicSlug}', [GalleryController::class, 'clinicGallery']);
//   Route::get('/gallery/clinic/{clinicSlug}/categories', [GalleryController::class, 'clinicCategories']);
  
// });
