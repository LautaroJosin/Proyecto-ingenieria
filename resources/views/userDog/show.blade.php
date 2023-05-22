<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table class="table-auto">
        Libreta sanitaria del perro: {{ $dog->name }}
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Razón</th>
            <th>Peso</th>
            <th>Vacuna</th>
            <th>Desparasitante</th>
          </tr>
        </thead>
        @foreach ($dog->treatments as $treatment)
        <tbody>
            <td>{{ $treatment->date_of_appointment }}</td>
            <td>{{ $treatment->reason }}</td>
            <td>{{ $treatment->weight }} Kg</td>
            <td>{{ $treatment->vaccine }}</td>
            <td>{{ $treatment->dewormer }} mg</td>
        </tbody>
        @endforeach
    </table>
</body>
</html>