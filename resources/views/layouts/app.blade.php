<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Coffee Shop') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-20 bg-white dark:bg-gray-800 shadow-lg flex flex-col items-center py-6 gap-6 fixed h-full z-50">

            {{-- Logo --}}
            <div class="text-amber-800 dark:text-amber-400 font-bold text-sm text-center leading-tight mb-2">
                ☕<br>coffee
            </div>

            {{-- Nav Links --}}
            <nav class="flex flex-col items-center gap-2 flex-1">

                <a href="{{ route('dashboard') }}"
                   class="flex flex-col items-center gap-1 p-3 rounded-xl w-16 text-center transition
                   {{ request()->routeIs('dashboard') ? 'bg-amber-800 text-white' : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-xs">Home</span>
                </a>

                <a href="{{ route('pos.index') }}"
                   class="flex flex-col items-center gap-1 p-3 rounded-xl w-16 text-center transition
                   {{ request()->routeIs('pos.*') ? 'bg-amber-800 text-white' : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span class="text-xs">Menu</span>
                </a>

                <a href="{{ route('product.index') }}"
                   class="flex flex-col items-center gap-1 p-3 rounded-xl w-16 text-center transition
                   {{ request()->routeIs('product.*') ? 'bg-amber-800 text-white' : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                    <span class="text-xs">Products</span>
                </a>
                 <a href="{{ route('order.index') }}"
                    class="flex flex-col items-center gap-1 p-3 rounded-xl w-16 text-center transition
                    {{ request()->routeIs('order.*') ? 'bg-amber-800 text-white' : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-xs">History</span>
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="flex flex-col items-center gap-1 p-3 rounded-xl w-16 text-center transition
                   {{ request()->routeIs('profile.*') ? 'bg-amber-800 text-white' : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-xs">Setting</span>
                </a>

            </nav>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex flex-col items-center gap-1 p-3 rounded-xl w-16 text-center text-gray-500 hover:bg-red-50 hover:text-red-500 dark:hover:bg-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="text-xs">Logout</span>
                </button>
            </form>

        </aside>

        {{-- Main Content --}}
        <div class="flex-1 ml-20">
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-4 px-6">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            <main>
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html>
