<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\UpdatePlanningTypeRequest;
use Illuminate\Validation\ValidationException;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    use HelperTrait;
    protected $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->service->index($request);

            return $this->successResponse($data, 'Project List successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreProjectRequest $request)
    {
        try {
            $data = $this->service->store($request);

            return $this->successResponse($data, 'Project created successfully', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $data = $this->service->show($id);

            return $this->successResponse($data, 'Project retrieved successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        try {
            $data = $this->service->update($request, $id);

            return $this->successResponse($data, 'Project updated successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->destroy($id);

            return $this->successResponse(null, 'Project deleted successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function myProjects()
    {
        try {
            $data = $this->service->myProjects();

            return $this->successResponse($data, 'My Projects retrieved successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function projectDetails($id)
    {
        try {
            $data = $this->service->projectDetails($id);

            return $this->successResponse($data, 'Project details retrieved successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function projectDetailsForCalender($id)
    {
        try {
            $data = $this->service->projectDetailsForCalender($id);

            return $this->successResponse($data, 'Project details retrieved successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
