<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use Illuminate\Http\Request;

class DogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dog.index')->with('dogs', Dog::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->setDog($request, new Dog)->save();

    }

    /**
     * Display the specified resource.
     */
    public function show(Dog $dog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dog $dog)
    {
        return view('dog.edit')->with('dog', $dog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dog $dog)
    {
        $this->setDog($request, $dog)->save();
        return redirect()->route('dog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dog $dog)
    {
        $dog->delete();
        return redirect()->route('dog.index');
    }

    private function setDog(Request $request, Dog $dog): Dog
    {
        $dog->name = $request->input('name');
        $dog->gender = $request->input('gender');
        $dog->race = $request->input('race');
        $dog->description = $request->input('description');
        $dog->date_of_birth = $request->input('date_of_birth');
        $dog->photo = $request->input('photo');
        return $dog;
    }
}
