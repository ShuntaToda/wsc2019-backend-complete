<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with("organizer")->orderBy("date", "DESC")->get();
        return $events;
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
    public function show($organizer_slug, $event_slug)
    {
        $eventQuery = Event::where("slug", $event_slug);

        if ($eventQuery->exists() === false) return response()->json(["message" => "Event not found"], 404);


        $event = $eventQuery->with([
            "organizer" => function ($query) use ($organizer_slug) {
                $query->where("slug", $organizer_slug);
            },
            "channels.rooms.programs",
            "tickets"
        ])->first();

        if ($event->organizer === null) return response()->json(["message" => "Organizer not found"], 404);
        return $event;
        //         {
        //   "id": 1,
        //   "name": "someText",
        //   "slug": "some-text",
        //   "date": "2019-08-15",
        //   "channels": [
        //     {
        //       "id": 1,
        //       "name": "someText",
        //       "rooms": [
        //         {
        //           "id": 1,
        //           "name": "someText",
        //           "sessions": [
        //             {
        //               "id": 1,
        //               "title": "someText",
        //               "description": "someText",
        //               "speaker": "someText",
        //               "start": "2019-08-1510: 00: 00",
        //               "end": "2019-08-15 10: 45: 00",
        //               "type": "workshop",
        //               "cost": 50|null
        //             }
        //           ]
        //         }
        //       ]
        //     }
        //   ],
        //   "tickets": [
        //     {
        //       "id": 1,
        //       "name": "someText",
        //       "description": "Available until July 7, 2019"|null,
        //       "cost": 199.99,
        //       "available": true
        //     }
        //   ]
        // }
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
