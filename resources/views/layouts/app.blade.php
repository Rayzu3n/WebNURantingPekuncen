<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Portal Berita NU') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=work-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Theme -->
    <script>
        (() => {
            const savedTheme = localStorage.getItem('theme');

            const systemDark = window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches;

            const useDark = savedTheme === 'dark' ||
                (!savedTheme && systemDark);

            document.documentElement.classList.toggle('dark', useDark);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">

    <div x-data="{ sidebarOpen: false }" class="min-h-screen">

        <!-- Mobile Backdrop -->
        <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full transform border-r transition-transform duration-200
    {{ auth()->user()->isAdmin()
        ? 'border-white/10 bg-[#0B1220]'
        : 'border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900' }}
    lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Brand -->
            <div
                class="flex h-20 items-center justify-between border-b px-6
        {{ auth()->user()->isAdmin() ? 'border-white/10' : 'border-gray-200 dark:border-gray-800' }}">

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl
                bg-green-700 text-sm font-bold text-white
                shadow-lg shadow-green-950/20">
                        NU
                    </div>

                    <div>

                        <div
                            class="text-base font-semibold
                    {{ auth()->user()->isAdmin() ? 'text-white' : 'text-gray-900 dark:text-gray-100' }}">
                            Portal Berita NU
                        </div>

                        <div
                            class="text-xs
                    {{ auth()->user()->isAdmin() ? 'text-gray-400' : 'text-gray-500 dark:text-gray-400' }}">
                            @if (auth()->user()->isAdmin())
                                Administrator
                            @else
                                Member
                            @endif
                        </div>

                    </div>

                </a>

                <!-- Mobile Close -->
                <button type="button" @click="sidebarOpen = false"
                    class="rounded-lg p-2
            {{ auth()->user()->isAdmin()
                ? 'text-gray-400 hover:bg-white/10 hover:text-white'
                : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-200' }}
            lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>

            <!-- Navigation -->
            <nav class="space-y-1 px-4 py-6">

                @if (auth()->user()->isAdmin())
                    <div class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-500">
                        Administration
                    </div>

                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0
                    {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l9-9 9 9M5 10v10h14V10M9 20v-6h6v6" />
                        </svg>

                        <span>Dashboard</span>
                    </a>

                    <!-- News -->
                    <a href="{{ route('admin.news.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.news.*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0
                    {{ request()->routeIs('admin.news.*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 5h16v14H4zM8 9h8M8 13h8M8 17h5" />
                        </svg>

                        <span>News</span>
                    </a>

                    <!-- Categories -->
                    <a href="{{ route('admin.categories.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.categories.*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0
                    {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6h6v6H4zM14 6h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" />
                        </svg>

                        <span>Categories</span>
                    </a>

                    <!-- Members -->
                    <a href="{{ route('admin.members.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.members.*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0
                    {{ request()->routeIs('admin.members.*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                        </svg>

                        <span>Members</span>
                    </a>
                @else
                    <div class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                        Member Area
                    </div>

                    <!-- Dashboard -->
                    <a href="{{ route('member.dashboard') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                {{ request()->routeIs('member.dashboard')
                    ? 'bg-green-50 text-green-700 dark:bg-green-950/40 dark:text-green-400'
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l9-9 9 9M5 10v10h14V10M9 20v-6h6v6" />
                        </svg>

                        <span>Dashboard</span>
                    </a>

                    <!-- Profile -->
                    <a href="{{ route('member.profile') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                {{ request()->routeIs('member.profile*')
                    ? 'bg-green-50 text-green-700 dark:bg-green-950/40 dark:text-green-400'
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0116.5 0" />
                        </svg>

                        <span>Profile</span>
                    </a>

                    <!-- Member Card -->
                    <a href="{{ route('member.card') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                {{ request()->routeIs('member.card')
                    ? 'bg-green-50 text-green-700 dark:bg-green-950/40 dark:text-green-400'
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 9h4M7 13h3" />
                        </svg>

                        <span>Member Card</span>
                    </a>
                @endif

            </nav>

            <!-- Sidebar Bottom -->
            <div
                class="absolute inset-x-0 bottom-0 border-t p-4
        {{ auth()->user()->isAdmin() ? 'border-white/10' : 'border-gray-200 dark:border-gray-800' }}">

                <div
                    class="mb-3 rounded-xl p-3
            {{ auth()->user()->isAdmin() ? 'bg-white/5' : 'bg-gray-50 dark:bg-gray-800/60' }}">
                    <p
                        class="truncate text-sm font-semibold
                {{ auth()->user()->isAdmin() ? 'text-white' : 'text-gray-900 dark:text-gray-100' }}">
                        {{ auth()->user()->name }}
                    </p>

                    <p
                        class="truncate text-xs
                {{ auth()->user()->isAdmin() ? 'text-gray-400' : 'text-gray-500 dark:text-gray-400' }}">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                {{ auth()->user()->isAdmin()
                    ? 'text-red-400 hover:bg-red-500/10 hover:text-red-300'
                    : 'text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12H3m0 0l4-4m-4 4l4 4M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" />
                        </svg>

                        <span>Logout</span>
                    </button>
                </form>

            </div>

        </aside>

        <!-- Main Area -->
        <div class="lg:pl-72">

            <!-- Top Bar -->
            <header
                class="sticky top-0 z-30 border-b border-gray-200 bg-white/90 backdrop-blur dark:border-gray-800 dark:bg-gray-900/90">

                <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                    <div class="flex items-center gap-3">

                        <!-- Mobile Menu Button -->
                        <button type="button" @click="sidebarOpen = true"
                            class="rounded-xl p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-200 lg:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Page Heading -->
                        @isset($header)
                            <div>
                                {{ $header }}
                            </div>
                        @else
                            <div>
                                <p class="text-lg font-semibold">
                                    @if (auth()->user()->isAdmin())
                                        Administrator
                                    @else
                                        Member Area
                                    @endif
                                </p>

                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Portal Berita NU
                                </p>
                            </div>
                        @endisset

                    </div>

                    <!-- Top Actions -->
                    <div class="flex items-center gap-2">

                        <a href="{{ route('home') }}"
                            class="hidden rounded-xl px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white sm:inline-flex">
                            View Site
                        </a>

                        <x-theme-toggle />

                    </div>

                </div>

            </header>

            <!-- Main Content -->
            <main class="min-h-[calc(100vh-5rem)] px-4 py-6 sm:px-6 lg:px-8">

                {{ $slot }}

            </main>

        </div>

    </div>

</body>

</html>
