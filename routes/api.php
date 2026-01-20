<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SettingsController;

// Public
Route::post('login', [AuthController::class, 'login']);

Route::get('/get-department-list', [SettingsController::class, 'getDepartmentList']);
Route::get('/get-designation-list', [SettingsController::class, 'getDesignationList']);

// Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', fn ($request) => $request->user());
});

Route::group(['prefix' => 'open'], function () {
    Route::get('/get-department-list', [SettingsController::class, 'getDepartmentList']);
    Route::get('/get-designation-list', [SettingsController::class, 'getDesignationList']);
});
