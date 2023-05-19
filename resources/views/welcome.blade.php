@extends('layouts.layout-master')

        @section('title','Welcome')

        @section('content')

        <div class="relative min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

            <div class="grid-header-welcome pt-5 px-5 col-span-2">

            @include('layouts.mainMenu')

            <div class="flex justify-end">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 text-xl">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                @endif
            </div>

            </div>
            
            {{-- Contenido propio del dashboard --}}
            <div class="p-10">

                <h2 class="font-semibold text-gray-600 dark:text-gray-400 text-xl justify-center text-center">
                    Bienvenido a Oh my dog!
                </h2>
                
                <p class="font-semibold text-gray-600 dark:text-gray-400">
                    A traves de la aplicacion usted podra solicitar turnos, adoptar un perro,
                    encontrar perros perdidos, solicitar algun servicio cuidado o paseo e incluso donar a campañas beneficas!
                </p>
            </div>  
        
        
        </div>
        @endsection
 