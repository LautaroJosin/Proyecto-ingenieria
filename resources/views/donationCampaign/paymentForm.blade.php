@extends('layouts.layout-master')

@section('meta1')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@endsection

@section('title','Donar a campaña')

@section('content')

    <x-mainMenu/>

    <div class="text-pages font-bold">

    <br>
    <br>

    <form class="grid grid-cols-20-80 grid-rows-1 justify-center" action="{{ route('donation-campaign.proccessDonation' , $campaign_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

            <div class="grid grid-cols-q grid-rows-6 gap-5 mr-20 text-2xl">
                
                <label>Tipo de tarjeta:</label>

                <label>Numero de tarjeta:</label>

                <label>Titular de la tarjeta:</label>
        
                <label>CVV:</label>

                <label>Fecha de expiración:</label>

                <label>Monto a donar:</label>

            </div>

            <div class="grid grid-cols-q grid-rows-6 gap-5 w-10 text-black font-normal">
			
	            <select name="card_type" required>
	            	<option value="">Seleccione una tarjeta</option>
	                <option value="D">Tarjeta de debito</option>
	                <option value="C">Tarjeta de credito </option>
	            </select>
                @error('card_type')
                    <small class="text-red-600"> {{$message}} </small>
                @enderror

                <input type="number" name="card_number" class="form-control" required min="1">
                @error('card_number')
                    <small class="text-red-600"> {{$message}} </small>
                @enderror

                <input type="text" name="cardholder" class="form-control" pattern="[A-Za-z ]+" required>
                @error('cardholder')
                    <small class="text-red-600"> {{$message}} </small>
                @enderror

	            <input type="number" name="cvv" class="form-control" required min="100" max="999">
                @error('cvv')
                    <small class="text-red-600"> {{$message}} </small>
                @enderror

	            <input type="date" name="expiration_date" class="form-control" min="{{  date('Y-m-d') }}" required>
                @error('expiration_date')
                    <small class="text-red-600"> {{$message}} </small>
                @enderror

                <input type="number" name="amount" class="form-control" required min="1">
                @error('amount')
                    <small class="text-red-600"> {{$message}} </small>
                @enderror

        	</div>


        	<button type="submit" class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700">Confirmar donación</button>
    </form>
	
	<div class="text-2xl border-2 border-solid border-white w-40 mt-5 hover:bg-sky-700 pl-5"><a href="{{ route('donation-campaign.index') }}">Cancelar</a></div>

    </div>

   @endsection