<?php

namespace App\Http\Controllers;

use App\Models\Caregiver;
use App\Models\Park;
use Illuminate\Http\Request;

class CaregiverController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:create caregiver')->only('create', 'store');
        $this->middleware('can:edit caregiver')->only('edit', 'update');
        $this->middleware('can:delete caregiver')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('caregiver.index')->with('caregivers', Caregiver::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('caregiver.create')->with('parks', Park::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $caregiver = new Caregiver;

        $this->setCaregiver($request, $caregiver)->save();
        return redirect()->route('caregiver.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Caregiver $caregiver)
    {
        return view('caregiver.edit')->with('caregiver', $caregiver)->with('parks', Park::all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Caregiver $caregiver)
    {
        $this->setCaregiver($request, $caregiver)->save();
        return redirect()->route('caregiver.index');
    }

    /**
     * Saves the request in variable $caregiver.
     */
    public function setCaregiver(Request $request, Caregiver $caregiver): Caregiver
    {
        $park = Park::find($request->input('id_park'));
        $caregiver->park_id = $park->id;
        $caregiver->name = $request->input('name');
        $caregiver->email = $request->input('email');
        return $caregiver;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caregiver $caregiver)
    {
        $caregiver->delete();
        return redirect()->route('caregiver.index');
    }
}
