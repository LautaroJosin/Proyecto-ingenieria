<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class DogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:show dog')->only('index', 'show');
        $this->middleware('can:create dog')->only('create', 'store');
        $this->middleware('can:edit dog')->only('edit', 'update');
        $this->middleware('can:delete dog')->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->can('have dog')) {
            return view('dog.index')->with('dogs', User::find(Auth::id())->dogs);
        }
        else {
            return view('dog.index')->with('dogs', Dog::all());
        }
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
        $dog = new Dog;
        
        $request->validate([
            'dni' => [
                'required',
                Rule::exists('users', 'dni')->where(function ($query) use ($request) {
                    $query->where('dni', $request->input('dni'));
                }),
            ],
        ], [
            'dni.required' => 'El campo DNI es obligatorio',
            'dni.exists' => 'Usuario no encontrado',
        ]);

        $user = User::where('dni', $request->input('dni'))->first();
        $dog->user_id = $user->id;
        $this->setDog($request, $dog)->save();
        return redirect()->route('dog.index');
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
        $dog->treatments()->delete();
        $dog->appointments()->delete();
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

    public function enterTinder(Dog $dog) {
        $dog->is_on_tinder = true;
        $dog->save();
        return redirect()->route('dog.index');
    }

    public function leaveTinder(Dog $dog) {
        $dog->is_on_tinder = false;
        $dog->save();
        return redirect()->route('dog.index');
    }
}
