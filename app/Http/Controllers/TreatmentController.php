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

    public function create(Appointment $appointment)
    {
        return view('treatment.create')->with('appointment', $appointment);
    }

    public function show(Dog $dog)
    {
        return view('treatment.show')->with('dog', $dog);
    }

    public function store(Request $request, Appointment $appointment, TreatmentStrategy $treatment) 
    {
        $appointment = Appointment::find($request->input('appointment_id'));
        return $treatment->store($request, $appointment);
    }
}
