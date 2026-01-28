<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskProgressStatusRequest;
use App\Http\Requests\AddRemoveMemberFromProjectRequest;
use Illuminate\Validation\ValidationException;
use App\Services\TaskService;

class TaskController extends Controller
{
    use HelperTrait;
    protected $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function addTasks(StoreTaskRequest $request)
    {
        try {
            $data = $this->service->addTasks($request);

            return $this->successResponse($data, 'Task has been added successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // public function getTasks()
    // {
    //     try {
    //         $data = $this->service->getTasks();

    //         return $this->successResponse($data, 'Tasks retrieved successfully', Response::HTTP_OK);
    //     } catch (\Throwable $th) {
    //         return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    // public function getTasksByUser($user_id)
    // {
    //     try {
    //         $data = $this->service->getTasksByUser($user_id);

    //         return $this->successResponse($data, 'Tasks retrieved successfully', Response::HTTP_OK);
    //     } catch (\Throwable $th) {
    //         return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    public function updateTask(UpdateTaskRequest $request, $id)
    {
        try {
            $data = $this->service->updateTask($request, $id);

            return $this->successResponse($data, 'Task has been updated successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateProgressAndStatus(UpdateTaskProgressStatusRequest $request, $task_id)
    {
        try {
            $data = $this->service->updateProgressAndStatus($request, $task_id);

            return $this->successResponse($data, 'Task progress and status updated successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function assignMemberToTask(AddRemoveMemberFromProjectRequest $request)
    {
        try {
            $data = $this->service->assignMemberToTask($request);

            return $this->successResponse($data, 'User assigned to task successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function removeMemberFromTask(AddRemoveMemberFromProjectRequest $request)
    {
        try {
            $data = $this->service->removeMemberFromTask($request);

            return $this->successResponse($data, 'User removed from task successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}