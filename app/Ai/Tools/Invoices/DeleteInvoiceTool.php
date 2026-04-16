<?php

namespace App\Ai\Tools\Invoices;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class DeleteInvoiceTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Delete an invoice by its ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('id');
        $invoice = $this->company->invoices()->find($id);
        
        if (!$invoice) return "Error: Invoice not found.";

        $num = $invoice->invoice_number;
        $invoice->delete();
        return "Successfully deleted invoice: {$num}";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('ID of the invoice to delete')->required(),
        ];
    }
}
