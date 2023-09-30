<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginAuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Facility\facilityController;
use App\Http\Controllers\Api\Management\managementController;

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

        //create sports route
    Route::post('/create-sports', [managementController::class, 'createSports']);

    //create venue route
    Route::post('/create-venue', [managementController::class, 'createVenue']);
    
    //facility route
    Route::get('/Facility', [facilityController::class, 'FacilityView']);
    Route::post('/createFacility', [facilityController::class, 'createFacility']);

    //profile update route
    Route::post('/profileUpdate', [managementController::class, 'profileUpdate']);

Route::middleware('auth:sanctum')->group(function () {



});


