<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    use HasFactory;

    public function registrations()
    {
        return $this->hasMany(Registration::class, "ticket_id");
    }

    public function isAvailable()
    {
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
}
