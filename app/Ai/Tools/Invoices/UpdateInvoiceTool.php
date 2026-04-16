<?php

namespace App\Ai\Tools\Invoices;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class UpdateInvoiceTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Update an invoice by its ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('id');
        $invoice = $this->company->invoices()->find($id);
        
        if (!$invoice) return "Error: Invoice not found.";

        $invoice->update($request->all());
        return "Successfully updated invoice: {$invoice->invoice_number}";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('ID of the invoice to update')->required(),
            'total_amount' => $schema->number()->description('Updated total amount')->nullable(),
            'status' => $schema->string()->description('Updated status')->nullable(),
            'due_date' => $schema->string()->description('Updated due date')->nullable(),
        ];
    }
}
