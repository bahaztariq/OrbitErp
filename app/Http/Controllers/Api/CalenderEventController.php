<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\CalenderEvent\StoreCalenderEventRequest;
use App\Http\Requests\CalenderEvent\UpdateCalenderEventRequest;
use App\Models\CalenderEvent;
use App\Models\Company;
use Illuminate\Support\Facades\Cache;

class CalenderEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $this->authorize('viewAny', CalenderEvent::class);
        $calender = $company->calenderEvents;
        
        return response()->json([
            'message' => 'Events retrieved successfully',
            'data' => $calender
        ], 200);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', CalenderEvent::class);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCalenderEventRequest $request, Company $company)
    {
        $this->authorize('create', CalenderEvent::class);
        $event = $company->calenderEvents()->create($request->validated());

        return response()->json([
            'message' => 'Event created successfully',
            'data' => $event
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, CalenderEvent $calenderEvent)
    {
        $this->authorize('view', $calenderEvent);
        return response()->json([
            'message' => 'Event retrieved successfully',
            'data' => $calenderEvent
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCalenderEventRequest $request, Company $company, CalenderEvent $calenderEvent)
    {
        $this->authorize('update', $calenderEvent);
        $calenderEvent->update($request->validated());

        return response()->json([
            'message' => 'Event updated successfully',
            'data' => $calenderEvent
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, CalenderEvent $calenderEvent)
    {
        $this->authorize('delete', $calenderEvent);
        $calenderEvent->delete();
        return response()->json([
            'message' => 'Event deleted successfully',
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $event = $company->calenderEvents()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $event);
        $event->restore();

        return response()->json([
            'message' => 'Event restored successfully',
            'data' => $event
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $event = $company->calenderEvents()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $event);
        $event->forceDelete();

        return response()->json([
            'message' => 'Event permanently deleted'
        ], 200);
    }
}