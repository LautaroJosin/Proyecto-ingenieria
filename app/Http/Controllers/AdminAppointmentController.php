<?php

namespace App\Http\Controllers;

use App\Mail\RejectMaileable;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminAppointmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:show appointment')->only('index');
        $this->middleware('can:edit appointment')->only('confirm');
        $this->middleware('can:delete appointment')->only('reject');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('appointment.index')->with('appointments', Appointment::all());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $appointment->state = "C";
        $appointment->save();
        return redirect()->route('appointment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        $mail = new RejectMaileable();
        $to = $appointment->dog->user->email;
        Mail::to($to)->send($mail);
        return redirect()->route('appointment.index');
    }


    public function explainAppointmentRejection(Request $request, Appointment $appointment)
    {
        $to = $appointment->dog->user->email;
        $why = $request->input('reason');
        $mail = $this->buildMailMessage($why);
        
        return redirect()->route('appointment.index');
    }
}
