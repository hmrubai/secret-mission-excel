<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $service;
    use HelperTrait;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        try {
            $data = $this->service->login($request);

            return  $this->successResponse($data, 'Login successful', Response::HTTP_OK);
        } catch (ValidationException $e) {
            return  $this->errorResponse($e->errors(), $e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $th) {
            return  $this->errorResponse($th->getMessage(), 'Login failed', Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $request)
    {
        $data = $this->service->logout($request);
        return $this->successResponse(null, 'Logout successful', Response::HTTP_OK);
    }

    public function addNewUser(StoreUserRequest $request)
    {
        try {
            $data = $this->service->register($request);

            return  $this->successResponse($data, 'User added successfully', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return  $this->errorResponse($e->errors(), $e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $th) {
            return  $this->errorResponse($th->getMessage(), 'Something went wrong!', Response::HTTP_UNAUTHORIZED);
        }
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        try {
            $data = $this->service->updateUser($request, $id);

            return  $this->successResponse($data, 'User updated successfully', Response::HTTP_OK);
        } catch (ValidationException $e) {
            return  $this->errorResponse($e->errors(), $e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $th) {
            return  $this->errorResponse($th->getMessage(), 'Something went wrong!', Response::HTTP_UNAUTHORIZED);
        }
    }

    public function getProfile($request, $id)
    {
        try {
            $data = $this->service->show($id);

            return $this->successResponse($data, 'User profile successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function myProfile(Request $request)
    {
        try {
            $id = Auth::id();
            $data = $this->service->myProfile($id);

            return $this->successResponse($data, 'My profile successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserlist(Request $request)
    {
        try {
            $data = $this->service->index($request);

            return $this->successResponse($data, 'User List successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
