<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $title ?? 'Portal Berita NU' }}
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Newsreader:opsz,wght@6..72,400;6..72,500;6..72,600;6..72,700&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

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

    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            font-family: 'Work Sans', sans-serif;
        }

        .font-editorial {
            font-family: 'Newsreader', serif;
        }

        .font-interface {
            font-family: 'Work Sans', sans-serif;
        }

        .public-selection::selection {
            background: #2ec486;
            color: #003822;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="public-selection min-h-screen flex flex-col bg-[#ffffff] text-[#15201B] antialiased dark:bg-[#101412] dark:text-[#e0e3df]">
    <div class="min-h-screen flex flex-col">

        <!-- Navigation -->
        <header x-data="{ open: false }"
            class="sticky top-0 z-50 border-b border-[#CFD0C3] bg-white/95 backdrop-blur-md dark:border-[#2b312d] dark:bg-[#181c1a]/95">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="h-16 flex items-center justify-between">

                    <!-- Brand -->
                    <div class="flex items-center gap-8">

                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-md bg-[#1C775A] text-white font-bold">
                                NU
                            </div>

                            <div class="font-editorial text-2xl font-semibold tracking-tight text-[#1C775A]">
                                Portal Berita NU
                            </div>
                        </a>

                        <!-- Desktop Navigation -->
                        <nav class="hidden md:flex items-center gap-6">

                            <a href="{{ route('home') }}"
                                class="font-interface text-sm font-semibold transition-colors
                                {{ request()->routeIs('home')
                                    ? 'text-[#1C775A]'
                                    : 'text-[#4A5550] hover:text-[#1C775A] dark:text-[#bbcabf] dark:hover:text-[#53e0a0]' }}">
                                Beranda
                            </a>

                            <a href="{{ route('news.index') }}"
                                class="font-interface text-sm font-semibold transition-colors
                                {{ request()->routeIs('news.*')
                                    ? 'text-[#1C775A]'
                                    : 'text-[#4A5550] hover:text-[#1C775A] dark:text-[#bbcabf] dark:hover:text-[#53e0a0]' }}">
                                Berita
                            </a>

                        </nav>
                    </div>

                    <!-- Desktop Actions -->
                    <div class="hidden sm:flex items-center gap-3">

                        <x-theme-toggle />

                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center rounded-md bg-[#1C775A] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#155A44]">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center rounded-md bg-[#1C775A] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#155A44]">
                                Login
                            </a>
                        @endauth

                    </div>

                    <!-- Mobile Button -->
                    <button type="button" @click="open = !open"
                        class="inline-flex items-center justify-center rounded-md p-2 text-[#4A5550] hover:bg-gray-100 sm:hidden dark:text-[#bbcabf] dark:hover:bg-[#1c201e]"
                        aria-label="Toggle navigation">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />

                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 6l12 12M6 18L18 6" />
                        </svg>
                    </button>

                </div>
            </div>

            <!-- Mobile Navigation -->
            <div x-show="open" x-transition
                class="border-t border-[#CFD0C3] bg-white sm:hidden dark:border-[#2b312d] dark:bg-[#181c1a]">
                <div class="space-y-1 px-4 py-3">

                    <a href="{{ route('home') }}"
                        class="block rounded-md px-3 py-2 text-sm font-semibold text-[#15201B] hover:bg-[#F5FAF8] hover:text-[#1C775A] dark:text-[#e0e3df] dark:hover:bg-[#1c201e]">
                        Beranda
                    </a>

                    <a href="{{ route('news.index') }}"
                        class="block rounded-md px-3 py-2 text-sm font-semibold text-[#15201B] hover:bg-[#F5FAF8] hover:text-[#1C775A] dark:text-[#e0e3df] dark:hover:bg-[#1c201e]">
                        Berita
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="block rounded-md bg-[#1C775A] px-3 py-2 text-sm font-semibold text-white">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block rounded-md bg-[#1C775A] px-3 py-2 text-sm font-semibold text-white">
                            Login
                        </a>
                    @endauth

                </div>
            </div>
        </header>


        <!-- Main Content -->
        <main class="flex-1 w-full">

            {{ $slot }}

        </main>


        <!-- Footer -->
        <footer class="mt-auto border-t border-[#CFD0C3] bg-[#15201B] px-4 py-12 text-[#CFD0C3] sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">

                <div class="grid gap-10 md:grid-cols-3">

                    <!-- Brand -->
                    <div>
                        <div class="font-editorial text-2xl font-semibold text-white">
                            Portal Berita NU
                        </div>

                        <p class="mt-3 max-w-md text-sm leading-6 text-[#CFD0C3]">
                            Portal informasi dan berita untuk menyajikan
                            kegiatan serta informasi seputar NU.
                        </p>
                    </div>

                    <!-- Navigation -->
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-white">
                            Navigasi
                        </h3>

                        <div class="mt-4 space-y-2">

                            <a href="{{ route('home') }}" class="block text-sm transition-colors hover:text-[#94DFE0]">
                                Beranda
                            </a>

                            <a href="{{ route('news.index') }}"
                                class="block text-sm transition-colors hover:text-[#94DFE0]">
                                Berita
                            </a>

                            @auth
                                <a href="{{ route('dashboard') }}"
                                    class="block text-sm transition-colors hover:text-[#94DFE0]">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="block text-sm transition-colors hover:text-[#94DFE0]">
                                    Login
                                </a>
                            @endauth

                        </div>
                    </div>

                    <!-- Organisation -->
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-white">
                            Portal
                        </h3>

                        <p class="mt-4 text-sm leading-6 text-[#CFD0C3]">
                            Media informasi resmi untuk lingkungan ranting
                            NU yang menjadi cakupan portal ini.
                        </p>
                    </div>

                </div>

                <div class="mt-10 border-t border-[#2b312d] pt-6">
                    <p class="text-sm text-[#86948a]">
                        &copy; {{ date('Y') }} Portal Berita NU. All rights reserved.
                    </p>
                </div>

            </div>
        </footer>

    </div>
</body>

</html>
