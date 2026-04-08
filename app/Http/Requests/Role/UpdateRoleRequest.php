<?php

namespace App\Http\Requests\Role;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug,' . $this->role->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'company_id' => 'required|exists:companies,id',
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
            'name.required' => 'The role name is required.',
            'slug.required' => 'The role slug is required.',
            'slug.unique' => 'This role slug is already in use by another role.',
            'company_id.required' => 'A company must be assigned to this role.',
            'company_id.exists' => 'The selected company does not exist.',
        ];
    }
}
