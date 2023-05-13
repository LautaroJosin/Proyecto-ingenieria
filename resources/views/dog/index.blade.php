<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <!-- Deberíamos instalar tailwind, la clase table-auto pertenece a esa herramienta -->
    <table class="table-auto">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Sexo</th>
            <th>Raza</th>
            <th>Descripcion</th>
            <th>Fecha de nacimiento</th>
            <th>Foto</th>
            <th>Acciones</th>
          </tr>
        </thead>
        @foreach ($dogs as $dog)
        <tbody>
            <td>{{ $dog->name }}</td>
            <td>{{ $dog->gender }}</td>
            <td>{{ $dog->race }}</td>
            <td>{{ $dog->description }}</td>
            <td>{{ $dog->date_of_birth }}</td>
            <td>{{ $dog->photo }}</td>
            <td>
            <form action="{{ route('dog.destroy', $dog) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Eliminar</button>
            </form>

            <a href={{ route('dog.edit', $dog) }}>
                <button>Modificar</button>
            </a>
        <br>
            <a href={{ route('dog.show', $dog) }}>
                <button>Ver libreta sanitaria</button>
            </a>

            </td>
        </tbody>
        @endforeach
    </table>

</body>
</html>
