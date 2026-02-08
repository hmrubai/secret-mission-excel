<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Http\Requests\AddSubTaskRequest;
use App\Http\Requests\UpdateSubTaskRequest;
use App\Services\SubTaskService;

class SubTaskController extends Controller
{
    use HelperTrait;
    protected $subTaskService;

    public function __construct(SubTaskService $subTaskService)
    {
        $this->subTaskService = $subTaskService;
    }

    public function index(Request $request)
    {
        try {
            $subTasks = $this->subTaskService->index($request);
            return $this->successResponse($subTasks, 'SubTasks retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve subtasks', 500);
        }
    }

    public function addSubTask(AddSubTaskRequest $request)
    {
        try {
            $subTask = $this->subTaskService->addSubTask($request);
            return $this->successResponse($subTask, 'SubTask created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to create subtask', 500);
        }
    }

    public function getSubTaskDetails(int $id)
    {
        try {
            $subTask = $this->subTaskService->getSubTaskDetails($id);
            return $this->successResponse($subTask, 'SubTask retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve subtask', 500);
        }
    }

    public function updateSubTask(UpdateSubTaskRequest $request, int $id)
    {
        try {
            $subTask = $this->subTaskService->updateSubTask($request, $id);
            return $this->successResponse($subTask, 'SubTask updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to update subtask', 500);
        }
    }

    public function deleteSubTask(int $id)
    {
        try {
            $this->subTaskService->deleteSubTask($id);
            return $this->successResponse(null, 'SubTask deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to delete subtask', 500);
        }
    }

    public function markSubTaskAsCompleted(Request $request, int $id)
    {
        try {
            $subTask = $this->subTaskService->markSubTaskAsCompleted($request, $id);
            return $this->successResponse($subTask, 'SubTask marked as completed successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to mark subtask as completed', 500);
        }
    }

    public function markSubTaskAsIncomplete(Request $request, int $id)
    {
        try {
            $subTask = $this->subTaskService->markSubTaskAsIncomplete($request, $id);
            return $this->successResponse($subTask, 'SubTask marked as incomplete successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to mark subtask as incomplete', 500);
        }
    }

    public function allSubTaskListByTask(int $task_id)
    {
        try {
            $subTasks = $this->subTaskService->allSubTaskListByTask($task_id);
            return $this->successResponse($subTasks, 'SubTasks retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve subtasks', 500);
        }
    }
}
