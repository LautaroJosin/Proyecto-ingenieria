@extends('layouts.layout-master')

    @section('meta1')
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @endsection

    @section('title','Libreta sanitaria')
   
    @section('content')

    <div class="text-pages">

      <h2 class="text-2xl mb-10">Libreta sanitaria del perro: {{ $dog->name }} </h2>

      
        <table class="table-fixed border-2 ">
            <thead>
              <tr>
                <div class="w-36 text-center">
                  <th class="text-2xl">Fecha</th>
                  <th class="text-2xl">Razón</th>
                  <th class="text-2xl">Peso</th>
                  {{--<th class="text-2xl">Vacuna</th>--}}
                  <th class="text-2xl">Desparasitante</th>
                </div>
              </tr>
            </thead>
            @foreach ($dog->treatments as $treatment)
            <tbody>
                <td class="w-36 text-center">{{ $treatment->date_of_appointment }}</td>
                <td class="w-36 text-center">{{ $treatment->reason }}</td>
                <td class="w-36 text-center">{{ $treatment->weight }} Kg</td>
                {{--<td class="w-36 text-center">{{ $treatment->vaccine }}</td>--}}
                <td class="w-36 text-center">{{ $treatment->dewormer }}</td>
            </tbody>
            @endforeach
        </table>
    </div>

@endsection