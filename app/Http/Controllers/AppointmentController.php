<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function filter(Request $request)
    {
        if ($request->filled('state')) {
            $query = Appointment::where('state', '=', $request->input('state'))->get();
        }
        else {
            $query = Appointment::all();
        }
        return view('appointment.index')->with('appointments', $query);
    }
}
