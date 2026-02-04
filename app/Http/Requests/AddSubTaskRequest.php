<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddSubTaskRequest extends FormRequest
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
            'task_id' => 'required|exists:tasks,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|in:Low,Medium,High',
        ];
    }

    public function messages(): array
    {
        return [
            'task_id.required' => 'Task ID is required.',
            'task_id.exists' => 'Task ID does not exist.',
            'title.required' => 'Title is required.',
            'title.string' => 'Title must be a string.',
            'title.max' => 'Title must be less than 255 characters.',
            'description.string' => 'Description must be a string.',
            'priority.in' => 'Priority must be Low, Medium, or High.', 
            'priority.sometimes' => 'Priority must be Low, Medium, or High.', 
        ];
    }
}
