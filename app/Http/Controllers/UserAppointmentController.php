<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Dog;
use App\Models\Reason;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Enums\AppointmentStatesEnum;
use Carbon\Carbon;

class UserAppointmentController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:show appointment')->only('index');
        $this->middleware('can:create appointment')->only('create', 'store');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('appointment.index')->with('appointments', User::find(Auth::id())->dogs->map->appointments->flatten()->sortBy('date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appointment.create')->with('dogs', User::find(Auth::id())->dogs)->with('reasons', Reason::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $appointment = new Appointment;

        $dog = Dog::find($request->input('id_dog'));
        $reason = Reason::find($request->input('id_reason'));

        $appointment->dog_id = $dog->id;
        $appointment->reason_id = $reason->id;
        $appointment->state = AppointmentStatesEnum::PENDING;
        $appointment->date = $request->input('date');
        $appointment->time = $request->input('time');

        if (! $this->validateDates($dog, $reason, Carbon::parse($request->input('date')))) {
            return redirect()->route('user.appointment.create')->with('error', 'El perro seleccionado no cumple los requisitos para el turno');
        }
        if (! $this->validateDuplicates($dog, $reason)) {
            return redirect()->route('user.appointment.create')->with('error', 'El perro ya tiene un turno solicitado para ese servicio');
        }
        if (! $this->validateCastrationApplication($dog, $reason)) {
            return redirect()->route('user.appointment.create')->with('error', 'El perro ya ha sido castrado');
        }

        if( $this->validateDateTime($dog, $request->input('date') , $request->input('time')) ) {
            return redirect()->route('user.appointment.create')->with('error', 'El perro ya tiene un turno para esta fecha y horario');
        }

        $appointment->save();

        return redirect()->route('appointment.index');
    }

    private function validateDates(Dog $dog, Reason $reason, Carbon $date)
    {
        $ageInDays = $dog->ageInDays() + $date->diffInDays(Carbon::now());
        if ($reason->id == '1' && $ageInDays < 120) {
            return false;
        }
        else if ($reason->id == '2' && $ageInDays < 60) {
            return false;
        }

        return true;
    }

    private function validateCastrationApplication(Dog $dog, Reason $reason): bool
    {
        return $reason->id != '4' || ! $dog->isCastrated();
    }

    private function validateDuplicates(Dog $dog, Reason $reason): bool
    {
        return ! $dog->isWaitingForAppointment($reason);
    }


    private function validateDateTime(Dog $dog , $date , $time) {
        return $dog->hasThisDateTimeAppointment($date,$time);
    }

}
