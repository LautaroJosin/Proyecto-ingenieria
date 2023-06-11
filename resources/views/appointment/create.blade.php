@extends('layouts.layout-master')

    @section('meta1')
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @endsection
    
    @section('title','Turnos')

    @section('content')
        
        <x-mainMenu/>

        <div class="text-pages">
            <form class="grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('user.appointment.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-q grid-rows-3 gap-5 mr-20 text-2xl">
                    <label>Perro:</label>
                    <label>Motivo:</label>
                    <label>Fecha:</label>
                </div>
                
                <div class="grid grid-cols-q grid-rows-3 gap-5 w-10 text-black font-normal"">

                    <select name="id_dog" required value="{{ old('dog') }}">
                        @foreach ($dogs as $dog)
                            <option value={{ $dog->id }}> {{ $dog->name }} </option>
                        @endforeach
                    </select>

                    <select name="id_reason" required value="{{ old('reason') }}">
                        @foreach ($reasons as $reason)
                            <option value={{ $reason->id }}> {{ $reason->reason }}-> ${{ $reason->price }} </option>
                        @endforeach
                    </select>

                    <input type="date" name="date" min="{{  now()->addDays(1)->toDateString() }}" required value="{{ old('date') }}">
                    @if(session('error'))
                        <small class="text-danger text-red-600 font-bold text-xl"> {{ session('error') }} </small>
                    @endif
                </div>

                <button class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700" type="submit">
                    Confirmar
                </button>


            </form>
        </div>

    @endsection