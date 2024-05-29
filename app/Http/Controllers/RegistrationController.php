<?php

namespace App\Http\Controllers;

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
    public function show(string $id)
    {
        //
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
