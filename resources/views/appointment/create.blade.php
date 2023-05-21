<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('appointment.store') }}" method="POST">
        @csrf

        <label>Perro:</label>
        <select name="id_dog" required value="{{ old('dog') }}">
            @foreach ($dogs as $dog)
                <option value={{ $dog->id }}> {{ $dog->name }} </option>
            @endforeach
        </select>

        <label>Motivo del turno:</label>
        <select name="id_reason" required value="{{ old('reason') }}">
            @foreach ($reasons as $reason)
                <option value={{ $reason->id }}> {{ $reason->reason }}-> ${{ $reason->price }} </option>
            @endforeach
        </select>

        <label>Fecha del turno:</label>
        <input type="date" name="date" min="{{  date('Y-m-d') }}" required value="{{ old('date') }}">

        <button type="submit">Confirmar</button>
    </form>
</body>
</html>