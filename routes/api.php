<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectPlanningController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubTaskController;
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
    Route::post('/add-project-type', [SettingsController::class, 'addProjectType']);
    Route::post('/add-department', [SettingsController::class, 'addDepartment']);
    Route::post('/add-designation', [SettingsController::class, 'addDesignation']);
    Route::post('/update-department/{id}', [SettingsController::class, 'updateDepartment']);
    Route::post('/update-designation/{id}', [SettingsController::class, 'updateDesignation']);

    //Project Manpower Routes (Add/Remove Users to/from Project)
    Route::post('/add-user-to-project', [ProjectPlanningController::class, 'addUserToProject']);
    Route::post('/add-multiple-users-to-project', [ProjectPlanningController::class, 'addMultipleUsersToProject']);
    Route::get('/project-manpower-list/{project_id}', [ProjectPlanningController::class, 'listProjectManpower']);
    Route::post('/remove-user-from-project', [ProjectPlanningController::class, 'removeFromTheProject']);

    // Project Module Routes
    Route::post('/add-project-module', [ProjectPlanningController::class, 'storeProjectModule']);
    Route::post('/update-project-module/{id}', [ProjectPlanningController::class, 'updateProjectModule']);
    Route::delete('/delete-project-module/{id}', [ProjectPlanningController::class, 'deleteProjectModule']);
    Route::get('/project-module-list/{project_id}', [ProjectPlanningController::class, 'projectModuleList']);
    Route::get('/my-project-list', [ProjectController::class, 'myProjects']);
    Route::get('/project-details/{id}', [ProjectController::class, 'projectDetails']);

    // Task Routes
    Route::post('/add-task', [TaskController::class, 'addTasks']);
    Route::post('/update-task/{id}', [TaskController::class, 'updateTask']);
    Route::post('/update-progress-status/{task_id}', [TaskController::class, 'updateProgressAndStatus']);
    Route::post('/mark-task-completed/{task_id}', [TaskController::class, 'markTaskAsCompleted']);
    Route::get('/task-details/{id}', [TaskController::class, 'getTaskDetails']);
    // Route::delete('/delete-task/{id}', [TaskController::class, 'deleteTask']);
    Route::get('/all-task-list/{project_module_id}', [TaskController::class, 'allTaskListByModule']);

    Route::post('/assign-member-to-task', [TaskController::class, 'assignMemberToTask']);
    // Route::post('/assign-multiple-member-to-task', [TaskController::class, 'assignMemberToTask']);
    Route::post('/remove-member-from-task', [TaskController::class, 'removeMemberFromTask']);
    Route::post('/assign-self-to-task', [TaskController::class, 'assignSelfToTask']);

    // Sub Task Routes
    Route::post('/add-sub-task', [SubTaskController::class, 'addSubTask']);
    Route::post('/update-sub-task/{id}', [SubTaskController::class, 'updateSubTask']);
    Route::post('/mark-sub-task-completed/{sub_task_id}', [SubTaskController::class, 'markSubTaskAsCompleted']);
    Route::get('/sub-task-details/{id}', [SubTaskController::class, 'getSubTaskDetails']);
    Route::get('/all-sub-task-list/{task_id}', [SubTaskController::class, 'allSubTaskListByTask']);
    Route::delete('/delete-sub-task/{id}', [SubTaskController::class, 'deleteSubTask']);

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'open'], function () {
    Route::get('/get-department-list', [SettingsController::class, 'getDepartmentList']);
    Route::get('/get-designation-list', [SettingsController::class, 'getDesignationList']);
    Route::get('/get-project-type-list', [SettingsController::class, 'getProjectTypeList']);
});
