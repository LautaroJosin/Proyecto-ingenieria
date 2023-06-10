<?php

namespace App\Http\Controllers;


use App\Models\AdoptionDog;
use App\Models\User;
use App\Models\AdoptionRequested;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;


class AdoptionDogController extends Controller
{


    /**
     * Display a listing of the resource. The view receive all the dogs except the ones from the user if he is registered.	
     */
    public function index()
    {

    	$dogs = AdoptionDog::all();

		if( Auth::check()) {
			
			$user_dogs = AdoptionDog::where('user_id', Auth::user()->id)->get();
				
			$filtered_dogs = $dogs->diff($user_dogs);
						
			/* Le envio a la vista todos perros excepto los que pertenecen al usuario */
			return view('adoptionDog.index')
				->with('dogs', $filtered_dogs)
				->with('filtered_result' , false);
		}
		else return view('adoptionDog.index')
				->with('dogs', $dogs)
				->with('filtered_result' , false);
		
    }




    /* Retorna la cartelera de perros en adopcion de un usuario autenticado con sus perros */

    public function userDogs() {

    	$user_dogs = AdoptionDog::where('user_id', Auth::user()->id)->get();

		return view('adoptionDog.userDogs')
			->with('dogs', $user_dogs)
			->with('filtered_result' , false);
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
            'temp_name' => 'required' ,
			'gender' => 'required',
			'race' => 'required',
			'size' => 'required',
			'date_of_birth' => 'required',
			'description' => 'required',
		]);

		if(AdoptionDog::where('user_id', Auth::user()->id)
				->where('temp_name', $request->temp_name)->exists())

			return redirect()->route('adoption.userdogs')
				->with('error_adding_new_adoption' , 'Ya tienes un perro publicado con ese nombre!');

		else {
			$dog->user_id = auth()->user()->id;
			$dog->state = 'S';
        	$this->setDog($request, $dog)->save();
		
        	return redirect()->route('adoption.userdogs');
		}
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
							
		
        return redirect()->route('adoption.userdogs');
    }






    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdoptionDog $adoption)
    {
		$adoption->delete();
		
        return redirect()->route('adoption.userdogs');
    }




	
	/*
     *  Confirma una adopcion, cambia el estado del perro y te redirige a la vista index
     */
    public function confirmAdoption($dog_identifier)
    {
		$dog = AdoptionDog::where('temp_name', $dog_identifier)->first();
		$dog->update(['state' => 'A']);
		
		return redirect()->route('adoption.userdogs');
    }





	
	/**
	*		Recibe la peticion para adoptar de un usuario no autenticado. En el request se recibe :
	*			- id del usuario que publico el perro
	*			- nombre del perro que se quiere adoptar
	*			- email ingresado por el usuario no autenticado
	*/
	public function guestAdoption(Request $request) 
	{

		$dog_owner = User::where('id', $request->owner_id)->first();

		$result = AdoptionRequested::where('user_email', $request->email)
        		->where('dog_requested', AdoptionDog::where('temp_name', $request->dog_name)->first()->id)
        		->exists();

        /* Si el guest utiliza un mail no registrado, se realiza el pedido de adopcion */
        if(! $result) {
		
			$this->sendMail($dog_owner , $request->dog_name, $request->email);

			$aux = new AdoptionRequested;

				$aux->user_email = $request->email;
				
				$aux->dog_requested = AdoptionDog::where('temp_name', $request->dog_name)->first()->id;

			$aux->save();

			
			return redirect()->route('adoption.index');
		}

		else return redirect()->route('adoption.index')
			->with('error_dog_already_requested', 'Usted ya solicito este perro!');
			
		
	}





	
	/**
	*		Recibe la peticion para adoptar de un usuario autenticado. Se reciben como parametros :
	*			- id del usuario que publico el perro
	*			- nombre del perro que se quiere adoptar
	*/
	public function authAdoption(int $owner_id , string $dog_name) 
	{
		
		$dog_owner = User::where('id', $owner_id)->first();

		$this->sendMail($dog_owner , $dog_name, Auth::user()->email);

		/* Se almacena que el usuario Auth::user solicito al perro $dog_name */

		$request = new AdoptionRequested;

		$request->user_id = Auth::user()->id;

			$dog = AdoptionDog::where('temp_name', $dog_name)->first();

		$request->dog_requested = $dog->id;

		$request->save();
		
		return redirect()->route('adoption.index');
	}





	
	/* Envia un mail a dog_ownner informando que un usuario quiere adoptar uno de sus perros*/

	public function sendMail(User $dog_owner,  $dog_name , $user_email) 
	{    
        Mail::raw('El usuario con el mail ' . $user_email . ' desea adoptar a ' . $dog_name , function ($message) use ($dog_owner)  
		{
            $message->from('OhMyDog@gmail.com')->subject('Solicitud de adopción');
			$message ->to($dog_owner->email);
        });
		
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





	
	
	/* Recibe un formulario de filtrado, filtra las adopciones y redirige a la vista correspondiente
	   con los perros filtrados  */

	public function filter(Request $request)
    {

        $query = AdoptionDog::query();


        if ($request->filled('state')) $query->where('state', $request->input('state'));

        if ($request->filled('name')) $query->where('temp_name', $request->input('name'));

        if ($request->filled('gender')) $query->where('gender', $request->input('gender'));

        if ($request->filled('size')) $query->where('size', $request->input('size'));

        if ($request->filled('race')) $query->where('race', $request->input('race'));

        if ($request->filled('date_of_birth')) $query->where('date_of_birth', $request->input('date_of_birth'));

        /* No creo poder hacer la consulta por nombre de usuario que publico, puede traer quilombo xd.
       	   Que sucederia si hay mas de un usuario con el mismo nombre? Traeria los perros de solo uno de ellos
       	   ya que en el filtrado pregunto por el id del usuario con el nombre ingresado */
        /*
        if ($request->filled('dog_owner')) 
        		$query->where('user_id', User::where('id' , $request->input('dog_owner'))->name->first());
		*/

        
        /* Debo comprobar de qué vista viene el formulario del filtrado */

        if($request->input('filter-form') == 'from-index') {

        	if(Auth::check()) {

        		$filtered_dogs = $query->whereNotIn('user_id', [Auth::user()->id]);

        		return view('adoptionDog.index')
        			->with('dogs', $filtered_dogs->get())
        			->with('filtered_result' , true);
        	}

        	else
        		return view('adoptionDog.index')
        			->with('dogs', $query->get())
        			->with('filtered_result' , true);

        }

        else if ($request->input('filter-form') == 'from-userdogs') {

        	$filtered_dogs = $query->where('user_id', [Auth::user()->id]);
        	return view('adoptionDog.userDogs')
        		->with('dogs', $filtered_dogs->get())
        		->with('filtered_result' , true);
        }
        
        
    }
	
}