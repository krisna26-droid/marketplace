<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">

            {{-- Sidebar: tampil hanya kalau user sudah login --}}
            @auth
                <aside class="hidden md:block w-64 bg-white border-r">
                    @if(auth()->user()->role === 'admin')
                        @include('partials.nav-admin')
                    @elseif(auth()->user()->role === 'vendor')
                        @include('partials.nav-vendor')
                    @else
                        @include('partials.nav-customer')
                    @endif
                </aside>
            @endauth

            {{-- Konten utama --}}
            <div class="flex-1 flex flex-col">

                {{-- Top Navigation (bawaan Breeze) --}}
                @include('layouts.navigation')

                {{-- Page Header --}}
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                {{-- ALERT GLOBAL --}}
                @if(session('success'))
                    <div class="w-full bg-green-100 text-green-800 p-3 flex justify-between items-center">
                        <span>{{ session('success') }}</span>
                        <button type="button"
                                onclick="this.parentElement.remove()"
                                class="ml-4 text-green-700 hover:text-green-900 font-bold text-lg leading-none focus:outline-none">
                            ×
                        </button>
                    </div>
                @endif

@if(session('error'))
    <div class="w-full bg-red-100 text-red-800 p-3 flex justify-between items-center">
        <span>{{ session('error') }}</span>
        <button type="button"
                onclick="this.parentElement.remove()"
                class="ml-4 text-red-700 hover:text-red-900 font-bold text-lg leading-none focus:outline-none">
            ×
        </button>
    </div>
@endif


                {{-- Page Content --}}
                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>

            </div>
        </div>
    </body>
</html>
