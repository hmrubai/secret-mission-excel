<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Designation;
use App\Models\ProjectType;
use App\Http\Traits\HelperTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingsService
{
    use HelperTrait;

    public function getDepartmentList(Request $request)
    {
        return Department::where('is_active', true)->orderBy('name', 'asc')->get();
    }

    public function getDesignationList(Request $request)
    {
        return Designation::where('is_active', true)->orderBy('name', 'asc')->get();
    }

    public function getProjectTypeList(Request $request)
    {
        return ProjectType::where('is_active', true)->orderBy('name', 'asc')->get();
    }
}
