<?php

namespace App\Ai\Tools\Invoices;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;
use Illuminate\Support\Carbon;

class CalculateRevenueTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Calculate total revenue for the current month.';
    }

    public function handle(Request $request): Stringable|string
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalRevenue = $this->company->invoices()
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        return "Total Revenue for " . Carbon::now()->format('F Y') . ": $" . number_format($totalRevenue, 2);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'period' => $schema->string()->description('Optional period (e.g., month, year)')->nullable(),
        ];
    }
}
