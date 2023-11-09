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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// routes/web.php

// Define login and OTP verification routes
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login.submit');
Route::post('/verify-otp', 'App\Http\Controllers\Auth\LoginController@verifyOTP')->name('verify.otp');




Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\web\Management\dashboardController@index');

    Route::get('/service', 'App\Http\Controllers\web\Management\dashboardController@serviceView');

    Route::get('/addServices', 'App\Http\Controllers\web\Management\dashboardController@addServicesView');
    Route::Post('/addServices', 'App\Http\Controllers\web\Management\dashboardController@addServices');


    Route::get('/createServices', 'App\Http\Controllers\web\Management\dashboardController@createServicesView');
    Route::post('/createServices', 'App\Http\Controllers\web\Management\dashboardController@createServices'); 

    Route::get('/uploads', 'App\Http\Controllers\web\Management\dashboardController@uploadsView');
    Route::Post('/uploads', 'App\Http\Controllers\web\Management\dashboardController@uploads');


    //Faciltity CRUD
    Route::get('/allFacility', 'App\Http\Controllers\web\Facility\facilityController@allFacility');
    Route::get('/createFacility', 'App\Http\Controllers\web\Facility\facilityController@createFacilityView');
    Route::post('/createFacility', 'App\Http\Controllers\web\Facility\facilityController@createFacility');
    Route::get('/update-facility/{id}/', 'App\Http\Controllers\web\Facility\facilityController@updateFacilityView');
    Route::post('/update-facility/{id}', 'App\Http\Controllers\web\Facility\facilityController@updateFacility');
    Route::get('/daelete-facility/{id}', 'App\Http\Controllers\web\Facility\facilityController@deleteFacility');


    //Sports CRUD
    Route::get('/category', 'App\Http\Controllers\web\Management\dashboardController@categoryView');
    Route::get('/servicesCategory', 'App\Http\Controllers\web\Management\dashboardController@createServicesCategoryView');
    Route::post('/servicesCategory', 'App\Http\Controllers\web\Management\dashboardController@createServicesCategory');


    Route::get('/facility-image/{facility_id}', 'App\Http\Controllers\Management\dashboardController@facilityImage');

    Route::get('/create-amenities', 'App\Http\Controllers\web\Management\dashboardController@createAmenitiesView');
    Route::post('/create-amenities', 'App\Http\Controllers\web\Management\dashboardController@createAmenities');


    Route::get('/get-service-category/{facility_id}', 'App\Http\Controllers\web\Management\dashboardController@getServiceCategory');

    Route::get('/get-service/{service_category_id}', 'App\Http\Controllers\web\Management\dashboardController@getService');

    // delete service category
    Route::get('/delete-service-category/{id}', 'App\Http\Controllers\web\Management\dashboardController@deleteServiceCategory');

    //update service category
    Route::get('/update-service-category/{id}', 'App\Http\Controllers\web\Management\dashboardController@updateServiceCategoryView');
    Route::post('/update-service-category/{id}', 'App\Http\Controllers\web\Management\dashboardController@updateServiceCategory');

    //delete service
    Route::get('/delete-service/{id}', 'App\Http\Controllers\web\Management\dashboardController@deleteServices');

        //update service category
    Route::get('/update-service/{id}', 'App\Http\Controllers\web\Management\dashboardController@updateServiceView');
    Route::post('/update-service/{id}', 'App\Http\Controllers\web\Management\dashboardController@updateService');

});



