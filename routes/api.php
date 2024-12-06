<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginAuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Facility\facilityController;
use App\Http\Controllers\Api\Management\managementController;
use App\Http\Controllers\Api\Search\SearchController;
use App\Http\Controllers\Api\Booking\bookingController;

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

    Route::post('/login-via-email', [LoginAuthController::class, 'loginEmail']);
    Route::post('/verify-otp-via-email', [LoginAuthController::class, 'verifyOTPEmail']);

    //signup route
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/verify-register-user', [RegisterController::class, 'verifyuser']);
    Route::post('/searchLocation', [SearchController::class, 'searchLocation']);


     //facility get route
    Route::get('/get-all-facility', [facilityController::class, 'getAllFacility']);
    Route::get('/get-recent-facility/{count}', [facilityController::class, 'recentFacility']);
    Route::get('/get-featured-facility/{count}', [facilityController::class, 'featuredFacility']);
    Route::get('/get-facility-by-slug/{slug}', [facilityController::class, 'getFacilityBySlug']);


    Route::middleware('auth:sanctum')->group(function () {
    });

         // create facility route
     Route::post('/create-facility', [facilityController::class, 'createFacility']);

   
      //provider api
      Route::get('/get-provider-data', [facilityController::class, 'allProviderData']);
    
  
     //update facility route
     Route::post('/update-facility', [facilityController::class, 'updateFacility']);
     
     // delete facility route
     Route::get('/delete-facility', [facilityController::class, 'deleteFacility']);
 
    
    //profile update route
    Route::post('/profileUpdate', [managementController::class, 'profileUpdate']);

    //get user role route
    Route::get('/get-user-role', [managementController::class, 'getUserRole']);

    // Uploads api
    Route::post('/uploads', [managementController::class, 'uploads']);

    //get all facility 
    Route::get('/get-all-services', [managementController::class, 'getAllServices']);

    Route::get('/get-service-by-id/{facility_id}', [managementController::class, 'getServiceById']);
    
    //get categoriezed facility 
    Route::get('/get-facility-by-category/{cat}/{service}', [managementController::class, 'getFacilityByCategory']);

    //get all amenities
    Route::get('/get-all-amenities', [managementController::class, 'getAllAmenities']);

    Route::get('/get-all-service-category', [managementController::class, 'getAllServiceCategory']);

     //get  slots
     Route::post('/get-slots-of-court', [managementController::class, 'getSlotsOfCourt']);

    //booking api
    Route::post('/booking', [bookingController::class, 'Booking']);

    Route::post('/get-slots-of-court', [managementController::class, 'getSlotsOfCourt']);

    //add service api
    Route::post('/add-service', [facilityController::class, 'addServices']);

    //add court api
    Route::post('/create-court', [facilityController::class, 'createCourt']);

    //add court api
    Route::post('/contact-us', [managementController::class, 'contactUs']);

    //booking api
    Route::get('/my-bookings', [bookingController::class, 'myBooking']);     

    //payment response api
    Route::post('/payment-success', [bookingController::class, 'paymentSuccess']);

    //payment response api
    Route::get('/payment-failure', [bookingController::class, 'paymentFailure']);

    //availability
    Route::post('/court-availability/{facility_id}/{court_id}', [managementController::class, 'courtAvailability']);
  



