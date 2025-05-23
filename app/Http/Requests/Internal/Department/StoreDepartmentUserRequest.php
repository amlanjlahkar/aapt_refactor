<?php

namespace App\Http\Requests\Internal\Department;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:department_users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'string'],
        ];
    }
}
