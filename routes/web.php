<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// routes/web.php

// Define login and OTP verification routes
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login.submit');
Route::post('/verify-otp', 'App\Http\Controllers\Auth\LoginController@verifyOTP')->name('verify.otp');




Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\Management\dashboardController@index');


   

    Route::get('/service', 'App\Http\Controllers\Management\dashboardController@serviceView');

    Route::get('/createServices', 'App\Http\Controllers\Management\dashboardController@createServicesView');
    Route::post('/createServices', 'App\Http\Controllers\Management\dashboardController@createServices');

    Route::get('/venue-facility', 'App\Http\Controllers\Management\dashboardController@facilityVenueView');
    Route::post('/venue-facility', 'App\Http\Controllers\Management\dashboardController@facilityVenue');

 

    Route::get('/uploads', 'App\Http\Controllers\Management\dashboardController@uploadsView');
    Route::Post('/uploads', 'App\Http\Controllers\Management\dashboardController@uploads');


    //Faciltity CRUD
    Route::get('/allFacility', 'App\Http\Controllers\Management\dashboardController@allFacility');
    Route::get('/createFacility', 'App\Http\Controllers\Management\dashboardController@createFacilityView');
    Route::post('/createFacility', 'App\Http\Controllers\Management\dashboardController@createFacility');
    Route::get('/update-facility/{id}/', 'App\Http\Controllers\Management\dashboardController@updateFacilityView');
    Route::post('/update-facility/{id}', 'App\Http\Controllers\Management\dashboardController@updateFacility');
    Route::get('/daelete-facility/{id}', 'App\Http\Controllers\Management\dashboardController@deleteFacility');


    //Sports CRUD
    Route::get('/category', 'App\Http\Controllers\Management\dashboardController@categoryView');
    Route::get('/servicesCategory', 'App\Http\Controllers\Management\dashboardController@createServicesCategoryView');
    Route::post('/servicesCategory', 'App\Http\Controllers\Management\dashboardController@createServicesCategory');
    Route::get('/allsports', 'App\Http\Controllers\Management\dashboardController@allSports');
    Route::get('/update-sport/{id}', 'App\Http\Controllers\Management\dashboardController@updateSportsView');
    Route::post('/update-sport/{id}', 'App\Http\Controllers\Management\dashboardController@updateSports');
    Route::get('/delete-sport/{id}', 'App\Http\Controllers\Management\dashboardController@deleteSport');


    //Venue CRUD
    Route::get('/Venues', 'App\Http\Controllers\Management\dashboardController@viewVenue');
    Route::post('/Venues', 'App\Http\Controllers\Management\dashboardController@Venues');
    Route::get('/allVenue', 'App\Http\Controllers\Management\dashboardController@allVenue');
    Route::get('/update-venue/{id}', 'App\Http\Controllers\Management\dashboardController@updateVenueView');
    Route::post('/update-venue/{id}', 'App\Http\Controllers\Management\dashboardController@updateVenue');
    Route::get('/delete-venue/{id}', 'App\Http\Controllers\Management\dashboardController@deleteVenue');


    Route::get('/book-facility', 'App\Http\Controllers\Management\dashboardController@bookFacilityView');
    Route::post('/book-facility', 'App\Http\Controllers\Management\dashboardController@bookFacility');

    Route::get('/facility-image/{facility_id}', 'App\Http\Controllers\Management\dashboardController@facilityImage');

    Route::get('/sport-court/{facility_id}/{sport_id}', 'App\Http\Controllers\Management\dashboardController@sport_court');

    Route::get('allBooking', 'App\Http\Controllers\Management\dashboardController@allBooking');

});



