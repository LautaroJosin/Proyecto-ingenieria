@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Estadisticas servicio de adopción')

@section('content')

    <x-mainMenu />

    <div class="text-pages text-center mt-30">

    <h1 class="text-2xl">Seleccione el tipo de estadistica que desea observar</h1>

    <br>
    <br>
    <br>

    <a class="emb-2" href="{{ route('statistics.index1') }}">
        <button type="submit">
            Ver estadisticas del servicio de adopción
        </button>
    </a>

    <br>
    <br>
    <br>

    <a class="mb-2" href="{{ route('statistics.index2') }}">
        <button type="submit">
            Ver estadisticas del servicio de turnos
        </button>
    </a>

    <br>
    <br>
    <br>

    <a class="mb-2" href="{{ route('statistics.index3') }}">
        <button type="submit">
            Ver estadisticas del servicio de perdida y busqueda
        </button>
    </a>
       
    </div>

@endsection