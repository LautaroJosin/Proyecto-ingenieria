<?php

namespace App\Treatment;
use Illuminate\Http\Request;
use App\Models\Treatment;
use App\Models\Appointment;
use App\Models\Reason;


class Others implements TreatmentStrategy
{   

    public function store(Request $request, Appointment $appointment)
    {
        $treatment = new Treatment;
        $treatment->date_of_appointment = $appointment->date;
        $treatment->reason = $appointment->reason->reason;
        $treatment->weight = $request->input('weight');
        $treatment->vaccine = null;
        $treatment->dewormer = null;
        $treatment->dog_id = $appointment->dog->id;
        $treatment->save();
    }
}