<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $attendee = Attendee::where("lastname", $request->lastname)->first();
        if ($attendee !== null && $attendee->registration_code === $request->registration_code) {
            return $attendee->createToken($request->lastname)->plainTextToken;
        }

        return response()->json(["message" => "Invalid login"], 401);
    }
}
