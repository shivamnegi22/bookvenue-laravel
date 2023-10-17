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
    Route::get('/dashboard', 'App\Http\Controllers\web\web\Management\dashboardController@index');



    Route::get('/service', 'App\Http\Controllers\web\Management\dashboardController@serviceView');
    Route::get('/addServices', 'App\Http\Controllers\web\Management\dashboardController@addServicesView');

    Route::get('/createServices', 'App\Http\Controllers\web\Management\dashboardController@createServicesView');
    Route::post('/createServices', 'App\Http\Controllers\web\Management\dashboardController@createServices'); 

    Route::get('/uploads', 'App\Http\Controllers\web\Management\dashboardController@uploadsView');
    Route::Post('/uploads', 'App\Http\Controllers\web\Management\dashboardController@uploads');


    //Faciltity CRUD
    Route::get('/allFacility', 'App\Http\Controllers\web\Management\facilityController@allFacility');
    Route::get('/createFacility', 'App\Http\Controllers\web\Management\facilityController@createFacilityView');
    Route::post('/createFacility', 'App\Http\Controllers\web\Management\facilityController@createFacility');
    Route::get('/update-facility/{id}/', 'App\Http\Controllers\web\Management\facilityController@updateFacilityView');
    Route::post('/update-facility/{id}', 'App\Http\Controllers\web\Management\facilityController@updateFacility');
    Route::get('/daelete-facility/{id}', 'App\Http\Controllers\web\Management\facilityController@deleteFacility');


    //Sports CRUD
    Route::get('/category', 'App\Http\Controllers\web\Management\dashboardController@categoryView');
    Route::get('/servicesCategory', 'App\Http\Controllers\web\Management\dashboardController@createServicesCategoryView');
    Route::post('/servicesCategory', 'App\Http\Controllers\web\Management\dashboardController@createServicesCategory');


    Route::get('/facility-image/{facility_id}', 'App\Http\Controllers\Management\dashboardController@facilityImage');

});



