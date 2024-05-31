<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\EventTicket;
use App\Models\ProgramRegistration;
use App\Models\Registration;
use Exception;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $registration = Registration::where([["attendee_id", $request->user()->id], ["ticket_id", $request->ticket_id]])->first();
        if ($registration) return response()->json(["message" => "User already registered"], 401);
        $ticket = EventTicket::find($request->ticket_id);
        if ($ticket === null || $ticket->isAvailable() === false) return response()->json(["message" => "Ticket is no longer available"], 401);
        try {
            $new_registration = Registration::create([
                "attendee_id" => $request->user()->id,
                "ticket_id" => $ticket->id,
                "registration_time" => now()->format("Y-m-d H:i:s"),
            ]);
        } catch (Exception $e) {
            return $e;
        }

        $program_ids = json_decode($request->session_ids);
        foreach ($program_ids as $id) {
            try {
                ProgramRegistration::create(["registration_id" => $new_registration->id, "program_id" => $id]);
            } catch (Exception $e) {
                return $e;
            }
        }
        return response()->json(["message" => "Registration successful"], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $registrations = Registration::with(["ticket.event", "programRegistrations"])->get();
        $formatted_registrations = $registrations->map(function ($registration) {
            return [
                "event" => [
                    "id" => $registration->ticket->event->id,
                    "name" => $registration->ticket->event->name,
                    "slug" => $registration->ticket->event->slug,
                    "date" => $registration->ticket->event->date,
                    "organizer" => [
                        "id" => $registration->ticket->event->organizer->id,
                        "name" => $registration->ticket->event->organizer->name,
                        "slug" => $registration->ticket->event->organizer->slug
                    ]
                ],
                "session_ids" => $registration->programRegistrations->pluck("program_id")
            ];
        });
        return [
            "registrations" => $formatted_registrations
        ];
        // {
        //     "registrations": [
        //         {
        //             "event": {
        //                 "id": 1,
        //                 "name": "someText",
        //                 "slug": "some-text",
        //                 "date": "2019-08-15",
        //                 "organizer": {
        //                     "id": 1,
        //                     "name": "someText",
        //                     "slug": "some-text"
        //                 }
        //             },
        //             "session_ids": [
        //                 1,
        //                 2,
        //                 3
        //             ]
        //         }
        //     ]
        // }
        return Registration::where("attendee_id", $request->user()->id)->get();
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
