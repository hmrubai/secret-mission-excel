<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_type_id' => 'required|exists:project_types,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'priority' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'onhold_postponed_date' => 'nullable|date',
            'status' => 'nullable|string',
            'progress' => 'nullable|integer|min:0|max:100',
            'is_archived' => 'nullable|boolean',
            // 'created_by' => 'nullable|exists:users,id',
        ];
    }
}
