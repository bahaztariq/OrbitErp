<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Models\Company;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $clients = $company->clients;
        return response()->json([
            'message' => 'Clients retrieved successfully',
            'data' => $clients
        ], 200);
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
    public function store(StoreClientRequest $request, Company $company)
    {
        $client = $company->clients()->create($request->validated());

        return response()->json([
            'message' => 'Client created successfully',
            'data' => $client
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Client $client)
    {
        return response()->json([
            'message' => 'Client retrieved successfully',
            'data' => $client
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Client $client)
    {
        $client->delete();

        return response()->json([
            'message' => 'Client deleted successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $client = $company->clients()->onlyTrashed()->findOrFail($id);
        $client->restore();

        return response()->json([
            'message' => 'Client restored successfully',
            'data' => $client
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $client = $company->clients()->onlyTrashed()->findOrFail($id);
        $client->forceDelete();

        return response()->json([
            'message' => 'Client permanently deleted'
        ], 200);
    }
}
