<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTicket;
use Illuminate\Http\Request;

class TicketController extends Controller
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
    public function create($event_id)
    {
        $event = Event::find($event_id);
        return view("tickets.create", compact("event"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $event_id)
    {
        $request->validate([
            "name" => ["required"],
            "cost" => ["required", "integer"],
        ]);
        $specialValidity = null;
        if ($request->special_validity  === "amount") {
            $request->validate([
                "amount" => ["required", "integer"]
            ]);
            $specialValidity = json_encode(["type" => "amount", "amount" => $request->amount]);
        } else if ($request->special_validity  === "date") {
            $request->validate([
                "valid_until" => ["required", "date_format:Y-m-d H:i"]
            ]);
            $specialValidity = json_encode(["type" => "date", "date" => $request->valid_until]);
        }

        EventTicket::create([
            "name" => $request->name,
            "event_id" => $event_id,
            "cost" => $request->cost,
            "special_validity" => $specialValidity
        ]);

        return redirect(route("admin.event.detail", $event_id))->with(["message" => "Ticket successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
