<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\ProjectHistory;
use Illuminate\Support\Facades\Auth;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        ProjectHistory::create([
            'project_id' => $project->id,
            'field' => 'created',
            'old_value' => null,
            'new_value' => json_encode($project->getAttributes()),
            'updated_by' => Auth::id(),
            'remarks' => 'Project created',
        ]);
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        foreach ($project->getDirty() as $field => $newValue) {

            $oldValue = $project->getOriginal($field);

            if ((string) $oldValue === (string) $newValue) {
                continue;
            }

            ProjectHistory::create([
                'project_id' => $project->id,
                'field' => $field,
                'old_value' => $oldValue,
                'new_value' => $newValue,
                'updated_by' => Auth::id(),
                'remarks' => 'Project updated',
            ]);
        }
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
