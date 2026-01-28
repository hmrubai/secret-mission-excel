<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'project_id'  => 'sometimes|exists:projects,id',
            'project_module_id'   => 'sometimes|nullable|exists:project_modules,id',
            'title'       => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'status'      => 'sometimes|in:draft,pending,in_progress,in_review,completed,blocked',
            'start_date'  => 'sometimes|nullable|date',
            'deadline'    => 'sometimes|nullable|date|after_or_equal:start_date',
            'priority'    => 'sometimes|in:High,Medium,Low',
            'progress'    => 'sometimes|integer|min:0|max:100',
        ];
    }
}
