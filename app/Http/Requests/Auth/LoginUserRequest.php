<?php


namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;



class LoginUserRequest extends FormRequest {


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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'The email does not exist.',
            'password.min' => 'The password must be at least 8 characters long.',
            'email.required' => 'The email is required.',
            'password.required' => 'The password is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not be longer than 255 characters.',
        ];
    }
}