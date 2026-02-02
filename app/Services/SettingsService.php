<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Designation;
use App\Models\ProjectType;
use App\Models\WorkCalendar;
use App\Models\Holiday;
use App\Http\Traits\HelperTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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

    public function addProjectType(Request $request)
    {
        $fillable = (new ProjectType())->getFillable();

        $data = $request->only($fillable);

        $data['created_at'] = now();

        return ProjectType::create($data);
    }

    public function addDepartment(Request $request)
    {
        $fillable = (new Department())->getFillable();

        $data = $request->only($fillable);

        $data['created_at'] = now();

        return Department::create($data);
    }

    public function updateDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $fillable = (new Department())->getFillable();

        $data = $request->only($fillable);

        $data['updated_at'] = now();

        $department->update($data);

        return $department;
    }

    public function addDesignation(Request $request)
    {
        $fillable = (new Designation())->getFillable();

        $data = $request->only($fillable);

        $data['created_at'] = now();

        return Designation::create($data);
    }

    public function updateDesignation(Request $request, $id)
    {
        $designation = Designation::findOrFail($id);

        $fillable = (new Designation())->getFillable();

        $data = $request->only($fillable);

        $data['updated_at'] = now();

        $designation->update($data);

        return $designation;
    }

    public function addWeekend(Request $request)
    {
        $fillable = (new WorkCalendar())->getFillable();

        $data = $request->only($fillable);

        $data['created_at'] = now();

        return WorkCalendar::create($data);
    }

    public function addHoliday(Request $request)
    {
        $fillable = (new Holiday())->getFillable();

        $data = $request->only($fillable);

        $data['created_at'] = now();

        return Holiday::create($data);
    }

    public function getWeekendList(Request $request)
    {
        return WorkCalendar::where('is_active', true)->orderBy('id', 'desc')->get();
    }

    public function getHolidayList(Request $request)
    {
        return Holiday::where('is_active', true)->orderBy('date', 'asc')->get();
    }

    public function getWeekendDatesForYear(int $year)
    {
        $calendar = WorkCalendar::where('is_active', true)->firstOrFail();

        $weekends = $calendar->weekends; // e.g. [5,6]

        $start = Carbon::create($year, 1, 1);
        $end   = Carbon::create($year, 12, 31);

        $period = CarbonPeriod::create($start, $end);

        $dates = [];

        foreach ($period as $date) {
            if (in_array($date->dayOfWeek, $weekends)) {
                $dates[] = $date->toDateString();
            }
        }

        return $data = [
            'year'     => $year,
            'weekends' => $weekends,
            'dates'    => $dates,
        ];
    }
}   