<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('adminDog.index')->with('dogs', Dog::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adminDog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dog = new Dog;
        $user = User::where('dni', $request->input('DNI'))->first();
        if ($user === null) return redirect()->back()->with('error', 'Usuario no encontrado.');
        $dog->user_id = $user->id;
        $this->setDog($request, $dog)->save();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dog $dog)
    {
        return view('adminDog.edit')->with('dog', $dog);
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
        $dog->treatments()->delete();
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
