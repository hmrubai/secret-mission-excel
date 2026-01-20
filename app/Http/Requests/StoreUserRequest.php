<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|max:255|unique:users,email',
            'phone'           => 'nullable|string|max:20',
            'gender'          => 'nullable|in:male,female,other',
            'employee_code'   => 'required|string|max:50|unique:users,employee_code',
            'hrm_id'          => 'nullable|string|max:50',

            'department_id'   => 'nullable|exists:departments,id',
            'designation_id'  => 'nullable|exists:designations,id',

            'wing'            => 'nullable|string|max:50',
            'address'         => 'nullable|string',

            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'password'        => 'required|string|min:8',
            'is_active'       => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Default values
        $this->merge([
            'is_active' => $this->is_active ?? true,
        ]);
    }
}
