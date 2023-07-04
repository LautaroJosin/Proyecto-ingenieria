@extends('layouts.layout-master')

    @section('meta1')
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @endsection
    
    @section('title','Turnos')

    @section('content')

        <div class="text-pages">
            <x-mainMenu/>

            @if(session('cero credits'))
                <script> popUpMessageDelay('{{ session('cero credits') }}') </script>
            @endif

            <form class="mb-5 grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('appointment.filter') }}"
                method="GET" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-q grid-rows-1 gap-5 mr-20 text-2xl">
                    <label>Estado: </label>
                </div>

                <div class="grid grid-cols-q grid-rows-1 gap-5 w-5 text-black font-normal">
                    <select name="state">
                        <option value="">Todo</option>
                        @foreach (App\Enums\AppointmentStatesEnum::values() as $state)
                            <option value={{ $state }}> {{ $state }} </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="text-2xl border-2 border-solid border-white w-40 mt-1 hover:bg-sky-700">Filtrar
                </button>

            </form>

            @if($appointments->isEmpty())
                <h1>No hay turnos para mostrar</h1>
            @else
            <div>
            <table class="table-fixe border-separate border-spacing-6 border-2" >
                <thead>
                    <tr>
                    @role('admin')
                        <th>Dueño</th>
                        <th>Dni</th>
                    @endrole
                    <th>Nombre del perro</th>
                    <th>Motivo del turno</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Monto</th>
                    @role('admin')
                        <th>Acciones</th>
                    @endrole
                    </tr>
                </thead>
                @foreach ($appointments as $appointment)
                <tbody>
                <tr class="border-2">
                    @role('admin')
                        <td>{{ $appointment->dog->user->name }}</td>
                        <td>{{ $appointment->dog->user->dni }}</td>
                    @endrole
                    <td>{{ $appointment->dog->name }}</td>
                    <td>{{ $appointment->reason->reason }}</td>
                    <td>{{ $appointment->state->value }}</td>
                    <td>{{ $appointment->date->format('Y-m-d') }}</td>
                    <td>{{ $appointment->time->format('H:i') }}
                    <td>
                        @if( !$appointment->discountAlreadyApplied() ) {{ $appointment->reason->price }} <br>
                            @can('apply discount')
                            @if($appointment->state->value == App\Enums\AppointmentStatesEnum::CONFIRMED->value)
                                <form action="{{ route('user.appointment.discount', $appointment) }}" method="POST">
                                    @csrf
                                    <button type="submit">
                                        Aplicar descuento
                                    </button>
                                </form>
                            @endif
                            @endcan
                        
                        @else {{ $appointment->priceWithDiscount }}<br>
                        @role('user')<small>Usted ya aplico un descuento a este turno!</small>@endrole
                        @endif 

                        
                    </td>
                    <td>
                        @if($appointment->state->value == App\Enums\AppointmentStatesEnum::PENDING->value)
                            @can('delete appointment')
                                <form action="{{ route('admin.appointment.reject', $appointment) }}" method="GET">
                                    @csrf
                                    <button type="submit">
                                        Rechazar
                                    </button>
                                </form>
                            @endcan

                            @can('edit appointment')
                                <form action="{{ route('admin.appointment.confirm', $appointment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit">
                                        Confirmar
                                    </button>
                                </form>
                            @endcan
                        @endif
                            
                        @if($appointment->state->value == App\Enums\AppointmentStatesEnum::CONFIRMED->value)
                            @can('create treatment')
                                <a href="{{ route('treatment.create', $appointment) }}">
                                    <button>
                                        Actualizar libreta
                                    </button>
                                </a>
                            @endcan

                            @can('edit appointment')
                                <form id="appointment-cancelation-form{{ $appointment->id }}" action="{{ route('admin.appointment.cancel', $appointment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="event.preventDefault(); confirmationPopUp('¿Está seguro que desea cancelar el turno? ', 'appointment-cancelation-form{{ $appointment->id }}');">
                                        Cancelar
                                    </button>                            
                                </form>

                                <form id="appointment-missing-form{{ $appointment->id }}" action="{{ route('admin.appointment.missing', $appointment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="event.preventDefault(); confirmationPopUp('¿Está seguro que desea marcar el turno como perdido? ', 'appointment-missing-form{{ $appointment->id }}')">
                                        Turno perdido
                                    </button>
                                </form>
                            @endcan
                        @endif

                    </td>
                </tr>
                </tbody>
                @endforeach
            </div>
                <div>
                @endif
                @can('create appointment')
                    <a href="{{ route('user.appointment.create') }}">
                        <button class="border-2">
                            Solicitar turno
                        </button>
                    </a>
                @endcan
                </div>
            </table>
        </div>
    @endsection