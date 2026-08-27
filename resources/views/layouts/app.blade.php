<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Registration System') — SRS</title>

    {{-- Vite: Tailwind CSS + App JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js for interactive UI (flash dismiss, menu toggle, image preview) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-gray-50 antialiased">

<div class="flex min-h-screen" x-data="{ sidebarOpen: false }">

    {{-- ── Mobile Overlay ── --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-gray-900/50 lg:hidden" x-cloak></div>

    {{-- ── Sidebar ── --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-indigo-900 transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-auto lg:z-auto"
    >
        {{-- Brand --}}
        <div class="flex h-16 shrink-0 items-center gap-3 px-6 border-b border-indigo-800">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-500">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <span class="text-sm font-semibold text-white leading-tight">Student<br>Registration</span>
        </div>

        {{-- Nav Links --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">
            @php
                $navLink = fn(string $name, string $route, string $icon) =>
                    ['name' => $name, 'route' => $route, 'icon' => $icon,
                     'active' => request()->routeIs($route) || request()->routeIs($route . '.*')];

                $links = [
                    ['name' => 'Dashboard',       'route' => 'dashboard',         'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['name' => 'All Students',    'route' => 'students.index',    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['name' => 'Register Student','route' => 'students.create',   'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
                ];
            @endphp

            @foreach ($links as $link)
                @php $isActive = request()->routeIs($link['route']); @endphp
                <a href="{{ route($link['route']) }}"
                   class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                          {{ $isActive
                             ? 'bg-indigo-700 text-white'
                             : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $link['icon'] }}"/>
                    </svg>
                    {{ $link['name'] }}
                </a>
            @endforeach
        </nav>
    </aside>

    {{-- ── Main Area ── --}}
    <div class="flex flex-1 flex-col lg:pl-0">

        {{-- Top Bar --}}
        <header class="sticky top-0 z-10 flex h-16 items-center gap-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:px-6 lg:hidden">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="text-sm font-semibold text-gray-700">Student Registration System</span>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-full">

            {{-- Flash Messages --}}
            <x-flash-message />

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
