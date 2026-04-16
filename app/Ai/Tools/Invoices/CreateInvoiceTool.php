<?php

namespace App\Ai\Tools\Invoices;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CreateInvoiceTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Create a new invoice record.';
    }

    public function handle(Request $request): Stringable|string
    {
        $invoice = $this->company->invoices()->create($request->all());
        return "Successfully created invoice: {$invoice->invoice_number} (ID: {$invoice->id})";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'invoice_number' => $schema->string()->description('Unique invoice number')->required(),
            'client_id' => $schema->integer()->description('ID of the client')->required(),
            'total_amount' => $schema->number()->description('Total amount of the invoice')->required(),
            'status' => $schema->string()->description('Status (pending, paid, cancelled)')->nullable(),
            'due_date' => $schema->string()->description('Due date (YYYY-MM-DD)')->nullable(),
        ];
    }
}
