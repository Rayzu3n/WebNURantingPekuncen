<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Portal Berita NU') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=work-sans:400,500,600,700&display=swap" rel="stylesheet">

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

<body class="font-sans antialiased">

    <div
        class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-8
        bg-[#F5F8FC] text-[#15202B]
        dark:bg-[#101827] dark:text-gray-100
        sm:px-6">

        <!-- Background Decoration -->
        <div class="pointer-events-none absolute inset-0 overflow-hidden">

            <div
                class="absolute -left-32 -top-32 h-72 w-72 rounded-full
                bg-blue-500/10 blur-3xl
                dark:bg-blue-500/10">
            </div>

            <div
                class="absolute -bottom-32 -right-32 h-72 w-72 rounded-full
                bg-cyan-400/10 blur-3xl
                dark:bg-cyan-400/10">
            </div>

        </div>

        <!-- Theme Toggle -->
        <div class="fixed right-5 top-5 z-50">
            <x-theme-toggle />
        </div>

        <!-- Login Content -->
        <div class="relative z-10 w-full sm:max-w-md">

            <!-- Brand -->
            <div class="mb-6 text-center">

                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl
                        bg-green-700 text-sm font-bold text-white
                        shadow-lg shadow-green-900/20">
                        NU
                    </div>

                    <div class="text-left">

                        <div class="text-xl font-semibold
                            text-[#15202B] dark:text-white">
                            Portal Berita NU
                        </div>

                        <div class="text-sm
                            text-gray-500 dark:text-gray-400">
                            Member Portal
                        </div>

                    </div>

                </a>

            </div>

            <!-- Form Card -->
            <div
                class="overflow-hidden rounded-2xl border shadow-xl transition-colors
                border-gray-200 bg-white
                shadow-gray-300/50
                dark:border-white/10 dark:bg-[#1B2638]
                dark:shadow-black/30">

                <div class="px-6 py-7 sm:px-8">

                    {{ $slot }}

                </div>

            </div>

            <!-- Back to Site -->
            <div class="mt-5 text-center">

                <a href="{{ route('home') }}"
                    class="text-sm transition-colors
                    text-gray-500 hover:text-blue-600
                    dark:text-gray-400 dark:hover:text-cyan-400">
                    ← Kembali ke Portal Berita
                </a>

            </div>

        </div>

    </div>

</body>

</html>
