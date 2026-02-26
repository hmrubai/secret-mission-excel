<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectManpower;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserProgressService
{
    /**
     * Admin view: retrieve progress details for any user by their ID.
     */
    public function getUserProgressForAdmin(int $userId): array
    {
        $user = User::with(['department', 'designation'])->findOrFail($userId);
        return $this->buildUserProgress($user);
    }

    /**
     * Self view: retrieve progress details for the currently authenticated user.
     */
    public function getMyProgress(): array
    {
        $user = User::with(['department', 'designation'])->findOrFail(Auth::id());
        return $this->buildUserProgress($user);
    }

    /**
     * Core logic shared by both endpoints.
     * Builds project-wise engagement, Gantt data, calendar data, and overall summary.
     */
    private function buildUserProgress(User $user): array
    {
        // Fetch all projects the user is part of (via project_manpower)
        $projectIds = ProjectManpower::where('user_id', $user->id)
            ->pluck('project_id');

        $projects = Project::with([
            'projectType',
            'vendor',
            'tasks' => function ($query) use ($user) {
                // Only tasks assigned to this user
                $query->whereHas('assignments', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->with([
                    'assignments',
                    'assignments.user:id,name,email,profile_picture,user_type,phone',
                ]);
            },
        ])
        ->whereIn('id', $projectIds)
        ->get();

        // Aggregate totals
        $totalProjects      = $projects->count();
        $totalTasks         = 0;
        $totalCompleted     = 0;
        $totalProgressSum   = 0;

        $projectData = $projects->map(function (Project $project) use (
            $user, &$totalTasks, &$totalCompleted, &$totalProgressSum
        ) {
            $tasks = $project->tasks; // already filtered to user's tasks

            $taskTotal      = $tasks->count();
            $taskCompleted  = $tasks->where('status', 'completed')->count();
            $taskInProgress = $tasks->where('status', 'in_progress')->count();
            $taskPending    = $tasks->where('status', 'pending')->count();
            $avgProgress    = $taskTotal > 0
                ? round($tasks->avg('progress') ?? 0, 2)
                : 0;

            // Accumulate overall totals
            $totalTasks     += $taskTotal;
            $totalCompleted += $taskCompleted;
            $totalProgressSum += $avgProgress;

            // --- Gantt Chart Data ---
            $ganttData = $tasks->map(function ($task) {
                return [
                    'id'       => $task->id,
                    'name'     => $task->title,
                    'start'    => $task->start_date ? $task->start_date->format('Y-m-d') : null,
                    'end'      => $task->deadline   ? $task->deadline->format('Y-m-d')   : null,
                    'progress' => $task->progress ?? 0,
                    'status'   => $task->status,
                    'priority' => $task->priority,
                ];
            })->values();

            // --- Calendar Completion Data ---
            // Group completed tasks by their completion date → { "YYYY-MM-DD": count }
            $calendarData = $tasks
                ->filter(fn ($task) => $task->status === 'completed' && $task->completed_at)
                ->groupBy(fn ($task) => Carbon::parse($task->completed_at)->format('Y-m-d'))
                ->map(fn ($group) => $group->count())
                ->toArray();

            return [
                'project_id'          => $project->id,
                'project_name'        => $project->name,
                'project_status'      => $project->status,
                'project_start_date'  => $project->start_date ? $project->start_date->format('Y-m-d') : null,
                'project_deadline'    => $project->deadline   ? $project->deadline->format('Y-m-d')   : null,
                'project_progress'    => $project->progress ?? 0,
                'user_task_summary'   => [
                    'total_tasks'            => $taskTotal,
                    'completed_tasks'        => $taskCompleted,
                    'in_progress_tasks'      => $taskInProgress,
                    'pending_tasks'          => $taskPending,
                    'avg_progress_percentage'=> $avgProgress,
                ],
                'gantt_data'               => $ganttData,
                'calendar_completion_data' => $calendarData,
            ];
        })->values();

        // Overall progress: average of per-project avg-progress values (or 0)
        $overallProgress = $totalProjects > 0
            ? round($totalProgressSum / $totalProjects, 2)
            : 0;

        return [
            'user' => [
                'id'          => $user->id,
                'name'        => $user->name,
                'email'       => $user->email,
                'phone'       => $user->phone,
                'user_type'   => $user->user_type,
                'department'  => $user->department?->name ?? null,
                'designation' => $user->designation?->name ?? null,
                'profile_picture' => $user->profile_picture,
            ],
            'overall_summary' => [
                'total_projects'              => $totalProjects,
                'total_tasks'                 => $totalTasks,
                'completed_tasks'             => $totalCompleted,
                'overall_progress_percentage' => $overallProgress,
            ],
            'projects' => $projectData,
        ];
    }
}
