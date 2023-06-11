@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Rechazo de turno')

@section('content')

    <div class="text-pages font-bold">
        <x-mainMenu />

        <form class="grid grid-cols-20-80 grid-rows-1 justify-center"
            action="{{ route('admin.appointment.sendMail', $appointment) }}" method="POST">
            @csrf
            <div class="grid grid-cols-q grid-rows-1 gap-5 mr-20 text-2xl">
                <label>Motivo del rechazo:</label>
            </div>

            <div class="grid grid-cols-q grid-rows-1 gap-5 w-10 text-black font-normal">
                <input type="text" name="content" required>
            </div>

            <button class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700" type="submit">
                Enviar
            </button>

    </div>
    </form>
    </div>
@endsection
