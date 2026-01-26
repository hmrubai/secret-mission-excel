<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectPlanningController;
use Symfony\Component\HttpKernel\Profiler\Profile;

// Public
Route::post('login', [AuthController::class, 'login']);

// Protected
Route::middleware(['auth:sanctum'])->group(function () {
    // User Management Routes
    Route::post('/add-new-user', [AuthController::class, 'addNewUser']);
    Route::post('/update-user/{id}', [AuthController::class, 'updateUser']);
    Route::get('/admin/get-user-list', [AuthController::class, 'getUserlist']);
    Route::get('/admin/get-profile/{id}', [AuthController::class, 'getProfile']);
    Route::get('/my-profile', [AuthController::class, 'myProfile']);
    
    // Vendors Routes
    Route::apiResource('/vendors', VendorController::class);
    Route::post('/update-vendor/{id}', [VendorController::class, 'update']);

    // Projects Routes
    Route::apiResource('/projects', ProjectController::class);

    // Planning Types Routes
    Route::get('/planning-type-list', [ProjectPlanningController::class, 'planningTypes']);
    Route::post('/add-planning-types', [ProjectPlanningController::class, 'storePlanningTypes']);
    Route::post('/update-planning-types/{id}', [ProjectPlanningController::class, 'updatePlanningTypes']);
    Route::delete('/delete-planning-types/{id}', [ProjectPlanningController::class, 'deletePlanningTypes']);

    // Project Planning Routes
    Route::post('/add-project-planning', [ProjectPlanningController::class, 'storeProjectPlanning']);
    Route::post('/update-project-planning/{id}', [ProjectPlanningController::class, 'updateProjectPlanning']);
    Route::get('/project-planning-list/{project_id}', [ProjectPlanningController::class, 'projectPlanningList']);
    Route::delete('/delete-project-planning/{id}', [ProjectPlanningController::class, 'destroyProjectPlanning']);

    // Organization Settings for Weekend and Holiday Routes
    Route::post('/add-weekend', [SettingsController::class, 'addWeekend']);
    Route::post('/add-holiday', [SettingsController::class, 'addHoliday']);
    Route::get('/holiday-list', [SettingsController::class, 'getHolidayList']);
    Route::get('/weekend-list', [SettingsController::class, 'getWeekendList']);
    Route::get('/get-weekend-dates/{year}', [SettingsController::class, 'getWeekendDatesForYear']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'open'], function () {
    Route::get('/get-department-list', [SettingsController::class, 'getDepartmentList']);
    Route::get('/get-designation-list', [SettingsController::class, 'getDesignationList']);
    Route::get('/get-project-type-list', [SettingsController::class, 'getProjectTypeList']);
});
