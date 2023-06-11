@extends('layouts.layout-master')
@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Cargar negocio')

@section('content')

    <x-mainMenu />

    <div class="text-pages font-bold">

        <div>
            <h2 class="text-2xl mb-10">Cargar negocio</h2>
        </div>

        <br>
        <br>

        <form class="grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('caregiver.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-q grid-rows-4 gap-5 mr-20 text-2xl">
                <label>Nombre del negocio:</label>
                <label>Tipo de negocio:</label>
                <label>Zona de trabajo:</label>
                <label>Email</label>
            </div>

            <div class="grid grid-cols-q grid-rows-4 gap-5 w-10 text-black font-normal">

                <input type="text" name="name" pattern="[A-Za-z ]+" required value="{{ old('name') }}">

                <select name="type" required value="{{ old('type') }}">
                    <option value="">Seleccione un tipo</option>
                    <option value="C">Cuidador</option>
                    <option value="W">Paseador</option>
                    <option value="B">Paseador y cuidador</option>
                </select>

                <select name="id_park" required value="{{ old('id_park') }}">
                    <option value="">Seleccione una zona</option>
                    @foreach ($parks as $park)
                        <option value={{ $park->id }}> {{ $park->park_name }} </option>
                    @endforeach
                </select>

                <input type="email" name="email" required value="{{ old('email') }}">
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

            <button type="submit"
                class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700">Confirmar</button>
        </form>
    </div>
@endsection
