<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistrationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'phone' => ['required', 'nullable', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'First name is required.',
            'name.max'      => 'First name must not exceed 100 characters.',

            'email.required'      => 'Email address is required.',
            'email.email'         => 'Please enter a valid email address.',
            'email.max'           => 'Email must not exceed 100 characters.',
            'email.unique'        => 'This email is already registered.',

            'phone.required'      => 'Phone no is required.',
            'phone.max'           => 'Phone number must not exceed 15 characters.',

            'password.required'   => 'Password is required.',
            'password.min'        => 'Password must be at least 8 characters.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 422));
    }
}
