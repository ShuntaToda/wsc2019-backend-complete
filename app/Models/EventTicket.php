<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "event_id",
        "cost",
        "special_validity"
    ];
    public $timestamps = false;


    protected $appends = ["available", "description"];

    public function registrations()
    {
        return $this->hasMany(Registration::class, "ticket_id");
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function isAvailable()
    {
        if ($this->special_validity === null) return true;
        $special_validity = json_decode($this->special_validity);
        switch ($special_validity->type) {
            case ("amount"):
                $ticket_count = $this->registrations()->count();
                return $ticket_count <= $special_validity->amount;
            case ("date"):
                $target_date = $special_validity->date;
                $current_data = date("Y-m-d");
                return $target_date >= $current_data;
            default:
                return true;
        };
    }

    public function getAvailableAttribute()
    {
        return $this->isAvailable();
    }

    public function getDescriptionAttribute()
    {
        if ($this->special_validity === null && $this->isAvailable() === false) return null;
        $special_validity = json_decode($this->special_validity);
        switch ($special_validity->type) {
            case ("amount"):
                $ticket_count = $this->registrations()->count();
                return $special_validity->amount - $ticket_count . "tickets available";
            case ("date"):
                $target_date = $special_validity->date;
                return "Available until " . $target_date;
            default:
                return true;
        };
    }

    public function getDetailSpecailValidity()
    {
        $validity = json_decode($this->special_validity);

        if ($validity === null) return null;

        // dd($validity);
        switch ($validity->type) {
            case ("amount"):
                return ["type" => "amount", "value" => $validity->amount - $this->registrations->count()];
            case ("date"):
                return ["type" => "date", "value" => $validity->date];
        }
    }
}
