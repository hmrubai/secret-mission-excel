<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProjectController;
use Symfony\Component\HttpKernel\Profiler\Profile;

// Public
Route::post('login', [AuthController::class, 'login']);

// Protected
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/add-new-user', [AuthController::class, 'addNewUser']);
    Route::put('/update-user/{id}', [AuthController::class, 'updateUser']);
    Route::get('/admin/get-user-list', [AuthController::class, 'getUserlist']);
    Route::get('/admin/get-profile/{id}', [AuthController::class, 'getProfile']);
    Route::get('/my-profile', [AuthController::class, 'myProfile']);
    
    Route::apiResource('/vendors', VendorController::class);
    Route::apiResource('/projects', ProjectController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'open'], function () {
    Route::get('/get-department-list', [SettingsController::class, 'getDepartmentList']);
    Route::get('/get-designation-list', [SettingsController::class, 'getDesignationList']);
    Route::get('/get-project-type-list', [SettingsController::class, 'getProjectTypeList']);
});
