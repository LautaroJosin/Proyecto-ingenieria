<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    <table class="table-auto">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Sexo</th>
            <th>Raza</th>
            <th>Descripcion</th>
            <th>Edad</th>
            <th>Foto</th>
            <th>Acciones</th>
          </tr>
        </thead>
        @foreach ($dogs as $dog)
        <tbody>
            <tr>
            <td>{{ $dog->name }}</td>
            <td>{{ $dog->gender }}</td>
            <td>{{ $dog->race }}</td>
            <td>{{ $dog->description }}</td>
            <td>{{ $dog->ageForHumans() }}</td>
            <td>
            <img src="{{ asset($dog->photo) }}" alt="" width="100" height="100">
            </td>
            <td>
                @can('delete dog')
                <form action="{{ route('dog.destroy', $dog) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        Eliminar
                    </button>
                </form>
                @endcan
=======
@extends('layouts.layout-master')

    @section('meta1')
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @endsection
    
    @section('title','Perros admin')

    @section('content')

    <x-mainMenu/>


    <div class="text-pages">

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
                    <th class="text-2xl">Acciones</th>
                </div>
            </tr>
            </thead>
>>>>>>> origin/vistas

            @foreach ($dogs as $dog)
            <tbody>
                <tr>
                <td class="w-36 text-center">{{ $dog->name }}</td>
                <td class="w-36 text-center">{{ $dog->gender }}</td>
                <td class="w-36 text-center">{{ $dog->race }}</td>
                <td class="w-36 text-center">{{ $dog->description }}</td>
                <td class="w-36 text-center">{{ $dog->date_of_birth }}</td>
                <td class="w-36 text-center">
                <img src="{{ asset($dog->photo) }}" alt="" width="100" height="100">
                </td>
                <td class="w-36">
                    @can('delete dog')
                    <form id="destroy-dog-form" action="{{ route('dog.destroy', $dog) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="event.preventDefault(); confirmDeleteDog();">
                            Eliminar
                        </button>
                    </form>
                    @endcan

                    @can('edit dog')
                    <a href="{{ route('dog.edit', $dog) }}">
                        <button>
                            Modificar
                        </button>
                    </a>
                    @endcan

                    <a href="{{ route('treatment.show', $dog) }}">
                        <button>
                            Ver libreta sanitaria
                        </button>
                    </a>
                </td>
            </tr>
            </tbody>
            @endforeach

        </table>

        <br>
        <br>
        <a class="text-2xl border-2 border-solid border-white w-40 mt-10 p-5 hover:bg-sky-700" href="{{ route('dog.create') }}">
            <button>
                Agregar
            </button>
        </a>

    </div>
    @endsection
