<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalenderEvent\StoreCalenderEventRequest;
use App\Http\Requests\CalenderEvent\UpdateCalenderEventRequest;
use App\Models\CalenderEvent;
use App\Models\Company;
use Illuminate\Http\Request;

class CalenderEventController extends Controller
{
    public function index(Company $company)
    {
        $events = $company->calenderEvents;
        return view('calender-events.index', compact('events', 'company'));
    }

    public function create(Company $company)
    {
        return view('calender-events.create', compact('company'));
    }

    public function store(StoreCalenderEventRequest $request, Company $company)
    {
        $event = $company->calenderEvents()->create($request->validated());
        return redirect()->route('calender-events.index', $company->slug)
            ->with('success', 'Event created successfully');
    }

    public function show(Company $company, CalenderEvent $calenderEvent)
    {
        return view('calender-events.show', compact('calenderEvent', 'company'));
    }

    public function edit(Company $company, CalenderEvent $calenderEvent)
    {
        return view('calender-events.edit', compact('calenderEvent', 'company'));
    }

    public function update(UpdateCalenderEventRequest $request, Company $company, CalenderEvent $calenderEvent)
    {
        $calenderEvent->update($request->validated());
        return redirect()->route('calender-events.index', $company->slug)
            ->with('success', 'Event updated successfully');
    }

    public function destroy(Company $company, CalenderEvent $calenderEvent)
    {
        $calenderEvent->delete();
        return redirect()->route('calender-events.index', $company->slug)
            ->with('success', 'Event deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $event = $company->calenderEvents()->onlyTrashed()->findOrFail($id);
        $event->restore();
        return redirect()->route('calender-events.index', $company->slug)
            ->with('success', 'Event restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $event = $company->calenderEvents()->onlyTrashed()->findOrFail($id);
        $event->forceDelete();
        return redirect()->route('calender-events.index', $company->slug)
            ->with('success', 'Event permanently deleted');
    }
}
