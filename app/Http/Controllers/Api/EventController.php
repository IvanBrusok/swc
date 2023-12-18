<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'unique:events,title'],
            'description' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'result' => []
                ], 401
            );
        }

        $input = $request->all();
        $input['owner_id'] = Auth::id();
        $event = Event::create($input);
        $event->members()->attach(Auth::id());

        return response()->json([
            'error' => null,
            'result' => [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'owner' => [
                    'login' => Auth::user()->login,
                    'first_name' => Auth::user()->first_name,
                    'last_name' => Auth::user()->last_name
                ]
            ]
        ]);
    }

    public function get()
    {
        $result = [];
        foreach(Auth::user()->event as $event) {
            $result[] = [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'created_at' => $event->created_at
            ];
        }
        return response()->json([
            'error' => null,
            'result' => $result
        ]);

    }

    public function participate($id)
    {
        $event = Event::find($id);
        if(!$event) return response()->json([
            'error' => 'Event not found',
            'result' => []
        ]);
        $event->members()->attach(Auth::id());
        return response()->json([
            'error' => null,
            'result' => [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'created_at' => $event->created_at
            ]
        ]);
    }

    public function refuse($id)
    {
        $event = Event::find($id);
        if(!$event) return response()->json([
            'error' => 'Event not found',
            'result' => []
        ]);
        $event->members()->detach(Auth::id());
        return response()->json([
            'error' => null,
            'result' => []
        ]);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        if(!$event) return response()->json([
            'error' => 'Event not found',
            'result' => []
        ]);
        if($event->owner_id !== Auth::id()) return response()->json([
            'error' => 'Only the creator can delete an event',
            'result' => []
        ]);
        $event->delete();
        return response()->json([
            'error' => null,
            'result' => []
        ]);
    }

}
