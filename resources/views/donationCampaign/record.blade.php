@extends('layouts.layout-master')

    @section('meta1')
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @endsection
    
    @section('title','Historial de donaciones a campañas de donación')

    @section('content')

    <x-mainMenu/>


    <div class="text-pages font-bold">

    <h1>Historial de donaciones a campaña</h1>

    <br>
    <br>
    <br>

    @if(empty($records)) Esta vacio!

    @else

    <table class="table-fixe border-separate border-spacing-6 border-2">
        <thead>
            <tr>
                <div class="w-36 text-center">
                    <th class="text-2xl">Usuario</th>
                    <th class="text-2xl">Fecha de donación</th>
                    <th class="text-2xl">Horario de donación</th>
                    <th class="text-2xl">Monto donado</th>
                </div>
            </tr>
        </thead>

        @foreach ($records as $record)
            <tbody>
                <tr>
                    @if($record->was_registered)
                        <td class="w-36 text-center">{{ $users->where('id',$record->user_id)->first()->email }}</td>
                    @else
                        <td class="w-36 text-center">Anonimo</td>
                    @endif
                    <td class="w-36 text-center">{{ $record->donation_date }}</td>
                    <td class="w-36 text-center">{{ $record->donation_time }}</td>
                    <td class="w-36 text-center">{{ $record->amount }}</td>
                </tr>
            </tbody>
        @endforeach
    </table>

    @endif

    </div>


    @endsection