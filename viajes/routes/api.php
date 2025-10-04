<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TripController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('ajax')->group(function(){

    Route::get('city-index',[CityController::class,'index'])->name('city.index');
    Route::post('reservations',[ReservationController::class,'store'])->name('save-reservation');
    Route::post('trips',[TripController::class,'store'])->name('save-trip');
    Route::get('getDestinations/{id}',[CityController::class,'getDestinations'])->name('city.getDestinations');
    Route::get('getDestinationsAjax/{name}',[CityController::class,'getDestinationsAjax']);
});
