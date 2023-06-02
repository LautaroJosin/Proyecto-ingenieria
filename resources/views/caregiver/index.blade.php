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
        @can('create caregiver')
            <br> <br>
            <a class="text-2xl border-2 border-solid border-white w-40 mt-10 p-5 hover:bg-sky-700"
                href="{{ route('caregiver.create') }}">
                <button>
                    Cargar negocio
                </button>
            </a>
        @endcan
        </table>
    </div>
@endsection
