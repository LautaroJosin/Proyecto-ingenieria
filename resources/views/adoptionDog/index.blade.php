@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title','Perros en adopción')

@section('content')

<x-mainMenu/>

<div class="text-pages">

    @if($dogs->isEmpty())
        <h1>No hay perros para mostrar</h1>
    @else
    <table class="table-fixed border-2 ">
        <thead>
        <tr>
            <div class="w-36 text-center">
                <th class="text-2xl">Sexo</th>
                <th class="text-2xl">Raza</th>
				<th class="text-2xl">Tamaño</th>
                <th class="text-2xl">Descripcion</th>
                <th class="text-2xl">Edad</th>
				<th class="text-2xl">Acciones</th>
            </div>
        </tr>
        </thead>

        @foreach ($dogs as $dog)
        <tbody>
            <tr>
                <td class="w-36 text-center">{{ $dog->gender }}</td>
                <td class="w-36 text-center">{{ $dog->race }}</td>
                <td class="w-36 text-center">{{ $dog->showSize() }}</td>
                <td class="w-36 text-center">{{ $dog->description }}</td>
                <td class="w-36 text-center">{{ $dog->ageForHumans() }}</td>
				<td class="w-36 text-center">
				
					@can('delete adoption dog')
							<form id="destroy-adoption-dog-form" action="{{ route('adoption.destroy', $dog) }}" method="POST">
								@csrf
								@method('DELETE')
								<button type="submit" onclick="event.preventDefault(); confirmDeleteDog();">
									Eliminar
								</button>
							</form>
						@endcan
						
						@can('edit adoption dog')
							<a href="{{ route('adoption.edit', $dog) }}">
								<button>
									Modificar
								</button>
							</a>
						@endcan
						
						@can('confirm adoption dog')
							<a href="{{ route('adoption.index') }}">
								<button>
									Confirmar adopción
								</button>
							</a>
						@endcan
						
						@guest
							<a href="{{ route('adoption.index') }}">
								<button>
									Adoptar
								</button>
							</a>
						@endguest
				
				</td>
				
				
            </tr>
        </tbody>
        @endforeach
    </table>
    @endif

    <br>
    <br>
	
	
	<a class="text-2xl border-2 border-solid border-white w-40 mt-10 p-5 hover:bg-sky-700" href="{{ route('adoption.create') }}">
            <button>
                Agregar
            </button>
        </a>

</div>
@endsection