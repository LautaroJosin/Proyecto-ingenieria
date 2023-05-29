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
            </div>
        </tr>
        </thead>

        @foreach ($dogs as $dog)
        <tbody>
            <tr>
                <td class="w-36 text-center">{{ $dog->gender }}</td>
                <td class="w-36 text-center">{{ $dog->race }}</td>
                <td class="w-36 text-center">{{ $dog->size }}</td>
                <td class="w-36 text-center">{{ $dog->description }}</td>
                <td class="w-36 text-center">{{ $dog->ageForHumans() }}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
    @endif

    <br>
    <br>

</div>
@endsection