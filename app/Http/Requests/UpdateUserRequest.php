<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('id'); 
        // or: $this->user?->id if route model binding

        return [
            'name'            => 'sometimes|required|string|max:255',

            'email'           => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'phone'           => 'nullable|string|max:20',
            'gender'          => 'nullable|in:male,female,other',

            'employee_code'   => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'employee_code')->ignore($userId),
            ],

            'hrm_id'          => 'nullable|string|max:50',

            'department_id'   => 'nullable|exists:departments,id',
            'designation_id'  => 'nullable|exists:designations,id',

            'wing'            => 'nullable|string|max:50',
            'address'         => 'nullable|string',

            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'password'        => 'nullable|string|min:8',

            'is_active'       => 'nullable|boolean',
        ];
    }
}
