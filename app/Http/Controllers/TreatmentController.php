<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;
use App\Treatment\TreatmentStrategy;
use App\Models\Appointment;
use App\Treatment\TreatmentFactory;
use App\Models\Reason;
use App\Enums\AppointmentStatesEnum;

class TreatmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:create treatment')->only('create', 'store');
    }

    public function index(Dog $dog)
    {
        return view('treatment.index')->with('dog', $dog);
    }

    public function create(Appointment $appointment)
    {

        return view('treatment.create')->with('appointment', $appointment);
    }

    public function store(Request $request, Appointment $appointment) 
    {
        TreatmentFactory::create($appointment->reason->reason)->store($request, $appointment);
        $appointment->state = AppointmentStatesEnum::ACOMPLISHED;
        if ($appointment->reason->id == '4') $appointment->dog->is_on_tinder = false;
        $appointment->dog->save();
        $appointment->save();
        return redirect()->route('appointment.index');
    }
}
