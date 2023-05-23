
@extends('layouts.layout-master')
@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Editar perro')

@section('content')

    <x-mainMenu/>

    <div class="text-pages font-bold">


    <div>
        <h2 class="text-2xl mb-10">Editar Perro</h2>

        @if($dog->photo)
            <img src="{{ $dog->photo }}">
        @endif
    </div>

    <br>
    <br>

    <form class="grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('dog.update', $dog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

            <div class="grid grid-cols-q grid-rows-6 gap-5 mr-20 text-2xl">
                <label>Nombre</label>
                <label>Sexo:</label>
                <label>Raza</label>
                <label>Descripción</label>
                <label>Fecha de nacimiento</label>
                <label>Foto</label>            
            </div>

            <div class="grid grid-cols-q grid-rows-6 gap-5 w-10 text-black font-normal"">

            <input type="text" name="name" class="form-control" pattern="[A-Za-z ]+" required value="{{ $dog->name }}">

            <select name="gender" required value"{{ $dog->gender }}">
                <option value="M">Macho</option>
                <option value="H">Hembra</option>
            </select>
        
            <input type="text" name="race" class="form-control" pattern="[A-Za-z ]+" required value="{{ $dog->race }}">
        

            <input type="text" name="description" class="form-control" required value="{{ $dog->description }}">
        

            <input type="date" name="date_of_birth" class="form-control" min="2000-01-01" max="{{  date('Y-m-d') }}" required value="{{ $dog->date_of_birth->format('Y-m-d') }}">

            
            <input type="file" name="photo" accept="image/*" class="form-control">
            @error('photo')
                <small class="text-danger"> {{$message}} </small>
            @enderror

        </div>


        <button type="submit" class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700">Confirmar cambios</button>
    </form>
</div>
@endsection
