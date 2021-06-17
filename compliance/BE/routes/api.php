<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {

    Route::group(['prefix' => 'admin'], function (){
        Route::post('login', [AdminController::class, 'login']);
        Route::post('logout', [AdminController::class, 'logout']);
        Route::post('me', [AdminController::class, 'me']);
        Route::post('uploadFeaturedImage', [EventsController::class, 'uploadFeaturedImage']);
        Route::post('store', [EventsController::class, 'store']);
    });

    Route::group(['prefix' => 'user'], function (){
        Route::post('store', [UserController::class, 'store']);
        Route::post('login', [UserController::class, 'login']);
        Route::post('logout', [UserController::class, 'logout']);
        Route::post('me', [UserController::class, 'me']);
    });
});

Route::group(['middleware' => 'api'], function () {
    Route::group(['prefix' => 'admin'], function (){
        Route::post('uploadFeaturedImage', [EventsController::class, 'uploadFeaturedImage']);
        Route::post('store', [EventsController::class, 'store']);
        Route::post('filter/reservation', [RecordController::class, 'filter_reservation']);
        Route::apiResource('events', HomeController::class);
        
        Route::get('reservation', [RecordController::class, 'index']);
        Route::put('reservation/cancelled/{id}', [RecordController::class, 'setCancelled']);
        Route::put('reservation/paid/{id}', [RecordController::class, 'setPaid']);
        Route::delete('reservation/{id}', [RecordController::class, 'destroy']);
    });
});

Route::group(['middleware' => 'api', 'prefix' => 'user'], function () {
    Route::get('reservations', [UserController::class, 'getReservations']);
});

Route::post('reservation/check', [ReservationController::class, 'check_reservation']);
Route::get('reservation/events', [HomeController::class, 'index']);
Route::post('reservation/reserve', [ReservationController::class, 'reserve']);