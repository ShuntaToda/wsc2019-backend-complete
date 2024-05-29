<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    protected $fillable = [
        "attendee_id",
        "ticket_id",
        "registration_time"
    ];

    public $timestamps = false;
}
