<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Services\UserProgressService;

class UserProgressController extends Controller
{
    use HelperTrait;

    protected $service;

    public function __construct(UserProgressService $service)
    {
        $this->service = $service;
    }

    /**
     * Admin: Get progress details of any user by user_id.
     * GET /admin/user-progress/{user_id}
     */
    public function adminGetUserProgress($userId)
    {
        try {
            $data = $this->service->getUserProgressForAdmin((int) $userId);

            return $this->successResponse($data, 'User progress retrieved successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * User: Get progress details for the currently authenticated user.
     * GET /my-progress
     */
    public function myProgress()
    {
        try {
            $data = $this->service->getMyProgress();

            return $this->successResponse($data, 'My progress retrieved successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
