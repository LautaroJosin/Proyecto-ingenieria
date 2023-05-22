<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    En esta vista van a estar los formularios para crear un perro
    <form action="{{ route('dog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>DNI del Dueño:</label>
        <input type="number" name="dni" min="0" max="99999999" required value="{{ old('dni') }}">
        @error('dni')
            <small class="text-danger"> {{$message}} </small>
        @enderror

        <label>Nombre:</label>
        <input type="text" name="name" pattern="[A-Za-z ]+" required value="{{ old('name') }}">

        <label>Sexo:</label>
        <select name="gender" required value="{{ old('gender') }}">
            <option value="">Seleccione un sexo</option>
            <option value="M">Macho</option>
            <option value="H">Hembra</option>
        </select>

        <label>Raza:</label>
        <input type="text" name="race" pattern="[A-Za-z ]+" required value="{{ old('race') }}">

        <label>Descripción:</label>
        <input type="text" name="description" required value="{{ old('description') }}">

        <label>Fecha de nacimiento:</label>
        <input type="date" name="date_of_birth" min="2000-01-01" max="{{  date('Y-m-d') }}" required value="{{ old('date_of_birth') }}">

        <label>Foto:</label>
        <input type="file" name="photo" accept="image/*" required>
        @error('photo')
            <small class="text-danger"> {{$message}} </small>
        @enderror

        <button type="submit">Confirmar</button>
    </form>
</body>
</html>
