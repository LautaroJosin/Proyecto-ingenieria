<?php

namespace App\Http\Controllers;

use App\Models\LostDog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LostLostDogController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage lost dog')->only('create', 'edit', 'destroy');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lostDogs = LostDog::where('type', 'L')->get();
        return view('lostDog.index')->with('dogs', $lostDogs);
    }

    /**
     * Display a listing of the resource.
     */
    public function foundIndex()
    {
        $foundDogs = LostDog::where('type', 'F')->get();
        return view('lostDog.foundIndex')->with('dogs', $foundDogs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lostDog.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function foundCreate()
    {
        return view('lostDog.foundCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dog = new LostDog;

        $dog->user_id = auth()->user()->id;

        $this->setLostDog($request, $dog)->save();

        if ($dog->type == 'L') return redirect()->route('lostDog.index');
        else return redirect()->route('lostDog.foundIndex');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LostDog $dog)
    {
        return view('lostDog.edit')->with('dog', $dog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LostDog $dog)
    {
        $this->setLostDog($request, $dog)->save();
        
        if ($dog->type == 'L') return redirect()->route('lostDog.index');
        else return redirect()->route('lostDog.foundIndex');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LostDog $dog)
    {
        $type = $dog->type;

        $dog->delete();

        if ($type == 'L') return redirect()->route('lostDog.index');
        else return redirect()->route('lostDog.foundIndex');
    }

    private function setLostDog(Request $request, LostDog $dog): LostDog
    {
        $dog->type = $request->input('type');
        $dog->gender = $request->input('gender');
        $dog->race = $request->input('race');
        $dog->description = $request->input('description');
        $dog->date_of_birth = $request->input('date_of_birth');
        $dog->place = $request->input('place');
        
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image',
            ]);
            $url = $request->file('photo')->store('public/lostDogs');
            $dog->photo = Storage::url($url);
        }
        
        return $dog;
    }
}
