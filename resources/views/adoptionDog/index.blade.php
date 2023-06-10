@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title','Perros en adopción')

@section('content')

<x-mainMenu/>

<div class="text-pages">

	<div>

		<h1 class="text-4xl mb-6">Filtrado de perros</h1>

        <form class="mb-5 grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('adoption.filter') }}"
            method="GET" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="filter-form" value="from-index">

            <div class="grid grid-cols-q grid-rows-6 gap-5 mr-20 text-2xl">
            	<label>Nombre temporal del perro:</label>
                <label>Sexo:</label>
                <label>Raza:</label>
                <label>Tamaño:</label>
                <label>Estado:</label>
                <label>Fecha de nacimiento:</label>
            </div>

            <div class="grid grid-cols-q grid-rows-6 gap-5 w-10 text-black font-normal">

            	<input type="text" name="name" pattern="[A-Za-z ]+"  value="{{ old('name') }}">	

                <select name="gender" value="{{ old('gender') }}">
                    <option value="">Seleccione un sexo</option>
                    <option value="M">Macho</option>
                    <option value="H">Hembra</option>
            	</select>

            	<input type="text" name="race" pattern="[A-Za-z ]+"  value="{{ old('race') }}">

            	<select name="size" value="{{ old('size') }}">
                    <option value="">Seleccione un tamaño</option>
                    <option value="P">Pequeño</option>
                    <option value="M">Mediano</option>
                    <option value="G">Grande</option>
            	</select>

            	
            	<select name="state" value="{{ old('state') }}">
                    <option value="">Seleccione una opción</option>
                    <option value="A">Adoptado</option>
                    <option value="S">Sin adoptar</option>
            	</select>
            	
            </div>

            <button type="submit"
             class="text-2xl border-2 border-solid border-white w-40 mt-10 hover:bg-sky-700">Filtrar</button>

        </form>

    <div>

	{{-- ======================================================================================= --}}
		
	<br>
	<br>
	<br>


	@if( $dogs->isEmpty() )

        {{-- Si no llegaron perros a la vista , se verifica si fue por el resultado de un filtrado o porque no hay perros en adopcion --}}

        @if( $filtered_result )
        
            <h1>No hay perros que coincidan con el criterio de filtrado</h1>

        @else

            <h1>No hay perros para mostrar</h1>

        @endif

    @else
	
	
	<h1 class="text-4xl mb-6">Perros en adopción</h1>
	
    <table class="table-fixed border-2 border-separate border-spacing-6">
        <thead>
        <tr>
            <div class="w-36 text-center">
				<th class="text-2xl">Publicado por</th>
				<th class="text-2xl">Nombre temporal</th>
                <th class="text-2xl">Sexo</th>
                <th class="text-2xl">Raza</th>
				<th class="text-2xl">Tamaño</th>
                <th class="text-2xl">Descripcion</th>
                <th class="text-2xl">Edad</th>
				<th class="text-2xl">Estado</th>
				<th class="text-2xl">Acciones</th>
            </div>
        </tr>
        </thead>

        @foreach ($dogs as $dog)
        <tbody>
            <tr>
				<td class="w-36 text-center">{{ $dog->publisher() }}</td>
				<td class="w-36 text-center">{{ $dog->temp_name }}</td>
                <td class="w-36 text-center">{{ $dog->gender }}</td>
                <td class="w-36 text-center">{{ $dog->race }}</td>
                <td class="w-36 text-center">{{ $dog->showSize() }}</td>
                <td class="w-36 text-center">{{ $dog->description }}</td>
                <td class="w-36 text-center">{{ $dog->ageForHumans() }}</td>
				<td class="w-36 text-center">{{ $dog->showState() }}</td>
				<td class="w-44 text-center">				
						
						@if($dog->wasAdopted())

							No hay opciones disponibles

						@else
								
							@if(!Auth::check())
								<form id="adopt_dog_form" action="{{ route('adoption.adoptNotAuthenticated') }}" method="POST">
							
										@csrf
										<input type='hidden' name='owner_id' id='dato1'>
										<input type='hidden' name='dog_name' id='dato2' >
										<input type='hidden' name='email' id='dato3'>
										
										<button onclick="event.preventDefault(); sendEmail( '{{$dog->user_id}}' , '{{$dog->temp_name}}' ); ">
											Adoptar
										</button>
										
								</form>
									
							@else 
									
								@if(  $dog->wasRequestedBy(Auth::user()->id) )
									Perro ya solicitado
								@else
							
									<form action="{{ route('adoption.adoptAuthenticated', [$dog->user_id , $dog->temp_name]) }}" method="POST">
										@csrf
										<button>
											Adoptar
										</button>
									</form>

								@endif
									
							@endif
							
					@endif

				</td>
				
            </tr>
        </tbody>

        @endforeach

    </table>

    @endif
	
    <br>
    <br>

</div>

@endsection