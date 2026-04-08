<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'order_number' => 'required|string|max:255|unique:orders,order_number',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'client_id' => 'required|exists:clients,id',
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
            'order_number.required' => 'The order number is required.',
            'order_number.unique' => 'This order number has already been used.',
            'status.in' => 'The status must be one of: pending, processing, shipped, delivered, cancelled.',
            'client_id.required' => 'A client must be assigned to this order.',
            'company_id.required' => 'A company must be assigned to this order.',
        ];
    }
}
