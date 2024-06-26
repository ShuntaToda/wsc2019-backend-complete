<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        "organizer_id",
        "name",
        "slug",
        "date",
    ];

    public $timestamps = false;

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }
    public function channels()
    {
        return $this->hasMany(Channel::class);
    }
    public function tickets()
    {
        return $this->hasMany(EventTicket::class);
    }

    public function registrations()
    {
        return $this->hasManyThrough(Registration::class, EventTicket::class, "event_id", "ticket_id");
    }
    public function programs()
    {
        return $this->hasManyThrough(Program::class, Room::class, "event_id", "ticket_id");
    }
}
