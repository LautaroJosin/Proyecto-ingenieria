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

        @if(session('error server conection'))
            <script> popUpMessageDelay('{{ session('error server conection') }}') </script>
        @endif

        @if(session('donation completed'))
            <script> popUpMessageDelay('{{ session('donation completed') }}') </script>
        @endif


        <div class="text-pages font-bold">
            @role('admin')
                <a class="p-5 text-2xl border-2 border-solid border-white w-40 mt-1 hover:bg-sky-700" href="{{ route('donation-campaign.create') }}">
                    <button class="mb-10">
                        Cargar campaña
                    </button>
                </a>
            @endrole

            {{-- Sección vacia --}}
            @if($campaigns->isEmpty())
                <h1>No hay campañas vigentes para mostrar</h1>
            @else
                {{-- Sección con contenido --}}
                <table class="table-fixe border-separate border-spacing-6 border-2">
                    <thead>
                        <tr>
                            <div class="w-36 text-center">
                                <th class="text-2xl">Nombre</th>
                                <th class="text-2xl">Descripcion</th>
                                <th class="text-2xl">Fecha de inicio</th>
                                <th class="text-2xl">Fecha de finalización</th>
                                <th class="text-2xl">Objetivo de recaudación</th>
                                <th class="text-2xl">Monto recaudado</th>
                                <th class="text-2xl">Foto</th>
                                <th class="text-2xl">Acciones</th>
                                <th class="text-2xl">Estado</th>
                            </div>
                        </tr>
                    </thead>

                    @foreach ($campaigns as $campaign)
                        <tbody>
                            <tr>
                                <td class="w-36 text-center">{{ $campaign->name }}</td>
                                <td class="w-36 text-center">{{ $campaign->description }}</td>
                                <td class="w-36 text-center">{{ $campaign->start_date }}</td>
                                <td class="w-36 text-center">{{ $campaign->end_date }}</td>
                                <td class="w-36 text-center">{{ $campaign->fundraising_goal }}</td>
                                <td class="w-36 text-center">{{ $campaign->current_fundraised }}</td>
                                <td class="w-36 text-center">
                                    <img src="{{ asset($campaign->photo) }}" alt="" width="100" height="100">
                                </td>
                                <td class="w-3"
                                <td class="w-36">
                                    @role('admin')
                                        <a href="{{ route('donation-campaign.edit', $campaign) }}">
                                            <button type="submit">
                                                Modificar
                                            </button>
                                        </a>
                                    @else
                                        <button type="submit" >
                                            <a href="{{ route('donation-campaign.donate', ['campaign_id' => $campaign->id]) }}"> Donar </a>
                                        </button>
                                    @endrole
                                </td>
                                <td class="w-36 text-center">{{ $campaign->state->value }}</td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            @endif
        </div>
    @endsection
