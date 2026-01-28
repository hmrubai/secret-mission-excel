<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'project_id'  => 'required|exists:projects,id',
            'project_module_id'   => 'nullable|exists:project_modules,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'nullable|in:draft,pending,in_progress,in_review,completed,blocked',
            'start_date'  => 'nullable|date',
            'deadline'    => 'nullable|date|after_or_equal:start_date',
            'priority'    => 'nullable|in:High,Medium,Low',
            'progress'    => 'nullable|integer|min:0|max:100',
        ];
    }
}
