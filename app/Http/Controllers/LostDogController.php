<?php

namespace App\Http\Controllers;

use App\Models\LostDog;
use App\Models\LostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LostDogController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage lost dog')->only('create', 'edit', 'destroy', 'found', 'reunited');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lostDogs = LostDog::where('type', 'L')->get();

        if (Auth::check()) {
            $lostDogs = $lostDogs->filter(function ($dog) {
                return $dog->user_id != auth()->user()->id;
            });
        }
        return view('lostDog.index')->with('lostDogs', $lostDogs);
    }

    /**
     * Display a listing of the resource.
     */
    public function foundIndex()
    {
        $lostDogs = LostDog::where('type', 'F')->get();

        if (Auth::check()) {
            $lostDogs = $lostDogs->filter(function ($dog) {
                return $dog->user_id != auth()->user()->id;
            });
        }
        return view('lostDog.foundIndex')->with('lostDogs', $lostDogs);
    }

    /**
     * Display a listing of the resource.
     */
    public function myLostDogsIndex()
    {
        $lostDogs = LostDog::where('user_id', auth()->user()->id)->get();
        $lostDogs = $lostDogs->filter(function ($dog) {
            return $dog->type == 'L';
        });

        return view('lostDog.myDogsIndex')->with('lostDogs', $lostDogs)->with('type', 'L');
    }

    /**
     * Display a listing of the resource.
     */
    public function myFoundDogsIndex()
    {
        $lostDogs = LostDog::where('user_id', auth()->user()->id)->get();
        $lostDogs = $lostDogs->filter(function ($dog) {
            return $dog->type == 'F';
        });

        return view('lostDog.myDogsIndex')->with('lostDogs', $lostDogs)->with('type', 'F');
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
    public function store(Request $request, $type)
    {
        $lostDog = new LostDog;

        $lostDog->user_id = auth()->user()->id;
        $lostDog->type = $type;

        $tempDog = LostDog::where('user_id', Auth::user()->id)->where('name', $request->input('name'))->orderBy('id', 'desc')->first();

        if($tempDog && !$tempDog->reunited) return redirect()->back()->withErrors('Ya tienes un perro publicado con ese nombre');

        $this->setLostDog($request, $lostDog)->save();

        if ($lostDog->type == 'L') return redirect()->route('lostDog.myLostDogsIndex');
        else return redirect()->route('lostDog.myFoundDogsIndex');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LostDog $lostDog)
    {
        return view('lostDog.edit')->with('lostDog', $lostDog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LostDog $lostDog)
    {
        if(LostDog::where('user_id', Auth::user()->id)->where('name', $request->input('name'))->whereNotIn('name', [$lostDog->name])->exists()) return redirect()->back()->withErrors('Ya tienes un perro publicado con ese nombre');
        
        $this->setLostDog($request, $lostDog)->save();
        
        if ($lostDog->type == 'L') return redirect()->route('lostDog.myLostDogsIndex');
        else return redirect()->route('lostDog.myFoundDogsIndex');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LostDog $lostDog)
    {
        $dogType = $lostDog->type;

        $lostDog->delete();

        if ($dogType == 'L') return redirect()->route('lostDog.myLostDogsIndex');
        else return redirect()->route('lostDog.myFoundDogsIndex');
    }

    /**
     * To show than a user has found a dog.
     */
    public function found(LostDog $lostDog)
    {
        $request = new LostRequest();
        $request->user_id = auth()->user()->id;
        $request->dog_requested = $lostDog->id;
        $request->save();

        $lostDog->found = true;
        $lostDog->save();

        if ($lostDog->type == 'L') $this->sendMailLost($lostDog->user->email, $lostDog->name, auth()->user()->email);
        else $this->sendMailFound(auth()->user()->email, $lostDog->name, $lostDog->user->email);

        if ($lostDog->type == 'L') return redirect()->route('lostDog.index');
        else return redirect()->route('lostDog.foundIndex');
    }

    /**
     * To show that a dog is reunited with its owner.
     */
    public function reunited(LostDog $lostDog)
    {
        $lostDog->reunited = true;
        $lostDog->save();

        if ($lostDog->type == 'L') return redirect()->route('lostDog.myLostDogsIndex');
        else return redirect()->route('lostDog.myFoundDogsIndex');
    }

    /**
     * Send an email to the dog owner.
     */
    private function sendMailLost($dog_owner_email,  $dog_name , $user_email) 
	{    
        Mail::raw('El usuario con el mail ' . $user_email . ' dice haber encontrado a ' . $dog_name , function ($message) use ($dog_owner_email)  
		{
            $message->from('OhMyDog@gmail.com')->subject('Posible perro encontrado');
			$message ->to($dog_owner_email);
        });	
	}

    /**
     * Send an email from the dog owner.
     */
    private function sendMailFound($dog_owner_email,  $dog_name , $user_email) 
	{    
        Mail::raw('El usuario con el mail ' . $dog_owner_email . ' dice ser el dueño de ' . $dog_name , function ($message) use ($user_email)  
		{
            $message->from('OhMyDog@gmail.com')->subject('Posible dueño del perro encontrado');
			$message ->to($user_email);
        });	
	}

    public function filterLost(Request $request) {
        $query = LostDog::query()->where('type', 'L');
        if (Auth::check()) $query->where('user_id', '!=', auth()->user()->id);
        
        $filteredDogs = $this->filter($query, $request);
    
        return view('lostDog.index')->with('lostDogs', $filteredDogs);
    }
    
    public function filterFound(Request $request) {
        $query = LostDog::query()->where('type', 'F');
        if (Auth::check()) $query->where('user_id', '!=', auth()->user()->id);
        
        $filteredDogs = $this->filter($query, $request);
        
        return view('lostDog.foundIndex')->with('lostDogs', $filteredDogs);
    }
    
    public function filterMyDogs($type, Request $request) {
        $query = LostDog::query()->where('type', $type);
        $query->where('user_id', '=', auth()->user()->id);
        
        $filteredDogs = $this->filter($query, $request);

        return view('lostDog.myDogsIndex')->with('lostDogs', $filteredDogs)->with('type', $type);
    }
    
    /**
     * Filter the specified resource from storage.
     */
    public function filter($query, Request $request) {
        if ($request->filled('name')) $query->where('name' , 'like' , '%' . $request->input('name') . '%');
        if ($request->filled('gender')) $query->where('gender' , 'like' , '%' . $request->input('gender') . '%');
        if ($request->filled('race')) $query->where('race' , 'like' , '%' . $request->input('race') . '%');
        if ($request->filled('description')) $query->where('description' , 'like' , '%' . $request->input('description') . '%');
        if ($request->filled('place')) $query->where('place' , 'like' , '%' . $request->input('place') . '%');
        if ($request->filled('reunited')) $query->where('reunited' , '=' , $request->input('reunited'));
        /*if ($request->filled('age')) {
            $age = $request->input('age');
            $birthDate = now()->subYears($age)->format('Y-m-d');
            $query->whereDate('date_of_birth', '<=', $birthDate);
        }
        */
        return $query->get();
    }

    private function setLostDog(Request $request, LostDog $lostDog): LostDog
    {
        $lostDog->name = $request->input('name');
        $lostDog->gender = $request->input('gender');
        $lostDog->race = $request->input('race');
        $lostDog->description = $request->input('description');
        $lostDog->date_of_birth = $request->input('date_of_birth');
        $lostDog->place = $request->input('place');

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'required|image',
            ]);
            $url = $request->file('photo')->store('public/lostDogs');
            $lostDog->photo = Storage::url($url);
        }
         
        return $lostDog;
    }
}
