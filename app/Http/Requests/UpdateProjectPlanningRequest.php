<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectPlanningRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'planning_type_id'  => 'sometimes|exists:planning_types,id',
            'description'       => 'nullable|string',
            'start_date'        => 'sometimes|date',
            'end_date'          => 'sometimes|date|after_or_equal:start_date',
            'exclude_weekends'  => 'nullable|boolean',
            'exclude_holidays'  => 'nullable|boolean',
            'progress'          => 'nullable|integer|min:0|max:100',
            'status'            => 'nullable|in:pending,running,completed,on_hold',
        ];
    }
}
