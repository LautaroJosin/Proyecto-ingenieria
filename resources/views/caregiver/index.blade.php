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

    @if($caregivers->isEmpty())
        <h1>No hay paseadores/cuidadores para mostrar</h1>
    @else
    <div>
    <table class="table-auto">
        <thead>
          <tr>
            <th>Negocio</th>
            <th>Contacto</th>
            <th>Zona de trabajo</th>
            @can('edit caregiver')
            <th>Acciones</th>
            @endcan
          </tr>
        </thead>
        @foreach ($caregivers as $caregiver)
        <tbody>
            <tr>
            <td>{{ $caregiver->name }}</td>
            <td>{{ $caregiver->email }}</td>
            <td>{{ $caregiver->park->park_name }}</td>
            <td>
                
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

            </td>
        </tr>
        </tbody>
        @endforeach
    </div>
        <div>
        @endif
        @can('create caregiver')
            <a href="{{ route('caregiver.create') }}">
                <button class="border-2">
                    Cargar negocio
                </button>
            </a>
        @endcan
        </div>
    </table>
</body>
</html>