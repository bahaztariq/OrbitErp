<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company;

class ApiMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company = $request->route('company');

        if ($company instanceof Company) {
            if (!$company->isMember(auth()->id())) {
                return response()->json([
                    'message' => 'You are not authorized to access this company',
                ], 403);
            }
        } elseif (is_string($company)) {
            $companyModel = Company::where('slug', $company)->first();
            if ($companyModel && !$companyModel->isMember(auth()->id())) {
                return response()->json([
                    'message' => 'You are not authorized to access this company',
                ], 403);
            }
        }

        return $next($request);
    }
}
