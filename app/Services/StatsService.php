<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class StatsService
{
    /**
     * Get aggregate metrics for a company.
     */
    public function getCompanyMetrics(Company $company): array
    {
        return [
            'clients_count' => $company->clients()->count(),
            'products_count' => $company->products()->count(),
            'invoices_count' => $company->invoices()->count(),
            'orders_count' => $company->orders()->count(),
            'total_revenue' => $company->invoices()->where('status', 'paid')->sum('total_amount'),
        ];
    }

    /**
     * Get monthly revenue trends.
     */
    public function getMonthlyRevenue(Company $company, int $months = 12)
    {
        return $company->invoices()
            ->where('status', 'paid')
            ->where('issue_date', '>=', now()->subMonths($months))
            ->select(
                DB::raw("to_char(issue_date, 'YYYY-MM') as month"),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    /**
     * Get client acquisition trends.
     */
    public function getClientGrowth(Company $company, int $months = 12)
    {
        return $company->clients()
            ->where('created_at', '>=', now()->subMonths($months))
            ->select(
                DB::raw("to_char(created_at, 'YYYY-MM') as month"),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    /**
     * Get order status distribution.
     */
    public function getOrderStatusDist(Company $company)
    {
        return $company->orders()
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
    }

    /**
     * Get invoice status distribution.
     */
    public function getInvoiceStatusDist(Company $company)
    {
        return $company->invoices()
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
    }
}
