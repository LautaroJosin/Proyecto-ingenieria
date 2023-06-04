@extends('layouts.layout-master')
@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Editar negocio')

@section('content')

    <x-mainMenu/>

    <div class="text-pages font-bold">

    <div>
        <h2 class="text-2xl mb-10">Editar negocio</h2>
    </div>

    <br>
    <br>

    <form class="grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('caregiver.update', $caregiver) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

            <div class="grid grid-cols-q grid-rows-3 gap-5 mr-20 text-2xl">
                <label>Nombre del negocio:</label>
                <label>Zona de trabajo:</label>
                <label>Email</label>           
            </div>

            <div class="grid grid-cols-q grid-rows-3 gap-5 w-10 text-black font-normal"">

            <input type="text" name="name" pattern="[A-Za-z ]+" required value="{{ $caregiver->name }}">

            <select name="id_park" required value="{{ $caregiver->park->id }}">
                @foreach ($parks as $park)
                    <option value={{ $park->id }}> {{ $park->park_name }} </option>
                @endforeach

                <input type="email" name="email" required value="{{ $caregiver->email }}">
        </div>


        <button type="submit" class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700">Confirmar cambios</button>
    </form>
</div>
@endsection
