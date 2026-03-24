<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalenderEventRequest;
use App\Http\Requests\UpdateCalenderEventRequest;
use App\Models\CalenderEvent;

class CalenderEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreCalenderEventRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CalenderEvent $calenderEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CalenderEvent $calenderEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCalenderEventRequest $request, CalenderEvent $calenderEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CalenderEvent $calenderEvent)
    {
        //
    }
}
