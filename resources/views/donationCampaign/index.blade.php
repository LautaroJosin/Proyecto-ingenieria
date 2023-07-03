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
            
            <form class="mb-5 grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('donation-campaign.filter') }}" method="GET" enctype="multipart/form-data">
            @csrf
                <div class="grid grid-cols-q grid-rows-5 gap-5 mr-20 text-2xl">
                    <label>Nombre de Campaña:</label>
                    <label>Código de campaña:</label>
                    <label>Descripción:</label>
                    <label>Fecha de ocurrencia:</label>
                    <label>Estado</label>
                </div>

                <div class="grid grid-cols-q grid-rows-5 gap-5 w-10 text-black font-normal">

                    <input type="text" name="name" pattern="[A-Za-z ]+">

                    <input type="number" min="1" max="99999999" name="id">

                    <input type="text" name="description">

                    <input type="date" name="date">

                    <select name="state">
                        <option value=""></option>
                        @foreach (App\Enums\DonationCampaignStatesEnum::values() as $state)
                            <option value={{ $state }}> {{ $state }} </option>
                        @endforeach
                    </select>

                </div>

                <button type="submit" class="text-2xl border-2 border-solid border-white w-40 mt-1 hover:bg-sky-700">
                    Filtrar
                </button>
            </form>
            
            <br> <br>

            @role('admin')
                <a class="p-5 text-2xl border-2 border-solid border-white w-40 mt-1 hover:bg-sky-700" href="{{ route('donation-campaign.create') }}">
                    <button class="mb-10">
                        Cargar campaña
                    </button>
                </a>
            @endrole

            {{-- Sección vacia --}}
            @if($campaigns->isEmpty())
                <h1>No hay campañas para mostrar</h1>
            @else
                {{-- Sección con contenido --}}
                <table class="table-fixe border-separate border-spacing-6 border-2">
                    <thead>
                        <tr>
                            <div class="w-36 text-center">
                                <th class="text-2xl">Nombre</th>
                                <th class="text-2xl">Código de campaña</th>
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
                                <td class="w-36 text-center">{{ $campaign->id }}</td>
                                <td class="w-36 text-center">{{ $campaign->description }}</td>
                                <td class="w-36 text-center">{{ $campaign->start_date }}</td>
                                <td class="w-36 text-center">{{ $campaign->end_date }}</td>
                                <td class="w-36 text-center">{{ $campaign->fundraising_goal }}</td>
                                <td class="w-36 text-center">{{ $campaign->current_fundraised }}</td>
                                <td class="w-36 text-center">
                                    <img src="{{ asset($campaign->photo) }}" alt="" width="100" height="100">
                                </td>
                                <td class="w-36">
                                    @if($campaign->state->value == App\Enums\DonationCampaignStatesEnum::ACTIVE->value)
                                        @role('admin')
                                            <a href="{{ route('donation-campaign.edit', $campaign) }}">
                                                <button type="submit">
                                                    Modificar
                                                </button>
                                            </a>

                                            <form id="finish-form{{ $campaign->id }}" action="{{ route('donation-campaign.finish', $campaign) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" onclick="event.preventDefault(); confirmationPopUp('¿Está seguro de finalizar la campaña?', 'finish-form{{ $campaign->id }}')">
                                                    Finalizar campaña
                                                </button>
                                            </form>
                                        @else
                                            <button type="submit" >
                                                <a href="{{ route('donation-campaign.donate', ['campaign_id' => $campaign->id]) }}"> Donar </a>
                                            </button>
                                        @endrole
                                    @endif
                                </td>
                                <td class="w-36 text-center">{{ $campaign->state->value }}</td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            @endif
        </div>
    @endsection
