@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Cargar perro de adopción')

@section('content')

<x-mainMenu/>

<div class="text-pages font-bold">

    <h2 class="text-2xl mb-10">Este es el formulario para publicar un perro en adopción</h2>


    <form class="grid grid-cols-20-80 grid-rows-1 justify-center" method="POST" action="{{ route('adoption.store') }}">
        @csrf
    
        <div class="grid grid-cols-q grid-rows-7 gap-5 mr-20 text-2xl">
            <label>Sexo:</label>
            <label>Raza:</label>
            <label>Descripción:</label>
            <label>Tamaño:</label>
            <label>Fecha de nacimiento:</label>
        </div>

        <div class="grid grid-cols-q grid-rows-7 gap-5 w-10 text-black font-normal">
		
            <select name="gender" required value="{{ old('gender') }}">
                    <option value="">Seleccione un sexo</option>
                    <option value="M">Macho</option>
                    <option value="H">Hembra</option>
            </select>

            <input type="text" name="race" pattern="[A-Za-z ]+" required value="{{ old('race') }}">

            <input type="text" name="description" required value="{{ old('description') }}">

            <select name="size" required value="{{ old('size') }}">
                    <option value="">Seleccione un tamaño</option>
                    <option value="P">Pequeño</option>
                    <option value="M">Mediano</option>
                    <option value="G">Grande</option>
            </select>

            <input  type="date" name="date_of_birth" min="2000-01-01" max="{{  date('Y-m-d') }}" required value="{{ old('date_of_birth') }}">

        </div>

        <button class="text-2xl border-2 border-solid border-white w-40 hover:bg-sky-700" type="submit">Confirmar</button>


    </form>

</div>


@endsection

