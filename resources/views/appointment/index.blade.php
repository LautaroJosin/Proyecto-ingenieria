<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>

    <x-mainMenu/>

    @if($appointments->isEmpty())
        <h1>No hay turnos para mostrar</h1>
    @else
    <div>
    <table class="table-auto">
        <thead>
          <tr>
            <th>Nombre del perro</th>
            <th>Motivo del turno</th>
            <th>Estado</th>
            <th>Fecha</th>
            @role('admin')
            <th>Acciones</th>
            @endrole
          </tr>
        </thead>
        @foreach ($appointments as $appointment)
        <tbody>
            <tr>
            <td>{{ $appointment->dog->name }}</td>
            <td>{{ $appointment->reason->reason }}</td>
            <td>{{ $appointment->state }}</td>
            <td>{{ $appointment->date->format('Y-m-d') }}</td>
            <td>

                @if($appointment->state == 'P')
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
                
                @can('create treatment')
                    @if($appointment->state == 'C')
                        <a href="{{ route('treatment.create', $appointment) }}">
                            <button>
                                Actualizar libreta
                            </button>
                        </a>
                    @endif
                @endcan

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
</body>
</html>