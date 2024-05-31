<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where("organizer_id", Auth::user()->id)->orderBy("date")->get();
        return view("events.index", compact("events"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("events.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => ["required"],
            "slug" => ["required", "unique:events", "regex:/^[a-z0-9-]+$/"],
            "date" => ["required", "date_format:Y-m-d"],
        ], [
            "slug.unique" => "Slug is already used",
            "slug.regex" => "Slug must not be empty and only contain a-z, 0-9 and '-'",
            "slug.required" => "Slug must not be empty and only contain a-z, 0-9 and '-'",
        ]);


        $event = Event::create([
            "organizer_id" => Auth::user()->id,
            "name" => $request->name,
            "slug" => $request->slug,
            "date" => $request->date,
        ]);

        return redirect(route("admin.event.detail"))->with(["message" => "Event successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::find($id);
        return view("events.detail", compact("event"));
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
