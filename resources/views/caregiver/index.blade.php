@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Negocios')

@section('content')

    <x-mainMenu />


    <div class="text-pages">

        {{-- Sección vacia --}}
        @if ($caregivers->isEmpty())
            <h1>No hay negocios para mostrar</h1>
        @else
            {{-- Sección con contenido --}}

            <form class="mb-5 grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('caregiver.filter') }}"
                method="GET" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-q grid-rows-4 gap-5 mr-20 text-2xl">
                    <label>Nombre del negocio:</label>
                    {{-- <label>Tipo de negocio:</label> --}}
                    <label>Zona de trabajo:</label>
                    <label>Email</label>
                    <label>Estado</label>
                </div>

                <div class="grid grid-cols-q grid-rows-4 gap-5 w-10 text-black font-normal" >

                    <input type="text" name="name" pattern="[A-Za-z ]+">

                    <select name="id_park">
                        <option value=""></option>
                        @foreach ($parks as $park)
                            <option value={{ $park->id }}> {{ $park->park_name }} </option>
                        @endforeach

                    <input type="email" name="email">

                    <select name="is_active">
                        <option value=""></option>
                        <option value="1">Disponible</option>
                        <option value="0">No disponible</option>
                    </select>
                </div>

                <button type="submit"
                    class="text-2xl border-2 border-solid border-white w-40 mt-1 hover:bg-sky-700">Filtrar</button>
            </form>


            <table class="table-fixed border-2 ">
                <thead>
                    <tr>
                        <div class="w-36 text-center">
                            <th class="text-2xl">Negocio</th>
                            <th class="text-2xl">Contacto</th>
                            <th class="text-2xl">Zona de trabajo</th>
                            <th class="text-2xl">Estado</th>
                            @can('edit caregiver')
                                <th class="text-2xl">Acciones</th>
                            @endcan
                        </div>
                    </tr>
                </thead>
                @foreach ($caregivers as $caregiver)
                    <tbody>
                        <tr>
                            <td class="w-36 text-center">{{ $caregiver->name }}</td>
                            <td class="w-36 text-center">{{ $caregiver->email }}</td>
                            <td class="w-36 text-center">{{ $caregiver->park->park_name }}</td>
                            <td class="w-36 text-center">
                                @if ($caregiver->is_active)
                                    Disponible
                                @else
                                    No disponible
                                @endif
                            <td class="w-36">
                                @can('edit caregiver')
                                    <a href="{{ route('caregiver.edit', $caregiver) }}">
                                        <button>
                                            Modificar
                                        </button>
                                    </a>
                                @endcan

                                @can('delete caregiver')
                                    <form action="{{ route('caregiver.destroy', $caregiver) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            Eliminar
                                        </button>
                                    </form>
                                @endcan

                                @can('edit caregiver')
                                    @if (!$caregiver->is_active)
                                        <form action="{{ route('caregiver.enable', $caregiver) }}" method="POST">
                                            @csrf
                                            <button type="submit">
                                                Habilitar
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('caregiver.disable', $caregiver) }}" method="POST">
                                            @csrf
                                            <button type="submit">
                                                Deshabilitar
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    </tbody>
                @endforeach
        @endif
        </table>
        @can('create caregiver')
            <br> <br>
            <a class="text-2xl border-2 border-solid border-white w-40 mt-10 p-5 hover:bg-sky-700"
                href="{{ route('caregiver.create') }}">
                <button>
                    Cargar negocio
                </button>
            </a>
        @endcan
    </div>
@endsection
