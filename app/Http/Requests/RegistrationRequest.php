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
            'name'             => ['required', 'string', 'min:2'],
            'email'            => ['required', 'email:filter', 'unique:users,email'],
            'phone'            => ['required', 'string', 'unique:users,phone'],
            'password'         => ['required', 'string', 'min:6', 'max:8', 'same:confirm_password'],
            'confirm_password' => ['required', 'string'],
            'terms_condition'  => ['required', 'boolean'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => 422
        ], 422));
    }
}