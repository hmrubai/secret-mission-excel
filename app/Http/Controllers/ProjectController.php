<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\StorePlanningTypeRequest;
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

    public function planningTypes(Request $request)
    {
        try {
            $data = $this->service->planningTypes($request);

            return $this->successResponse($data, 'Planning Type List successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function storePlanningTypes(StorePlanningTypeRequest $request)
    {
        try {
            $data = $this->service->storePlanningTypes($request);

            return $this->successResponse($data, 'Planning Type created successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePlanningTypes(UpdatePlanningTypeRequest $request, $id)
    {
        try {
            $data = $this->service->updatePlanningTypes($request, $id);

            return $this->successResponse($data, 'Planning Type updated successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deletePlanningTypes($id)
    {
        try {
            $this->service->destroyPlanningType($id);

            return $this->successResponse(null, 'Planning Type deleted successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
