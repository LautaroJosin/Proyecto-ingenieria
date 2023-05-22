@extends('layouts.layout-master')

        @section('meta1')
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endsection

        @section('title','Bienvenido')

        @section('content')


        <div class="flex justify-end text-center p-10">
            @if (Route::has('login'))
                @auth 
                    @can('create user') 
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-main-menu ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Registrar usuario</a>
                    @endif
                    @endcan
                @else
                    <a href="{{ route('login') }}" class="text-main-menu font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Iniciar sesion</a>
                @endauth
            @endif
        </div>

        @Auth
            @include('layouts.navigation')
        @else
            <x-mainMenu/>
        @endif

        @endsection
 