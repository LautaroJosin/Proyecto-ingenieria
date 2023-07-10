@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Estadisticas servicio de adopción')

@section('content')

    <x-mainMenu />

    <div class="text-pages">

        @if(!empty($msj))
            <h1 class="text-2xl text-center">{{$msj}}</h1>
        @else
            {!! $chart->container() !!}


            <script src="{{ $chart->cdn() }}"></script>

            {{ $chart->script() }}

        @endif
       
    </div>


    

@endsection