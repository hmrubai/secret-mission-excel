<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Http\Requests\StoreProjectTypeRequest;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\StoreDepartmentRequest;
use Illuminate\Validation\ValidationException;
use App\Services\SettingsService;

class SettingsController extends Controller
{
    protected $service;
    use HelperTrait;
    public function __construct(SettingsService $service)
    {
        $this->service = $service;
    }

    public function getDepartmentList(Request $request)
    {
        try {
            $data = $this->service->getDepartmentList($request);

            return $this->successResponse($data, 'Department List successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getDesignationList(Request $request)
    {
        try {
            $data = $this->service->getDesignationList($request);

            return $this->successResponse($data, 'Designation List successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getProjectTypeList(Request $request)
    {
        try {
            $data = $this->service->getProjectTypeList($request);

            return $this->successResponse($data, 'Project Type List successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function addProjectType(StoreProjectTypeRequest $request)
    {
        try {
            $data = $this->service->addProjectType($request);

            return $this->successResponse($data, 'Project Type added successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function addDepartment(StoreDepartmentRequest $request)
    {
        try {
            $data = $this->service->addDepartment($request);

            return $this->successResponse($data, 'Department added successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function addDesignation(StoreDesignationRequest $request)
    {
        try {
            $data = $this->service->addDesignation($request);

            return $this->successResponse($data, 'Designation added successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //addWeekend and Holiday methods can be added here similarly
    public function addWeekend(Request $request)
    {
        try {
            $data = $this->service->addWeekend($request);

            return $this->successResponse($data, 'Weekend added successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function addHoliday(Request $request)
    {
        try {
            $data = $this->service->addHoliday($request);

            return $this->successResponse($data, 'Holiday added successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getHolidayList(Request $request)
    {
        try {
            $data = $this->service->getHolidayList($request);

            return $this->successResponse($data, 'Holiday List successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getWeekendList(Request $request)
    {
        try {
            $data = $this->service->getWeekendList($request);

            return $this->successResponse($data, 'Weekend List successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getWeekendDatesForYear(int $year)
    {
        try {
            $data = $this->service->getWeekendDatesForYear($year);

            return $this->successResponse($data, 'Weekend Dates for Year successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}