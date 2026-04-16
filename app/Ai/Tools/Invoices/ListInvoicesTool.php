<?php

namespace App\Ai\Tools\Invoices;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ListInvoicesTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'List all invoices for the current company.';
    }

    public function handle(Request $request): Stringable|string
    {
        $invoices = $this->company->invoices()->latest()->get();

        if ($invoices->isEmpty()) {
            return "No invoices found.";
        }

        $output = "### Invoices List\n\n| ID | Number | Total | Status | Due Date |\n|---|---|---|---|---|\n";
        foreach ($invoices as $invoice) {
            $output .= "| {$invoice->id} | {$invoice->invoice_number} | \${$invoice->total_amount} | {$invoice->status} | {$invoice->due_date} |\n";
        }
        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'status' => $schema->string()->description('Optional status filter (pending, paid, cancelled)')->nullable(),
        ];
    }
}
