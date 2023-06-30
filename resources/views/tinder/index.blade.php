@extends('layouts.layout-master')

    @section('meta1')
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @endsection
    
    @section('title','Perros admin')

    @section('content')

    <x-mainMenu/>

    <div class="text-pages">

        {{-- Sección vacia --}}
        @if($dogs->isEmpty())
            <h1>No hay recomendaciones para mostrar</h1>
        @else

        {{-- Sección con contenido --}}
        
        <table class="table-fixed border-2 ">
            <thead>
            <tr>
                <div class="w-36 text-center">
                    <th class="text-2xl">Nombre</th>
                    <th class="text-2xl">Sexo</th>
                    <th class="text-2xl">Raza</th>
                    <th class="text-2xl">Descripcion</th>
                    <th class="text-2xl">Edad</th>
                    <th class="text-2xl">Foto</th>
                    <th class="text-2xl">Mail del dueño</th>
                </div>
            </tr>
            </thead>

            @foreach ($dogs as $dog)
            <tbody>
                <tr>
                <td class="w-36 text-center">{{ $dog->name }}</td>
                <td class="w-36 text-center">{{ $dog->gender }}</td>
                <td class="w-36 text-center">{{ $dog->race }}</td>
                <td class="w-36 text-center">{{ $dog->description }}</td>
                <td class="w-36 text-center">{{ $dog->ageForHumans() }}</td>
                <td class="w-36 text-center">
                <img src="{{ asset($dog->photo) }}" alt="" width="100" height="100">
                </td>
                <td class="w-36 text-center">{{ $dog->user->email }}</td>
            </tr>
            </tbody>
            @endforeach

        </table>
        @endif
    </div>
    @endsection
