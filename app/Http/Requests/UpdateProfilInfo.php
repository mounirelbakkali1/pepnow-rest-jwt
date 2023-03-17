<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfilInfo extends FormRequest
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
            'old_email' => 'required|string|email|max:255|exists:users,email',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ];
    }


    public function messages()
    {
        return [
            'old_email.required' => 'Old email is required',
            'old_email.exists' => 'Old email is not correct',
            'email.unique' => 'Email is already taken',
            'password.min' => 'Password must be at least 8 characters',
            'password.required' => 'Password is required',
        ];
    }
}
