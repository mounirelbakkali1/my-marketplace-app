<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'password_confirmation' => 'required|string|same:password',
            'role' => 'required|string',
            'permissions' => 'required|array',
        ];
    }
    public function messages(){
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'email.unique' => 'Email is already taken',
            'password.required' => 'Password is required',
            'password_confirmation.required' => 'Password confirmation is required',
            'password_confirmation.same' => 'Password confirmation does not match',
            'role.required' => 'Role is required',
            'permissions.required' => 'Permissions are required',
        ];
    }
}
