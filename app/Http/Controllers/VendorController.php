<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use Illuminate\Validation\ValidationException;
use App\Services\VendorService;

class VendorController extends Controller
{
    protected $service;
    use HelperTrait;

    public function __construct(VendorService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->service->index($request);

            return $this->successResponse($data, 'Vendor List successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreVendorRequest $request)
    {
        try {
            $data = $this->service->store($request);

            return $this->successResponse($data, 'Vendor created successfully', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateVendorRequest $request, int $id)
    {
        try {
            $data = $this->service->update($request, $id);

            return $this->successResponse($data, 'Vendor updated successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->service->destroy($id);

            return $this->successResponse(null, 'Vendor deleted successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }   

}
