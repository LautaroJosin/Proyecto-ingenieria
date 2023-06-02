<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('admin.appointment.sendMail', $appointment) }}" method="POST">
        @csrf
        <label>Contenido del mail:</label>
            <input type="text" name="content" required value="{{ old('reason') }}">
        
            <button type="submit">Confirmar</button>
    </form>
</body>
</html>