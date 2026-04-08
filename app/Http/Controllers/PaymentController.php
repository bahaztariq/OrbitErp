<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Models\Payment;
use App\Models\Company;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Company $company)
    {
        $payments = $company->payments;
        return view('payments.index', compact('payments', 'company'));
    }

    public function create(Company $company)
    {
        return view('payments.create', compact('company'));
    }

    public function store(StorePaymentRequest $request, Company $company)
    {
        $payment = $company->payments()->create($request->validated());
        return redirect()->route('payments.index', $company->slug)
            ->with('success', 'Payment created successfully');
    }

    public function show(Company $company, Payment $payment)
    {
        return view('payments.show', compact('payment', 'company'));
    }

    public function edit(Company $company, Payment $payment)
    {
        return view('payments.edit', compact('payment', 'company'));
    }

    public function update(UpdatePaymentRequest $request, Company $company, Payment $payment)
    {
        $payment->update($request->validated());
        return redirect()->route('payments.index', $company->slug)
            ->with('success', 'Payment updated successfully');
    }

    public function destroy(Company $company, Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index', $company->slug)
            ->with('success', 'Payment deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $payment = $company->payments()->onlyTrashed()->findOrFail($id);
        $payment->restore();
        return redirect()->route('payments.index', $company->slug)
            ->with('success', 'Payment restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $payment = $company->payments()->onlyTrashed()->findOrFail($id);
        $payment->forceDelete();
        return redirect()->route('payments.index', $company->slug)
            ->with('success', 'Payment permanently deleted');
    }
}
