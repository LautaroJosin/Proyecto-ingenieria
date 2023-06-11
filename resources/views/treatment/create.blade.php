@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title','Turnos')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-900">
        <div class="w-1/3 bg-gray-800 bg-opacity-90 rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-center text-white mb-4">Ingreso de datos</h2>
        
            <form id="form-create-appointment" action="{{ route('treatment.store', $appointment) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="peso" class="block text-white text-sm font-semibold mb-2">Peso:</label>
                    <input type="number" min="0" max="1000" required name="weight" id="peso" placeholder="Ingrese el peso" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-600 text-white text-sm">
                </div>
                
                @if($appointment->reason->reason == 'Desparasitación')
                    <div class="mb-4">
                        <label for="cantidad_desparasitante" class="block text-white text-sm font-semibold mb-2">Cantidad de desparasitante utilizado:</label>
                        <input type="number" min="0" max="99999999" required name="amountOfDewormer" placeholder="Ingrese la cantidad de desparasitante" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-600 text-white text-sm">
                    </div>
                @endif
        
                <div class="flex justify-center">
                    <button id="button-create-appointment" type="submit" class="bg-blue-400 hover:bg-blue-500 text-white rounded-lg py-2 px-4 font-semibold uppercase tracking-wider transition duration-300 ease-in-out">
                        Confirmar
                        <script> buttonDisable("form-create-appointment", "button-create-appointment") </script>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection