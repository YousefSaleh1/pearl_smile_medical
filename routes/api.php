<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GalaryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MedicalTeamController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('subscriber',[SubscriberController::class,'store']);

Route::post('booking',[BookingController::class,'store']);

Route::get('offers', [OfferController::class, 'index']);

Route::get('servicses-slider', [ServiceController::class, 'index']);

Route::get('clinic-info', [ServiceController::class, 'getClinicInfo']);

Route::get('specialties-slider', [MedicalTeamController::class, 'index']);

Route::get('contacts-info', [AboutController::class, 'getContactsInfo']);

Route::get('about-us', [AboutController::class, 'getAboutUs']);

Route::get('photo-gallery', [GalleryController::class, 'photoGallery']);

Route::get('video-gallery', [GalleryController::class, 'videoGallery']);
