<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Próximo Tratamiento</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="max-w-xl mx-auto p-8 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Próximo Tratamiento</h2>
        
        <p class="mb-4">Estimado/a,</p>

        <p class="mb-4">Le informamos que el próximo tratamiento está programado para el día {{ $nextTreatmentDate->toDateString(); }}.</p>

        <p class="mb-4">Por favor, asegúrese de estar disponible para llevar a cabo el tratamiento en la fecha mencionada.</p>

        <p class="mb-4">¡Gracias y que tenga un buen día!</p>

        <p class="mb-1">Atentamente,</p>
        <p>Tu aplicación de Tratamientos</p>
    </div>
</body>
</html>