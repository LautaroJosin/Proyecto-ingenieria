<?php

namespace App\Treatment;
use Illuminate\Http\Request;
use App\Models\Appointment;

interface TreatmentStrategy
{   
    public function store(Request $request, Appointment $appointment);
}