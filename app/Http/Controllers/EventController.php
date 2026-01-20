<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\EventResource;


class EventController extends Controller
{
    //
    public function index()
    {
        return EventResource::collection(Event::latest()->paginate(5));
    }

    public function show($id)
    {
        return new EventResource(Event::findOrFail($id));
    }

    public function store(Request $request)
    {
        try {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'event_date' => 'required|date'
        ]);

        return response()->json([
            'success' => true,
            'data' => Event::create($data)
        ], 201);

        } catch (ValidationException $e) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422));
        }
    }

    public function join($id)
    {
        $event = Event::findOrFail($id);

        if ($event->users()->where('user_id', auth()->id())->exists()) {
            return response()->json(['message' => 'Already joined'], 400);
        }

        $event->users()->attach(auth()->id());

        return response()->json(['message' => 'Joined successfully']);
    }
}
