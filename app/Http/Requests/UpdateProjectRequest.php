<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'project_type_id' => 'sometimes|required|exists:project_types,id',
            'vendor_id' => 'sometimes|nullable|exists:vendors,id',
            'priority' => 'sometimes|string',
            'start_date' => 'sometimes|nullable|date',
            'end_date' => 'sometimes|nullable|date|after_or_equal:start_date',
            'onhold_postponed_date' => 'sometimes|nullable|date',
            'deadline' => 'sometimes|required|date|after_or_equal:start_date',
            'status' => 'sometimes|string',
            'progress' => 'sometimes|nullable|integer|min:0|max:100',
            'is_archived' => 'sometimes|boolean',
            'created_by' => 'sometimes|nullable|exists:users,id',
        ];
    }
}
