<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\CheckInOutController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/cities/{state}', [CityController::class, 'getCitiesByState']);
Route::post('/checkin', [CheckInOutController::class, 'process'])->middleware('auth.api');