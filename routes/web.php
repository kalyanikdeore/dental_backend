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
use App\Http\Controllers\Api\TreatmentController;
use App\Http\Controllers\Api\ClinicsTreatmentController;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ContactInformationController;
// use App\Http\Controllers\Api\BookAppointmentController;
use App\Http\Controllers\Api\PopupController;
use App\Http\Controllers\Api\CtaController;

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
 Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/   /categories', [BlogController::class, 'categories']);
    Route::get('/blogs/{slug}', [BlogController::class, 'show']);
    Route::get('/blogs/{slug}/recent', [BlogController::class, 'recentPosts']);
Route::get('/about-story', [AboutController::class, 'getStory']);
Route::get('/vision-mission', [AboutController::class, 'getVisionMission']); 
Route::get('/team-members', [AboutController::class, 'getTeamMembers']);
Route::get('/contact-information', [ContactInformationController::class, 'index']);
Route::get('/active-popup', [PopupController::class, 'getActivePopup']);
Route::get('/cta', [CtaController::class, 'index']); 

// Treatment routes with slug support
Route::get('/treatments', [TreatmentController::class, 'index']);
Route::get('/treatments/{treatment}', [TreatmentController::class, 'show']); // This now uses slug automatically
Route::get('/treatments/{treatment}/faqs', [TreatmentController::class, 'treatmentFaqs']);
Route::get('/treatments/{treatment}/why-choose-us', [TreatmentController::class, 'whyChooseUs']);
Route::get('/treatments/{treatment}/appointments', [TreatmentController::class, 'treatmentAppointments']);

});


