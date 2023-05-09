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
    <form action="{{ route('dog.store') }}" method="POST">
        @csrf

        <label>Nombre:</label>
        <input type="text" name="name" required>

        <label>Sexo:</label>
        <select name="gender" required>
            <option value="">Seleccione un sexo</option>
            <option value="M">Macho</option>
            <option value="H">Hembra</option>
        </select>

        <label>Raza:</label>
        <input type="text" name="race" required>

        <label>Descripción:</label>
        <input type="text" name="description" required>

        <label>Fecha de nacimiento:</label>
        <input type="date" name="date_of_birth" required>

        <label>Foto:</label>
        <input type="text" name="photo" required>

        <button type="submit">Confirmar</button>
    </form>
</body>
</html>
