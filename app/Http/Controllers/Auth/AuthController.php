<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Http\Requests\LoginRequest;
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


}
