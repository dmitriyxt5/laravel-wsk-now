<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ScheduleController;
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

Route::get('/', function (Request $request) {
    return 'hi';
});

Route::prefix('auth')->group(function () {
//    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware(\App\Http\Middleware\checkAuth::class);
});

Route::prefix('/place')->group(function () {
    Route::post('/', [PlaceController::class, 'create'])->middleware(\App\Http\Middleware\checkAuth::class);
    Route::get('/', [PlaceController::class, 'getPlace'])->middleware(\App\Http\Middleware\checkAuth::class);
    Route::get('/find/{id}', [PlaceController::class, 'findPlace'])->middleware(\App\Http\Middleware\checkAuth::class);
    Route::post('/update/{id}', [PlaceController::class, 'update'])->middleware(\App\Http\Middleware\checkAuth::class);
    Route::delete('/{id}', [PlaceController::class, 'delete'])->middleware(\App\Http\Middleware\checkAuth::class);
});

Route::prefix('/schedule')->group(function () {
    Route::post('/', [ScheduleController::class, 'create']);
    Route::post('/{id}', [ScheduleController::class, 'update']);
    Route::get('/', [ScheduleController::class, 'get']);
    Route::delete('/{id}', [ScheduleController::class, 'delete']);
});

Route::prefix('/route')->group(function () {
    Route::get('/search/{from_place_id}/{to_place_id}/{departure_time}', [RouteController::class, 'index']);
});
