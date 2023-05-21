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
    <div>
    <table class="table-auto">
        <thead>
          <tr>
            <th>Motivo del turno</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        @foreach ($appointments as $appointment)
        <tbody>
            <tr>
            <td>{{ $appointment->reason->reason }}</td>
            <td>{{ $appointment->state }}</td>
            <td>{{ $appointment->date }}</td>
            <td>
                @can('delete appointment')
                <form action="{{ route('appointment.destroy', $appointment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        Rechazar
                    </button>
                </form>
                @endcan

                @can('edit appointment')
                <a href={{ route('appointment.edit', $appointment) }}>
                    <button>
                        Confirmar
                    </button>
                </a>
                @endcan
            </td>
        </tr>
        </tbody>
        @endforeach
    </div>
        <div>
        @can('create appointment')
            <a href={{ route('appointment.create') }}>
                <button>
                    Solicitar turno
                </button>
            </a>
        @endcan
        </div>
    </table>
</body>
</html>