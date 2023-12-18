<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function getAll()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function member()
    {
        $events = Auth::user()->events;
        return response()->json($events);
    }

    public function get($id)
    {
        $event = Event::find($id);
        $event->members;
        $event->participate = ($event->members->contains(Auth::user()));
        return response()->json($event);
    }

    public function participate($id)
    {
        $event = Event::find($id);
        if(!$event) return response()->json([
            'status' => 'false'
        ]);
        $event->members()->attach(Auth::id());
        return response()->json(['status' => 'success']);
    }

    public function refuse($id)
    {
        $event = Event::find($id);
        if(!$event) return response()->json([
            'status' => 'false'
        ]);
        $event->members()->detach(Auth::id());
        return response()->json(['status' => 'success']);
    }
}
