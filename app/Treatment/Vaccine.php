<?php

namespace App\Treatment;

use App\Mail\NextTreatmentMailable;
use App\Models\Appointment;
use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Vaccine implements TreatmentStrategy
{

    public function store(Request $request, Appointment $appointment): void
    {
        $this->setTreatment($appointment, $request)->save();
        $userEmail = $appointment->dog->user->email;
        Mail::to($userEmail)->send(new NextTreatmentMailable($this->nextTreatmentDate($appointment)));
    }

    public function nextTreatmentDate(Appointment $appointment): Carbon
    {
        return $appointment->dog->ageInMonths() > 4 ? $appointment->date->addYears(1) : $appointment->date->addDays(21);
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