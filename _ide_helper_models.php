<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereUpdatedAt($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Designation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Designation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Designation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Designation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Designation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Designation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Designation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Designation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Designation whereUpdatedAt($value)
 */
	class Designation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon $date
 * @property string $title
 * @property string $type
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereUpdatedAt($value)
 */
	class Holiday extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectPlanning> $plannings
 * @property-read int|null $plannings_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanningType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanningType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanningType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanningType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanningType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanningType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanningType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanningType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanningType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanningType whereUpdatedAt($value)
 */
	class PlanningType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $vendor_id
 * @property string $priority
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property \Illuminate\Support\Carbon|null $onhold_postponed_date
 * @property int $progress 0 to 100
 * @property int $project_type_id
 * @property int|null $created_by Foreign key to the user table
 * @property string $status
 * @property bool $is_archived
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectHistory> $histories
 * @property-read int|null $histories_count
 * @property-read \App\Models\ProjectType $projectType
 * @property-read \App\Models\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereIsArchived($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereOnholdPostponedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereProjectTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereVendorId($value)
 */
	class Project extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $project_id
 * @property string $field
 * @property string|null $old_value
 * @property string|null $new_value
 * @property int|null $updated_by
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory whereNewValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory whereOldValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectHistory whereUpdatedBy($value)
 */
	class ProjectHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectManpower newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectManpower newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectManpower query()
 */
	class ProjectManpower extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $project_id
 * @property int $planning_type_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int|null $duration_days
 * @property bool $exclude_weekends
 * @property bool $exclude_holidays
 * @property int $progress
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PlanningType $planningType
 * @property-read \App\Models\Project $project
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereExcludeHolidays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereExcludeWeekends($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning wherePlanningTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPlanning whereUpdatedAt($value)
 */
	class ProjectPlanning extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectType whereUpdatedAt($value)
 */
	class ProjectType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $gender
 * @property string|null $employee_code
 * @property string|null $profile_picture
 * @property string|null $hrm_id
 * @property int|null $department_id Foreign key to the departments table
 * @property int|null $designation_id Foreign key to the designations table
 * @property string|null $wing
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $user_type
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\Designation|null $designation
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDesignationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmployeeCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereHrmId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereWing($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $website
 * @property string|null $company_name
 * @property string|null $tax_id
 * @property string|null $address_line_1
 * @property string|null $address_line_2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $country
 * @property string|null $postal_code
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereWebsite($value)
 */
	class Vendor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property array<array-key, mixed> $weekends
 * @property string $work_start_time
 * @property string $work_end_time
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCalendar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCalendar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCalendar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCalendar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCalendar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCalendar whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCalendar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCalendar whereWeekends($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCalendar whereWorkEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCalendar whereWorkStartTime($value)
 */
	class WorkCalendar extends \Eloquent {}
}

