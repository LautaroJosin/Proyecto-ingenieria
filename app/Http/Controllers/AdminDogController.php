<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


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
        
        $user = User::where('dni', $request->input('dni'))->first();
        if ($user === null) return redirect()->back()->with('error', 'Usuario no encontrado.');

        $dog->user_id = $user->id;
        $this->setDog($request, $dog)->save();

        return redirect()->route('dog.index');
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
        //Storage::delete($dog->photo); --> No anda y no sé por qué. Pero son las 00:30 am y me quiero ir a dormir.
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
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'required|image',
            ]);
            $url = $request->file('photo')->store('public/dogs');
            $dog->photo = Storage::url($url);
        }
        return $dog;
    }
}
