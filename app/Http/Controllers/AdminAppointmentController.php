<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatesEnum;
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

    public function index()
    {
        return view('appointment.index')->with('appointments', Appointment::all());
    }

    public function confirm(Appointment $appointment)
    {
        $appointment->state = AppointmentStatesEnum::CONFIRMED;
        $appointment->save();
        return redirect()->route('appointment.index');
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->state = AppointmentStatesEnum::CANCELLED;
        if($appointment->discountAlreadyApplied) $this->revertDiscount($appointment);
        $appointment->save();
        return redirect()->route('appointment.index');
    }

    public function missing(Appointment $appointment)
    {
        $appointment->state = AppointmentStatesEnum::MISSING;
        if($appointment->discountAlreadyApplied) $this->revertDiscount($appointment);
        $appointment->save();
        return redirect()->route('appointment.index');
    }

    public function reject(Appointment $appointment)
    {
        return view('appointment.writeReason')->with('appointment', $appointment);
    }

    public function sendMail(Request $request, Appointment $appointment) {
        //String $content = $request->input('content');
        
        Mail::raw($request->input('content'), function ($message) use ($appointment) {
            $to = $appointment->dog->user->email;
            $message->to($to)
                ->subject('Turno rechazado');
        });
        $appointment->state = AppointmentStatesEnum::REJECTED;
        $appointment->save();
        return redirect()->route('appointment.index');
        
    }

    /* Recibe un turno y revierte el descuento aplicado */
    
    private function revertDiscount(Appointment $appointment) {
        $user = $appointment->dog->user;

        $user->credits = $appointment->credits_to_show;

        $user->save();

        $appointment->discount_applied = 0;

    }
}
