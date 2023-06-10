@extends('layouts.layout-master')

    @section('meta1')
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @endsection
    
    @section('title','Perros admin')

    @section('content')

        <div class="text-pages">
            <x-mainMenu/>

            @if($appointments->isEmpty())
                <h1>No hay turnos para mostrar</h1>
            @else
            <div>
            <table class="table-fixe border-separate border-spacing-6 border-2" >
                <thead>
                  <tr>
                    <th>Nombre del perro</th>
                    <th>Motivo del turno</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                    @role('admin')
                    <th>Acciones</th>
                    @endrole
                  </tr>
                </thead>
                @foreach ($appointments as $appointment)
                <tbody>
                    <tr class="border-2">
                    <td>{{ $appointment->dog->name }}</td>
                    <td>{{ $appointment->reason->reason }}</td>
                    <td>{{ $appointment->state->value }}</td>
                    <td>{{ $appointment->date->format('Y-m-d') }}</td>
                    <td>{{ $appointment->reason->price }}</td>
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
                                <form id="appointment-cancelation-form" action="{{ route('admin.appointment.cancel', $appointment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="event.preventDefault(); confirmationPopUp('¿Está seguro que desea cancelar el turno? ', 'appointment-cancelation-form');">
                                        Cancelar
                                    </button>                            
                                </form>

                                <form id="appointment-missing-form" action="{{ route('admin.appointment.missing', $appointment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="event.preventDefault(); confirmationPopUp('¿Está seguro que desea marcar el turno como perdido? ', 'appointment-missing-form')">
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
                        <button class="border-2 border">
                            Solicitar turno
                        </button>
                    </a>
                @endcan
                </div>
            </table>
        </div>
    @endsection