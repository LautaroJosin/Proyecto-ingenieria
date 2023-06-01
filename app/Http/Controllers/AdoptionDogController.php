<?php

namespace App\Http\Controllers;


use App\Models\AdoptionDog;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class AdoptionDogController extends Controller
{
    /**
     * Display a listing of the resource. The view receive all the dogs if there is not an authenticated user 
		and receive all the dogs and the dogs from the user if it is authenticated
     */
    public function index()
    {
		if( Auth::check()) {
			
			$dogs = AdoptionDog::all();
			
			$my_dogs = AdoptionDog::where('user_id', Auth::user()->id)->get();
						
			$filtered_dogs = $dogs->diff($my_dogs);
						

			/* Le envio a la vista los perros del usuario y ademas todo el resto de perros excepto los que pertenecen al usuario (que ya fueron mostrados)*/
			return view('adoptionDog.index')
				->with('my_dogs', $my_dogs)
				->with('dogs', $filtered_dogs);
		}
		else { 
			$dogs = AdoptionDog::all();
			return view('adoptionDog.index')->with('dogs', AdoptionDog::all());
		}
		
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

		
        $request->validate([
            'temp_name' => 'required|unique:App\Models\AdoptionDog,temp_name' ,
			'gender' => 'required',
			'race' => 'required',
			'size' => 'required',
			'date_of_birth' => 'required',
			'description' => 'required',
		]);
		
				
        $dog->user_id = auth()->user()->id;
        $this->setDog($request, $dog)->save();
		
        return redirect()->route('adoption.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdoptionDog $adoption)
    {
		
         return view('adoptionDog.edit')->with(['dog' => $adoption, 'dog_identifier' => $adoption->temp_name]);
    }

    /**
     * Update the specified resource in storage.
	 
		NO SE COMO HICE PERO FUNCIONA (No termino de entender el orden en que se reciben los parametros xd)
		
		Revisar la vista adoptionDog.edit
	 
     */
    public function update(Request $request, AdoptionDog $dog , $dog_identifier)
    {	
		
		AdoptionDog::where('temp_name', $dog_identifier)->first()
			->update(['gender' =>  $request->input('gender') ,
							'race' =>  $request->input('race') ,
							'description' =>  $request->input('description') ,
							'size' =>  $request->input('size') ,
							'date_of_birth' =>  $request->input('date_of_birth') ,
							]);
							
        return redirect()->route('adoption.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdoptionDog $adoption)
    {
		$adoption->delete();
        return redirect()->route('adoption.index');
    }
	
	
	/**
     *  
     */
    public function confirmAdoption( )
    {
		
    }
	

	 private function setDog(Request $request, AdoptionDog $dog): AdoptionDog
    {
		$dog->temp_name = $request->input('temp_name');
        $dog->gender = $request->input('gender');
        $dog->race = $request->input('race');
        $dog->description = $request->input('description');
		$dog->size = $request->input('size');
        $dog->date_of_birth = $request->input('date_of_birth');
				
        return $dog;
    }
}
