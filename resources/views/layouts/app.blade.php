@extends('layouts.layout-master')

@section('meta1')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('meta2')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection

@section('title','Usuario')

@section('content')

    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        
    </div>
@endsection
