@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Cruza')

@section('content')

    <x-mainMenu />

    <div class="text-pages">

        <form action="{{ route('adoption.index') }}" method="GET" enctype="multipart/form-data">
            @csrf
            <h1 class="text-2xl mb-6"> Antes de cruzar a su perro, le recomendamos encarecidamente que considere la adopción.
                <br>
                En el mundo hay unos 500 millones de perros sin hogar, y te invitamos a que puedas brindarle cobijo a uno de
                ellos.
            </h1>
            <button type="submit" class="text-2xl border-2 border-solid border-white w-40 mt-1 hover:bg-sky-700">Ir a adopción
            </button>
        </form>

        <br><br>

        <form class="mb-5 grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('tinder.filter') }}"
            method="GET" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-q grid-rows-1 gap-5 mr-20 text-2xl">
                <label> Perro:</label>
            </div>

            <div class="grid grid-cols-q grid-rows-1 gap-5 w-10 text-black font-normal">

                <select name="dog_id">
                    <option value=""></option>
                    @foreach ($myDogs as $dog)
                        <option value="{{ $dog->id }}">{{ $dog->name }}</option>
                    @endforeach
                </select>

            </div>

            <button type="submit"
                class="text-2xl border-2 border-solid border-white w-40 mt-1 hover:bg-sky-700">Filtrar</button>
        </form>

        <br>

        {{-- Sección vacia --}}
        @if ($dogs->isEmpty())
            <h1 class="text-4xl mb-6">No hay recomendaciones para mostrar</h1>
        @else
            {{-- Sección con contenido --}}

            <h1 class="text-4xl mb-6">Perros recomendados:</h1>

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
