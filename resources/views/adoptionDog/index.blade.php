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
				<th class="text-2xl">Publicado por</th>
				<th class="text-2xl">Nombre temporal</th>
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
				<td class="w-36 text-center">{{ $dog->publisher() }}</td>
				<td class="w-36 text-center">{{ $dog->temp_name }}</td>
                <td class="w-36 text-center">{{ $dog->gender }}</td>
                <td class="w-36 text-center">{{ $dog->race }}</td>
                <td class="w-36 text-center">{{ $dog->showSize() }}</td>
                <td class="w-36 text-center">{{ $dog->description }}</td>
                <td class="w-36 text-center">{{ $dog->ageForHumans() }}</td>
				<td class="w-36 text-center">
				
					@can('delete adoption')
							<form id="destroy-adoption-dog-form" action="{{ route('adoption.destroy', $dog) }}" method="POST">
								@csrf
								@method('DELETE')
								<button type="submit" onclick="event.preventDefault(); confirmDeleteDog();">
									Eliminar
								</button>
							</form>
						@endcan
						
						@can('edit adoption')
							<a href="{{ route('adoption.edit', $dog) }}">
								<button>
									Modificar
								</button>
							</a>
						@endcan
						
						
						@can('confirm adoption')
						<form action="{{ route('adoption.confirm') }}" method="POST">
						@method('PUT')
						@csrf
								<button>
									Confirmar adopción
								</button>
						</form>
						@endcan
						
						
						@unlessrole('admin')
						{{-- NO deberia dejarme adoptar si es mi perro--}}
							<a href="{{ route('adoption.index') }}">
								<button>
									Adoptar
								</button>
							</a>
						@endunlessrole
				
				</td>
				
				
            </tr>
        </tbody>
        @endforeach
    </table>
    @endif

    <br>
    <br>
	
		@can('add adoption')
		<a class="text-2xl border-2 border-solid border-white w-40 mt-10 p-5 hover:bg-sky-700" href="{{ route('adoption.create') }}">
			<button>
				Agregar
			</button>
        </a>
		@endcan

</div>
@endsection