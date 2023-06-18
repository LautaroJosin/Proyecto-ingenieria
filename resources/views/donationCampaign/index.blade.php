@extends('layouts.layout-master')

    @section('meta1')
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @endsection
    
    @section('title','Campañas de donación')

    @section('content')

    <x-mainMenu/>

    @if(session('success campaign register'))
        <script> popUpMessageDelay('{{ session('success campaign register') }}') </script>
    @endif


    <div class="text-pages font-bold">
        @role('admin')
            <a class="text-2xl border-2 border-solid border-white w-40 mt-10 p-5 hover:bg-sky-700" href="{{ route('donation-campaign.create') }}">
                <button>
                    Cargar campaña
                </button>
            </a>
        @endrole
    </div>
    @endsection
