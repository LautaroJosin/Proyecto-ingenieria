@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Estadisticas servicio de adopción')

@section('content')

    <x-mainMenu />

    <div class="text-pages">

        {!! $chart->container() !!}

        <br>

        <br>

        <br>

        
       
    </div>


    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}

@endsection