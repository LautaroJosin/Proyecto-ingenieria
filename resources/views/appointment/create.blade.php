@extends('layouts.layout-master')

    @section('meta1')
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @endsection
    
    @section('title','Turnos')

    @section('content')
        
        <x-mainMenu/>

        <div class="text-pages">
            <form class="grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('user.appointment.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-q grid-rows-4 gap-5 mr-20 text-2xl">
                    <label>Perro:</label>
                    <label>Motivo:</label>
                    <label>Fecha:</label>
                    <label>Horario:</label>
                </div>
                
                <div class="grid grid-cols-q grid-rows-4 gap-5 w-10 text-black font-normal"">

                    <select name="id_dog" required value="{{ old('dog') }}">
                        @foreach ($dogs as $dog)
                            <option value={{ $dog->id }}> {{ $dog->name }} </option>
                        @endforeach
                    </select>

                    <select name="id_reason" required value="{{ old('reason') }}">
                        @foreach ($reasons as $reason)
                            <option value={{ $reason->id }}> {{ $reason->reason }}-> ${{ $reason->price }} </option>
                        @endforeach
                    </select>

                    <input type="date" name="date" min="{{  now()->addDays(1)->toDateString() }}" required value="{{ old('date') }}">
                    
                    <select name="time" id="horario-select">
                        <script>
                            // Obtener referencia al selector de tiempo
                            const horarioSelect = document.getElementById('horario-select');
                            
                            // Generar opciones de media hora desde las 08:00 hasta las 18:00
                            const horaInicio = new Date();
                            horaInicio.setHours(8, 0, 0);
                            
                            const horaFin = new Date();
                            horaFin.setHours(18, 0, 0);
                            
                            const intervaloMinutos = 30;
                            
                            while (horaInicio < horaFin) {
                                const option = document.createElement('option');
                                option.value = horaInicio.toTimeString().slice(0, 5);
                                option.text = horaInicio.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                                horarioSelect.appendChild(option);
                                horaInicio.setMinutes(horaInicio.getMinutes() + intervaloMinutos);
                            }
                        </script>
                      </select>
                    @if(session('error'))
                        <small class="text-danger text-red-600 font-bold text-xl"> {{ session('error') }} </small>
                    @endif
                </div>

                <button class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700" type="submit">
                    Confirmar
                </button>

            </form>
        </div>

    @endsection