@extends('layouts.layout-master')
@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Cargar perro')

@section('content')

    <x-mainMenu />

    <div class="text-pages font-bold">

        <div>
            <h2 class="text-2xl mb-10">Cargar perro</h2>
        </div>

        <br>
        <br>

        <form class="grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('lostDog.store', 'F') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-q grid-rows-7 gap-5 mr-20 text-2xl">
                <label>Nombre del perro:</label>
                <label>Genero:</label>
                <label>Raza:</label>
                <label>Descripción:</label>
                <label>Fecha de nacimiento aproximada:</label>
                <label>Encontrado en:</label>
                <label>Foto:</label>
            </div>

            <div class="grid grid-cols-q grid-rows-7 gap-5 w-10 text-black font-normal">

                <input type="text" name="name" pattern="[A-Za-z ]+" required value="{{ old('name') }}">

                <select name="gender" required value="{{ old('gender') }}">
                    <option value="">Seleccione un tipo</option>
                    <option value="M">Macho</option>
                    <option value="H">Hembra</option>
                </select>

                <input type="text" name="race" pattern="[A-Za-z ]+" required value="{{ old('race') }}">

                <input type="text" name="description" required value="{{ old('description') }}">

                <input type="date" name="date_of_birth" min="2000-01-01" max="{{  date('Y-m-d') }}" required value="{{ old('date_of_birth') }}">

                <input type="text" name="place" required value="{{ old('place') }}">

                <input type="file" name="photo" accept="image/*" required>

                @if ($errors->any())
                    <div class="text-danger text-red-600 font-bold text-xl">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <button type="submit" class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700">Confirmar
            </button>
        </form>
    </div>
@endsection
