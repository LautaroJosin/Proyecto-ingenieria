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
  <div class="flex items-center justify-center min-h-screen bg-gray-900">
    <div class="w-1/3 bg-gray-800 bg-opacity-90 rounded-lg shadow-lg p-6">
      <h2 class="text-2xl font-semibold text-center text-white mb-4">Ingreso de datos</h2>
  
      <form action="{{ route('treatment.store', $appointment) }}" method="POST">
        @csrf
  
        <div class="mb-4">
          <label for="peso" class="block text-white text-sm font-semibold mb-2">Peso:</label>
          <input type="number" min="0" max="99999999" required name="weight" id="peso" placeholder="Ingrese el peso" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-600 text-white text-sm">
        </div>
        
        @if($appointment->reason->reason == 'Desparasitación')
        <div class="mb-4">
          <label for="cantidad_desparasitante" class="block text-white text-sm font-semibold mb-2">Cantidad de desparasitante utilizado:</label>
          <input type="number" min="0" max="99999999" required name="amountOfDewormer" placeholder="Ingrese la cantidad de desparasitante" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-600 text-white text-sm">
        </div>
        @endif
  
        <div class="flex justify-center">
          <button type="submit" class="bg-blue-400 hover:bg-blue-500 text-white rounded-lg py-2 px-4 font-semibold uppercase tracking-wider transition duration-300 ease-in-out">Confirmar</button>
        </div>
      </form>
    </div>
  </div>
  

</body>
</html>