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
                <a class="text-2xl border-2 border-solid border-white w-40 mt-1 hover:bg-sky-700" href="{{ route('donation-campaign.create') }}">
                    <button>
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
                                <td class="w-36 text-center">{{ "Implementación a futuro" }}</td>
                                <td class="w-36 text-center">
                                    <img src="{{ asset($campaign->photo) }}" alt="" width="100" height="100">
                                </td>
                                @role('admin')
                                    <td class="w-36">
                                        <button type="submit">
                                            Modificar
                                        </button>
                                    </td>
                                @else
                                    <td class="w-36">
                                        <button type="submit">
                                            Donar
                                        </button>
                                    </td>
                                @endrole
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            @endif
        </div>
    @endsection
