<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bimbingan Skripsi') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-100">
        <div x-data="{ sidebarOpen: true }" class="flex h-screen overflow-hidden">
            
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden transition-all duration-300">
                
                <!-- Topbar header with Hamburger -->
                <header class="sticky top-0 z-30 flex items-center justify-between w-full px-6 py-4 bg-white border-b border-gray-200 shadow-sm">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring bg-gray-100 p-2 rounded-md transition duration-200">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        @isset($header)
                            <h2 class="ml-4 font-semibold text-xl text-gray-800 leading-tight">
                                {{ $header }}
                            </h2>
                        @endisset
                    </div>
                    
                    <!-- Profile Dropdown Top right -->
                    <div class="flex items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-none transition ease-in-out duration-150">
                                    <span class="mr-2 hidden md:block">{{ Auth::user()->name }}</span>
                                    <div class="h-8 w-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                        {{ substr(Auth::user()->name, 0, 2) }}
                                    </div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Main Content Slot -->
                <main class="w-full grow p-6 bg-gray-50">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
