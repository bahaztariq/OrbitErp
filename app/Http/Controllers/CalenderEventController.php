<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalenderEvent\StoreCalenderEventRequest;
use App\Http\Requests\CalenderEvent\UpdateCalenderEventRequest;
use App\Models\CalenderEvent;
use App\Models\Company;
use Illuminate\Http\Request;

class CalenderEventController extends Controller
{
    public function index(Request $request, Company $company)
    {
        $this->authorize('viewAny', CalenderEvent::class);
        
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        
        $date = \Carbon\Carbon::createFromDate($year, $month, 1);
        $startOfGrid = $date->copy()->startOfMonth()->startOfWeek(\Carbon\Carbon::SUNDAY);
        $endOfGrid = $date->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SATURDAY);
        
        $events = $company->calenderEvents()
            ->whereBetween('event_date', [$startOfGrid, $endOfGrid])
            ->get();
            
        return view('calender-events.index', compact('events', 'company', 'date', 'startOfGrid', 'endOfGrid'));
    }

    public function create(Company $company)
    {
        $this->authorize('create', CalenderEvent::class);
        return view('calender-events.create', compact('company'));
    }

    public function store(StoreCalenderEventRequest $request, Company $company)
    {
        $this->authorize('create', CalenderEvent::class);
        $event = $company->calenderEvents()->create($request->validated());
        return redirect()->route('calender-events.index', $company->slug)
            ->with('success', 'Event created successfully');
    }

    public function show(Company $company, CalenderEvent $calenderEvent)
    {
        $this->authorize('view', $calenderEvent);
        return view('calender-events.show', compact('calenderEvent', 'company'));
    }

    public function edit(Company $company, CalenderEvent $calenderEvent)
    {
        $this->authorize('view', $calenderEvent);
        return view('calender-events.edit', compact('calenderEvent', 'company'));
    }

    public function update(UpdateCalenderEventRequest $request, Company $company, CalenderEvent $calenderEvent)
    {
        $this->authorize('update', $calenderEvent);
        $calenderEvent->update($request->validated());
        return redirect()->route('calender-events.index', $company->slug)
            ->with('success', 'Event updated successfully');
    }

    public function destroy(Company $company, CalenderEvent $calenderEvent)
    {
        $this->authorize('delete', $calenderEvent);
        $calenderEvent->delete();
        return redirect()->route('calender-events.index', $company->slug)
            ->with('success', 'Event deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $event = $company->calenderEvents()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $event);
        $event->restore();
        return redirect()->route('calender-events.index', $company->slug)
            ->with('success', 'Event restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $event = $company->calenderEvents()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $event);
        $event->forceDelete();
        return redirect()->route('calender-events.index', $company->slug)
            ->with('success', 'Event permanently deleted');
    }
}