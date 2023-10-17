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

     //facility get route
    Route::get('/get-all-facility', [facilityController::class, 'getAllFacility']);
    Route::get('/get-recent-facility/{count}', [facilityController::class, 'recentFacility']);
    Route::get('/get-featured-facility/{count}', [facilityController::class, 'featuredFacility']);
    Route::get('/get-facility-by-slug/{slug}', [facilityController::class, 'getFacilityBySlug']);

 
     // create facility route
     Route::post('/createFacility', [facilityController::class, 'createFacility']);
 
     //update facility route
     Route::post('/update-facility', [facilityController::class, 'updateFacility']);
     
     // delete facility route
     Route::get('/delete-facility', [facilityController::class, 'deleteFacility']);
 

    //sports api
    Route::post('/create-sports', [managementController::class, 'createSports']);
    Route::get('/get-all-sports', [managementController::class, 'getAllSports']);
    Route::post('/update-sports/{sport_id}', [managementController::class, 'updateSports']);
    Route::get('/delete-sports/{sport_id}', [managementController::class, 'deleteSports']);

    //venue route
    Route::post('/create-venue', [managementController::class, 'createVenue']);
    Route::get('/get-all-venues', [managementController::class, 'getAllVenues']);
    Route::post('/update-venue/{venue_id}', [managementController::class, 'updateVenue']);
    Route::get('/delete-venues/{venue_id}', [managementController::class, 'deleteVenue']);
    
    //profile update route
    Route::post('/profileUpdate', [managementController::class, 'profileUpdate']);

    //get user role route
    Route::get('/get-user-role', [managementController::class, 'getUserRole']);

    //venue Facility crud
    Route::get('/facility-venue', [facilityController::class, 'getFacilityVenue']);
    Route::post('/facility-venue', [facilityController::class, 'createFacilityVenue']);
    Route::post('/update-facility-venue/{facility_venue_id}', [facilityController::class, 'updateFacilityVenue']);
    Route::get('/delete-facility-venue/{facility_venue_id}', [facilityController::class, 'deleteFacilityVenue']);


    //get facilty sports route
    Route::get('/facility-sports', [facilityController::class, 'getFacilitySports']);
    Route::post('/facility-sports', [facilityController::class, 'createFaciltiySports']);

    //get facilty sports route
    Route::get('/facility-sports-courts', [facilityController::class, 'getFacilitySportsCourt']);

    // Uploads api
    Route::post('/uploads', [managementController::class, 'uploads']);

    //get all facility 
    Route::get('/get-all-services', [managementController::class, 'getAllServices']);
    

    //get categoriezed facility 
    Route::get('/get-facility-by-category/{cat}/{service}', [managementController::class, 'getFacilityByCategory']);
    

Route::middleware('auth:sanctum')->group(function () {



});


