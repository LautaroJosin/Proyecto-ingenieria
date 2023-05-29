<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionDog;
use App\Models\User;
use Illuminate\Validation\Rule;


class AdoptionDogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('adoptionDog.index')->with('dogs', AdoptionDog::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adoptionDog.create');
    }

    /**
     * Store a NEWLY created resource in storage. (Almacena por primera vez)
     */
    public function store(Request $request)
    {
        
        $dog = new AdoptionDog;

        /*
        $request->validate([ /* Deberia validar que el perro no exista ya en la lista 
            
        ]);
        */
				
        $dog->user_id = auth()->user()->id;
        $this->setDog($request, $dog)->save();
		
        return redirect()->route('adoption.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
	

	 private function setDog(Request $request, AdoptionDog $dog): AdoptionDog
    {
        $dog->gender = $request->input('gender');
        $dog->race = $request->input('race');
        $dog->description = $request->input('description');
		$dog->size = $request->input('size');
        $dog->date_of_birth = $request->input('date_of_birth');
				
        return $dog;
    }
}
