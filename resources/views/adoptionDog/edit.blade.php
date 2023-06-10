
@extends('layouts.layout-master')
@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Editar perro en adopción')

@section('content')

    <x-mainMenu/>

    <div class="text-pages font-bold">
   
    <br>
    <br>

    <form class="grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('myadoption.update', [$dog_identifier, $dog]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

            <div class="grid grid-cols-q grid-rows-5 gap-5 mr-20 text-2xl">
                <label>Sexo:</label>
                <label>Raza</label>
                <label>Descripción</label>
				<label>Tamaño:</label>
                <label>Fecha de nacimiento</label>    
            </div>

            <div class="grid grid-cols-q grid-rows-5 gap-5 w-10 text-black font-normal">
			
            <select name="gender" required value"{{ $dog->gender }}">
                <option value="M">Macho</option>
                <option value="H">Hembra</option>
            </select>
        
            <input type="text" name="race" class="form-control" pattern="[A-Za-z ]+" required value="{{ $dog->race }}">
        

            <input type="text" name="description" class="form-control" required value="{{ $dog->description }}">
			
			
			<select name="size" class="form-control" required value="{{ $dog->size }}">
					<option value="P">Pequeño</option>
					<option value="M">Mediano</option>
					<option value="G">Grande</option>
			</select>
			

            <input type="date" name="date_of_birth" class="form-control" min="2000-01-01" max="{{  date('Y-m-d') }}" required value="{{ $dog->date_of_birth->format('Y-m-d') }}">

            

        </div>


        <button type="submit" class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700">Confirmar cambios</button>
    </form>
	
		 <div class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700"><a href="{{ route('adoption.userdogs') }}">Cancelar</a></div>
	
</div>
@endsection

