<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Services\TaskDiscussionService;
use App\Http\Requests\StoreTaskDiscussionRequest;

class TaskDiscussionController extends Controller
{
    use HelperTrait;
    protected $taskDiscussionService;

    public function __construct(TaskDiscussionService $taskDiscussionService)
    {
        $this->taskDiscussionService = $taskDiscussionService;
    }

    public function index(Request $request)
    {
        try {
            $taskDiscussions = $this->taskDiscussionService->index($request);
            return $this->successResponse($taskDiscussions, 'Task Discussions retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve task discussions', 500);
        }
    }

    public function store(StoreTaskDiscussionRequest $request)
    {
        try {
            $taskDiscussion = $this->taskDiscussionService->store($request);
            return $this->successResponse($taskDiscussion, 'Task Discussion created successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to create task discussion', 500);
        }
    }

    public function show(int $id)
    {
        try {
            $taskDiscussion = $this->taskDiscussionService->show($id);
            return $this->successResponse($taskDiscussion, 'Task Discussion retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve task discussion', 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $taskDiscussion = $this->taskDiscussionService->update($request, $id);
            return $this->successResponse($taskDiscussion, 'Task Discussion updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to update task discussion', 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $taskDiscussion = $this->taskDiscussionService->destroy($id);
            return $this->successResponse($taskDiscussion, 'Task Discussion deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to delete task discussion', 500);
        }
    }
}
