    @extends('layouts.layout-master')

    @section('meta1')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection

    @section('title','Registrar Usuario')

    @section('content')

    {{-- <body class="font-sans text-gray-900 antialiased"> --}}

        {{-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 bg-dots-darker bg-center dark:bg-dots-lighter dark:bg-gray-900"> --}}
            
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

        {{--</div>--}}
    @endsection
