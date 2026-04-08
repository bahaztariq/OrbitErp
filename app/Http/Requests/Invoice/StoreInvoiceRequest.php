<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'invoice_number' => 'required|string|max:100|unique:invoices,invoice_number',
            'order_id' => 'nullable|exists:orders,id',
            'client_id' => 'required|exists:clients,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'string|max:50',
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
            'invoice_number.required' => 'The invoice number is required.',
            'invoice_number.unique' => 'This invoice number is already in use.',
            'client_id.required' => 'A client must be assigned to this invoice.',
            'issue_date.required' => 'The issue date is required.',
            'due_date.required' => 'The due date is required.',
            'due_date.after_or_equal' => 'The due date must be after or equal to the issue date.',
            'total_amount.required' => 'The total amount is required.',
            'company_id.required' => 'A company must be assigned to this invoice.',
        ];
    }
}
