@extends('layouts.layout-master')

        @section('title','Welcome')

        @section('content')
        {{-- <body class="antialiased"> --}}
            
            {{--<div class="relative min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"> --}}

                <div class="grid-header-welcome pt-5 px-5">

                <x-mainMenu/>

                <div class="flex justify-end">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-main-menu font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 text-xl">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-main-menu font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-main-menu ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>

                </div>
            
            
            {{-- </div> --}}
        {{-- </body> --}}
        @endsection
 