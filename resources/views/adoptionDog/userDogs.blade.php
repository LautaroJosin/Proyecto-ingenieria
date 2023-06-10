@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title','Mis Perros en adopción')

@section('content')

<x-mainMenu/>

<div class="text-pages">

	<div>

		<h1 class="text-4xl mb-6">Filtrado de perros</h1>

        <form class="mb-5 grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('adoption.filter') }}"
            method="GET" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="filter-form" value="from-userdogs">

           <div class="grid grid-cols-q grid-rows-6 gap-5 mr-20 text-2xl">
            	<label>Nombre temporal del perro:</label>
                <label>Sexo:</label>
                <label>Raza:</label>
                <label>Tamaño:</label>
                <label>Estado:</label>
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

    <br>
    <br>
    <br>
    <br>


		
	@if( $dogs->isEmpty() )

		{{-- Si no llegaron perros a la vista , se verifica si fue por el resultado de un filtrado o porque no hay perros en adopcion --}}

		@if( $filtered_result )
		
			<h1>No hay perros que coincidan con el criterio de filtrado</h1>

			<br>
	        <br>
	        <br>

			@can('add adoption')
			<a class="text-2xl border-2 border-solid border-white w-40 mt-40 p-5 hover:bg-sky-700" href="{{ route('adoption.create') }}">
				<button>
					Publicar adopción
				</button>
		    </a>
			@endcan

		@else

        	<h1>No tienes perros propios publicados</h1>

	        <br>
	        <br>
	        <br>

			@can('add adoption')
			<a class="text-2xl border-2 border-solid border-white w-40 mt-40 p-5 hover:bg-sky-700" href="{{ route('adoption.create') }}">
				<button>
					Publicar adopción
				</button>
		    </a>
			@endcan

		@endif

    @else
		
	<h1 class="text-4xl mb-6">Mis perros</h1>
	
	
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

        @foreach ($dogs as $my_dog)
        <tbody>
            <tr>
				<td class="w-36 text-center">{{ $my_dog->publisher() }}</td>
				<td class="w-36 text-center">{{ $my_dog->temp_name }}</td>
	            <td class="w-36 text-center">{{ $my_dog->gender }}</td>
	            <td class="w-36 text-center">{{ $my_dog->race }}</td>
	            <td class="w-36 text-center">{{ $my_dog->showSize() }}</td>
	            <td class="w-36 text-center">{{ $my_dog->description }}</td>
	            <td class="w-36 text-center">{{ $my_dog->ageForHumans() }}</td>
				<td class="w-36 text-center">{{ $my_dog->showState() }}</td>

				<td class="w-44 text-center">
					
					@if($my_dog->wasAdopted())
							No hay opciones disponibles
					@else

						@can('delete adoption')
							<form id="destroy-adoption-dog-form" action="{{ route('adoption.destroy', $my_dog) }}" method="POST">
								@csrf
								@method('DELETE')
								<button type="submit" onclick="event.preventDefault(); confirmDeleteAdoptionDog();">
									Eliminar
								</button>
							</form>
						@endcan
						
						@can('edit adoption')
							<a href="{{ route('adoption.edit', $my_dog) }}">
								<button>
									Modificar
								</button>
							</a>
						@endcan
						
						@if( $my_dog->wasRequested() )
							@can('confirm adoption')
							<form action="{{ route('adoption.confirm' , $my_dog->temp_name) }}" method="POST">
							@method('PUT')
							@csrf
									<button>
										Confirmar adopción
									</button>
							</form>
							@endcan
						@endif

					@endif
						
				</td>
            </tr>
        </tbody>
        @endforeach

    </table>

    <br>
    <br>
    <br>

    @can('add adoption')
	<a class="text-2xl border-2 border-solid border-white w-40 mt-40 p-5 hover:bg-sky-700" href="{{ route('adoption.create') }}">
		<button>
			Publicar adopción
		</button>
    </a>
	@endcan


    @endif

@endsection
