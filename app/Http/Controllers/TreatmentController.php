<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;
use App\Treatment\TreatmentStrategy;
use App\Models\Appointment;
use App\Providers\TreatmentStrategyServiceProvider;
use App\Models\Reason;

class TreatmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Dog $dog)
    {
        return view('treatment.index')->with('dog', $dog);
    }

    public function create(Appointment $appointment)
    {

        return view('treatment.create')->with('appointment', $appointment);
    }

    public function store(Request $request, Appointment $appointment, TreatmentStrategy $treatment) 
    {
        $appointment = Appointment::find($request->input('appointment_id'));
        $treatment->store($request, $appointment);
        return redirect()->route('appointment.index');
    }
}
