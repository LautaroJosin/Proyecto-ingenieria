@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title','Editar campaña de donación')

@section('content')

    <x-mainMenu/>

    <div class="text-pages font-bold">

        <form class="grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('donation-campaign.update', $campaign) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <div class="grid grid-cols-q grid-rows-5 gap-5 mr-20 text-2xl">
                    <label>Nombre:</label>
                    <label>Descripción:</label>
                    <label>Fecha de finalización</label>
                    <label>Objetivo de recaudación</label>
                    <label>Foto:</label>
                </div>

                <div class="grid grid-cols-q grid-rows-5 gap-5 w-10 text-black font-normal"">

                    <input type="text" name="name" pattern="[A-Za-z ]+" required value="{{ $campaign->name }}">

                    <input type="text" name="description" required value="{{ $campaign->description }}">

                    <input type="date" name="end_date" min={{ now()->format('Y-m-d') }} required value="{{ $campaign->end_date }}">

                    <input type="number" min="1" max="99999999" required name="fundraising_goal" required value="{{ $campaign->fundraising_goal }}">

                    <input type="file" name="photo" accept="image/*">
                    @error('photo')
                        <small class="text-danger text-red-600 font-bold text-xl"> {{$message}} </small>
                    @enderror

                </div>

            <button class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700" type="submit">
                Confirmar
            </button>

            </form>

    </div>

@endsection