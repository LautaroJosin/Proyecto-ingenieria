<?php

namespace App\Treatment;

use App\Mail\NextTreatmentMailable;
use Illuminate\Http\Request;
use App\Models\Treatment;
use App\Models\Appointment;
use App\Models\Reason;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class vaccineAgainstDiseases implements TreatmentStrategy
{   

    public function store(Request $request, Appointment $appointment)
    {
        $this->setTreatment($appointment, $request)->save();
        $userEmail = $appointment->dog->user->email;
        Mail::to($userEmail)->send(new NextTreatmentMailable($this->nextTreatmentDate($appointment)));
    }

    public function nextTreatmentDate(Appointment $appointment): Carbon
    {
        if ($appointment->dog->ageInMonths() > 4) {
            return $appointment->date->addYears(1);
        }
        else {
            return $appointment->date->addDays(21);
        }
    }

    public function setTreatment(Appointment $appointment, Request $request): Treatment
    {
        $treatment = new Treatment;
        $treatment->date_of_appointment = $appointment->date;
        $treatment->reason = $appointment->reason->reason;
        $treatment->weight = $request->input('weight');
        $treatment->vaccine = $appointment->reason->reason;
        $treatment->dewormer = null;
        $treatment->dog_id = $appointment->dog->id;
        return $treatment;
    }
}