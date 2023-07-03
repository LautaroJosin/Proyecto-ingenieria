@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title', 'Perros encontrados')

@section('content')

    <x-mainMenu />


    <div class="text-pages">

        <form class="mb-5 grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('lostDog.filterFound') }}"
            method="GET" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-q grid-rows-6 gap-5 mr-20 text-2xl">
                <label>Nombre del perro:</label>
                <label>Genero:</label>
                <label>Raza:</label>
                <label>Descripción:</label>
                {{--<label>Edad minima:</label>--}}
                <label>Zona de pérdida:</label>
                <label>Estado:</label>
            </div>

            <div class="grid grid-cols-q grid-rows-6 gap-5 w-10 text-black font-normal">

                <input type="text" name="name" pattern="[A-Za-z ]+">

                <select name="gender">
                    <option value=""></option>
                    <option value="M">Macho</option>
                    <option value="H">Hembra</option>
                </select>

                <input type="text" name="race" pattern="[A-Za-z ]+">

                <input type="text" name="description">

                {{--<input type="number" name="age" min="0" max="100">--}}

                <input type="text" name="place">

                <select name="reunited">
                    <option value=""></option>
                    <option value="1">Reunidos</option>
                    <option value="0">Perdidos</option>
                </select>
            </div>

            <button type="submit" class="text-2xl border-2 border-solid border-white w-40 mt-1 hover:bg-sky-700">Filtrar
            </button>
        </form>

        @if (Auth::check())
            <div>
                <button class="text-2xl border-2 border-solid border-white w-40 mt-1 hover:bg-sky-700"><a
                        href="{{ route('lostDog.myFoundDogsIndex') }}">Mis perros encontrados</a>
                </button>
            </div>
        @endif

        <br>
        {{-- Sección vacia --}}
        @if ($lostDogs->isEmpty())
            <h1 class="text-4xl mb-6">No hay perros para mostrar</h1>
        @else
            {{-- Sección con contenido --}}

            <table class="table-fixed border-2 border-separate border-spacing-10">
                <thead>
                    <tr>
                        <div class="w-36 text-center">
                            <th class="text-2xl">Usuario</th>
                            <th class="text-2xl">Nombre del perro</th>
                            <th class="text-2xl">Genero</th>
                            <th class="text-2xl">Raza</th>
                            <th class="text-2xl">Descripción</th>
                            <th class="text-2xl">Edad</label>
                            <th class="text-2xl">Encontrado en</th>
                            <th class="text-2xl">Estado</th>
                            <th class="text-2xl">Foto</th>
                            @can('manage lost dog')
                                <th class="text-2xl">Acciones</th>
                            @endcan
                        </div>
                    </tr>
                </thead>
                @foreach ($lostDogs as $lostDog)
                    <tbody>
                        <tr>
                            <td class="w-36 text-center">{{ $lostDog->user->name }} {{ $lostDog->user->surname }}</td>
                            
                            <td class="w-36 text-center">{{ $lostDog->name }}</td>
                            
                            <td class="w-36 text-center">
                                @if ($lostDog->gender == 'M')
                                    Macho
                                @else
                                    Hembra
                                @endif
                            </td>
                            
                            <td class="w-36 text-center">{{ $lostDog->race }}</td>
                           
                            <td class="w-36 text-center">{{ $lostDog->description }}</td>
                            
                            <td class="w-36 text-center">{{ $lostDog->ageForHumans() }}</td>
                            
                            <td class="w-36 text-center">{{ $lostDog->place }}</td>
                            
                            <td class="w-36 text-center">
                                @if ($lostDog->reunited)
                                    Reunido con su dueño
                                @else
                                    buscando a su dueño
                                @endif
                            </td>

                            <td class="w-36 text-center"><img src="{{ asset($lostDog->photo) }}" alt="" width="100" height="100"></td>

                            <td class="w-36">
                                @can('manage lost dog')
                                    @if (!$lostDog->reunited)
                                        @if (!$lostDog->wasRequestedBy(Auth::user()->id))
                                            <form action="{{ route('lostDog.found', $lostDog) }}" method="POST">
                                                @csrf
                                                <button type="submit">
                                                    Es mi perro
                                                </button>
                                            </form>
                                        @else
                                            Solicitud ya enviada
                                        @endif
                                    @else
                                        ¡Este perro ya está con su dueño!
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        @endif
    </div>
@endsection
