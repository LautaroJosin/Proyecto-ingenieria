<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    En esta vista estaran los perros del usuario
    @foreach ($dogs as $dog)
        <h1>Perro:</h1>
        <p>Nombre: {{ $dog->name }}</p>
        <p>Sexo: {{ $dog->gender }}</p>
        <p>Raza: {{ $dog->race }}</p>
        <p>Descripción: {{ $dog->description }}</p>
        <p>Fecha de nacimiento: {{ $dog->date_of_birth }}</p>
        <p>Foto: {{ $dog->photo }}</p>
        <form method="POST" action="{{ route('dog.destroy', $dog->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>
    @endforeach
</body>
</html>
