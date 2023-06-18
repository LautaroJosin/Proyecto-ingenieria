<?php

namespace App\Http\Controllers;

use App\Models\LostDog;
use Illuminate\Http\Request;
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

    /**
     * To show than a user has found a dog.
     */
    public function found(LostDog $dog)
    {
        if ($dog->type == 'L') $this->sendMailLost($dog->user->email, $dog->name, auth()->user()->email);
        else $this->sendMailFound(auth()->user()->email, $dog->name, $dog->user->email);

        $dog->found = true;
        $dog->save();

        if ($dog->type == 'L') return redirect()->route('lostDog.index');
        else return redirect()->route('lostDog.foundIndex');
    }

    /**
     * To show that a dog is reunited with its owner.
     */
    public function reunited(LostDog $dog)
    {
        $dog->reunited = true;
        $dog->save();

        if ($dog->type == 'L') return redirect()->route('lostDog.index');
        else return redirect()->route('lostDog.foundIndex');
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
        return view('lostDog.index')->with('dogs', $this->filter($request)->get());
    }

    public function filterFound(Request $request) {
        return view('lostDog.foundIndex')->with('dogs', $this->filter($request)->get());
    }

    /**
     * Filter the specified resource from storage.
     */
    private function filter(Request $request) {
        $query = LostDog::query();

        if ($request->filled('name')) $query->where('name' , 'like' , '%' . $request->input('name') . '%');
        if ($request->filled('gender')) $query->where('gender' , 'like' , '%' . $request->input('gender') . '%');
        if ($request->filled('race')) $query->where('race' , 'like' , '%' . $request->input('race') . '%');
        if ($request->filled('description')) $query->where('description' , 'like' , '%' . $request->input('description') . '%');
        if ($request->filled('place')) $query->where('place' , 'like' , '%' . $request->input('place') . '%');
        if ($request->filled('reunited')) $query->where('reunited' , '=' , $request->input('reunited'));
        //Acá tendría que filtrar por edad, pero no sé cómo hacerlo. Porque comparar la fecha de nacimiento es una cagada

        return $query;
    }

    private function setLostDog(Request $request, LostDog $dog): LostDog
    {
        $dog->name = $request->input('name');
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
