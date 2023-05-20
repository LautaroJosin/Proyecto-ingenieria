<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;

class TreatmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Dog $dog)
    {
        return view('treatment.show')->with('dog', $dog);
    }
}
