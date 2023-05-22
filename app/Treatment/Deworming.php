<?php

namespace App\Treatment;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Treatment;

class Deworming implements TreatmentStrategy
{   

    public function store(Request $request, Appointment $appointment)
    {
        $treatment = new Treatment;
        $treatment->date_of_appointment = $appointment->date;
        $treatment->reason = $appointment->reason->reason;
        $treatment->weight = $request->input('weight');
        $treatment->vaccine = null;
        $treatment->dewormer = $request->input('amountOfDewormer');
        $treatment->dog_id = $appointment->dog->id;
        $treatment->save();
    }
}