@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title','Cargar Campaña de donación')

@section('content')

    <x-mainMenu/>

    <div class="text-pages font-bold">

        <h2 class="text-2xl mb-10">Este es el formulario para almacenar campañas de donación en el sistema</h2>

        <form class="grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('donation-campaign.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

                <div class="grid grid-cols-q grid-rows-5 gap-5 mr-20 text-2xl">
                    <label>Nombre:</label>
                    <label>Descripción:</label>
                    <label>Fecha de finalización</label>
                    <label>Objetivo de recaudación</label>
                    <label>Foto:</label>
                </div>

                <div class="grid grid-cols-q grid-rows-5 gap-5 w-10 text-black font-normal"">

                    <input type="text" name="name" pattern="[A-Za-z ]+" required value="{{ old('name') }}">

                    <input type="text" name="description" required value="{{ old('description') }}">

                    <input  type="date" name="end_date" min={{ now()->addDays(1)->format('Y-m-d') }} required value="{{ old('end_date') }}">

                    <input type="number" min="1" max="99999999" required name="fundraising_goal" required value="{{ old('fundraising_goal') }}">

                    <input type="file" name="photo" accept="image/*" required>

                </div>

            <button class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700" type="submit">
                Publicar
            </button>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </form>
    </div>

@endsection