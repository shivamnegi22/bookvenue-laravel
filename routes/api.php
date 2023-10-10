<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginAuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Facility\facilityController;
use App\Http\Controllers\Api\Management\managementController;
use App\Http\Controllers\Api\Search\SearchController;

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

    //login route
    Route::post('/login', [LoginAuthController::class, 'login']);
    Route::post('/verify-otp', [LoginAuthController::class, 'verifyOTP']);

    //signup route
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/verify-register-user', [RegisterController::class, 'verifyuser']);
    Route::post('/searchLocation', [SearchController::class, 'searchLocation']);

        //create sports route
    Route::post('/create-sports', [managementController::class, 'createSports']);

    //create venue route
    Route::post('/create-venue', [managementController::class, 'createVenue']);
    
    //facility get route
    Route::get('/get-recent-facility/{count}', [facilityController::class, 'recentFacility']);
    Route::get('/get-featured-facility/{count}', [facilityController::class, 'featuredFacility']);

    Route::post('/createFacility', [facilityController::class, 'createFacility']);

    //profile update route
    Route::post('/profileUpdate', [managementController::class, 'profileUpdate']);

    //get user role route
    Route::get('/get-user-role', [managementController::class, 'getUserRole']);

    //get facilty venue route
    Route::get('/facility-venue', [facilityController::class, 'getFacilityVenue']);
    Route::post('/facility-venue', [facilityController::class, 'createFacilityVenue']);

    //get facilty sports route
    Route::get('/facility-sports', [facilityController::class, 'getFacilitySports']);
    Route::post('/facility-sports', [facilityController::class, 'createFaciltiySports']);

    //get facilty sports route
    Route::get('/facility-sports-courts', [facilityController::class, 'getFacilitySportsCourt']);

    //update facility route
    Route::post('/update-facility', [facilityController::class, 'updateFacility']);

    Route::get('/delete-facility', [facilityController::class, 'deleteFacility']);


    // Uploads api
    Route::post('/uploads', [managementController::class, 'uploads']);

Route::middleware('auth:sanctum')->group(function () {



});


