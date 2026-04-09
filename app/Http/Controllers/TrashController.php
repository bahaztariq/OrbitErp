<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Company;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\CalenderEvent;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index(Company $company)
    {
        $this->authorize('viewAny', Company::class);

        $trashData = [
            'clients' => Client::onlyTrashed()->where('company_id', $company->id)->get(),
            'products' => Product::onlyTrashed()->where('company_id', $company->id)->get(),
            'suppliers' => Supplier::onlyTrashed()->where('company_id', $company->id)->get(),
            'categories' => Category::onlyTrashed()->where('company_id', $company->id)->get(),
            'invoices' => Invoice::onlyTrashed()->where('company_id', $company->id)->get(),
            'orders' => Order::onlyTrashed()->where('company_id', $company->id)->get(),
            'payments' => Payment::onlyTrashed()->where('company_id', $company->id)->get(),
            'conversations' => Conversation::onlyTrashed()->where('company_id', $company->id)->get(),
            'calenderEvents' => CalenderEvent::onlyTrashed()->where('company_id', $company->id)->get(),
            'messages' => Message::onlyTrashed()->whereHas('conversation', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            })->get(),
        ];

        return view('trash.index', compact('trashData', 'company'));
    }

    public function showTrash()
    {
        $this->authorize('viewAny', Company::class);
        $companies = auth()->user()->companies()->onlyTrashed()->get();

        return view('trash.companies', compact('companies'));
    }
}