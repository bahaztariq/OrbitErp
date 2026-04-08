<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Company $company)
    {
        $clients = $company->clients;
        return view('clients.index', compact('clients', 'company'));
    }

    public function create(Company $company)
    {
        return view('clients.create', compact('company'));
    }

    public function store(StoreClientRequest $request, Company $company)
    {
        $client = $company->clients()->create($request->validated());
        return redirect()->route('clients.index', $company->slug)
            ->with('success', 'Client created successfully');
    }

    public function show(Company $company, Client $client)
    {
        return view('clients.show', compact('client', 'company'));
    }

    public function edit(Company $company, Client $client)
    {
        return view('clients.edit', compact('client', 'company'));
    }

    public function update(UpdateClientRequest $request, Company $company, Client $client)
    {
        $client->update($request->validated());
        return redirect()->route('clients.index', $company->slug)
            ->with('success', 'Client updated successfully');
    }

    public function destroy(Company $company, Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index', $company->slug)
            ->with('success', 'Client deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $client = $company->clients()->onlyTrashed()->findOrFail($id);
        $client->restore();
        return redirect()->route('clients.index', $company->slug)
            ->with('success', 'Client restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $client = $company->clients()->onlyTrashed()->findOrFail($id);
        $client->forceDelete();
        return redirect()->route('clients.index', $company->slug)
            ->with('success', 'Client permanently deleted');
    }
}
