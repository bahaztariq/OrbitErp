<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

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
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $this->authorize('viewAny', Company::class);

        $clients = Client::onlyTrashed()->where('company_id', $company->id)->get();
        $products = Product::onlyTrashed()->where('company_id', $company->id)->get();
        $suppliers = Supplier::onlyTrashed()->where('company_id', $company->id)->get();
        $invoices = Invoice::onlyTrashed()->where('company_id', $company->id)->get();
        $orders = Order::onlyTrashed()->where('company_id', $company->id)->get();
        $payments = Payment::onlyTrashed()->where('company_id', $company->id)->get();
        $conversations = Conversation::onlyTrashed()->where('company_id', $company->id)->get();
        $calenderEvents = CalenderEvent::onlyTrashed()->where('company_id', $company->id)->get();
        $categories = Category::onlyTrashed()->where('company_id', $company->id)->get();
        
        $messages = Message::onlyTrashed()->whereHas('conversation', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->get();

        return response()->json([
            'clients' => $clients,
            'products' => $products,
            'suppliers' => $suppliers,
            'categories' => $categories,
            'invoices' => $invoices,
            'orders' => $orders,
            'payments' => $payments,
            'messages' => $messages,
            'conversations' => $conversations,
            'calenderEvents' => $calenderEvents,
        ]);
    }

    public function ShowTrash()
    {
        $this->authorize('viewAny', Company::class);
        $companies = auth()->user()->companies()->onlyTrashed()->get();


        return response()->json([
            'companies' => $companies,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}