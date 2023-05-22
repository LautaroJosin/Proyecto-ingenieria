    @extends('layouts.layout-master')

    @section('meta1')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection

    @section('title','Usuario')

    @section('content')
            
    <div>
        <a href="/">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>

    @endsection
