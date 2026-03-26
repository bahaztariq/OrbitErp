<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInvitationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'sometimes|required|email|max:255',
            'company_id' => 'sometimes|required|exists:companies,id',
            'token' => 'sometimes|required|string|unique:invitations,token,' . $this->invitation->id,
            'status' => 'sometimes|required|in:pending,accepted,declined',
            'expired_at' => 'nullable|date',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The invitation email is required.',
            'email.email' => 'Please provide a valid email address.',
            'company_id.required' => 'The company is required for the invitation.',
            'role_id.required' => 'A role must be assigned to the invitation.',
            'token.required' => 'A unique token is required.',
            'status.in' => 'The status must be one of: pending, accepted, rejected.',
        ];
    }
}
