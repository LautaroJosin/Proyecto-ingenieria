<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
        return view('appointment.index')->with('appointments', User::find(Auth::id())->dogs->appointments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Esto lo hizo copilot, y tiene sentido -> return view('appointment.create')->with('dogs', User::find(Auth::id())->dogs)->with('reasons', Reason::all());
        return view('appointment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $appointment = new Appointment;
        $dog = $request->input('dog');
        $reason = $request->input('reason');

        $appointment->dog_id = $dog->id;
        $appointment->reason_id = $reason->id;
        $appointment->state = "P";
        if ($this->validateDates($request)) $appointment->date = $request->input('date');
        
        $appointment->save();

        return redirect()->route('user.appointment.index');
    }

    private function validateDates(Request $request)
    {
        $currentDate = Carbon::now();
        $dogAgeMonths = $request->dog->ageInMonths();
        $reason = $request->reason->reason;

        $validator = \Illuminate\Support\Facades\Validator::make(
            [
                'date' => $request->date,
                'reason' => $reason,
            ],
            [
                'date' => ['required', 'after:now'],
                'reason' => [
                    'required',
                    Rule::in(['vacuna antirrábica', 'vacuna contra enfermedades']),
                        Rule::when($dogAgeMonths < 4, function ($attribute, $value, $fail) use ($reason) {
                            if ($reason === 'Vacuna antirrábica') {
                                $fail('El perro no cumple los requisitos para la vacuna antirrábica.');
                            }
                        }),
                        Rule::when($dogAgeMonths < 2, function ($attribute, $value, $fail) use ($reason) {
                            if ($reason === 'Vacuna contra enfermedades') {
                                $fail('El perro no cumple los requisitos para la vacuna contra enfermedades.');
                            }
                        }),
                ],
            ],
            [
                'date.required' => 'El campo fecha es obligatorio.',
                'date.after' => 'El campo fecha debe ser posterior a la fecha actual.',
                'reason.required' => 'El campo motivo es obligatorio.',
                'reason.in' => 'El motivo seleccionada no es válida. El perro no tiene la edad necesaria.',
            ]
        );

        if ($validator->fails()) throw new ValidationException($validator);

        return true;
    }
}
