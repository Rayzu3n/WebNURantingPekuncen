<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Portal Berita NU Pekuncen' }}</title>
    <meta name="theme-color" content="#f8f7f1">
    <meta name="description" content="Kabar, kegiatan, dan cerita Nahdlatul Ulama di Pekuncen.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script>
        (() => {
            const savedTheme = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', savedTheme === 'dark' || (!savedTheme && systemDark));
        })();
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-[#f8f7f1] text-[#192b23] antialiased dark:bg-[#121915] dark:text-[#ebefe5]">
    <div class="flex min-h-screen flex-col">
        <div class="border-b border-[#dfe2d6] bg-[#f0efe7] dark:border-[#364339] dark:bg-[#1b251e]">
            <div class="mx-auto flex max-w-[1500px] items-center justify-between px-4 py-2.5 sm:px-7 lg:px-10">
                <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-[#5f7163] dark:text-[#b0c3b2]">
                    <span class="mr-2 inline-block h-2 w-2 rounded-full bg-[#b75d3c]"></span>
                    Ruang kabar warga Pekuncen
                </p>
                <p class="hidden text-[11px] font-semibold tracking-wide text-[#66746a] dark:text-[#a3b1a5] sm:block">
                    {{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>

        <header x-data="{ open: false }"
            class="sticky top-0 z-50 border-b border-[#dde0d6] bg-[#fffef9]/95 backdrop-blur-xl dark:border-[#364339] dark:bg-[#19221c]/95">
            <div class="mx-auto max-w-[1500px] px-4 sm:px-7 lg:px-10">
                <div class="flex min-h-[82px] items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="group flex min-w-0 items-center gap-3.5">
                        <span class="flex h-12 w-16 shrink-0 items-center justify-center border border-[#cbd8ca] bg-white px-1 dark:border-[#405646]"><img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Nahdlatul_Ulama_Logo.svg" alt="Lambang resmi Nahdlatul Ulama" class="h-10 w-full object-contain" decoding="async"></span>
                        <span class="min-w-0">
                            <span
                                class="block font-editorial text-lg font-extrabold leading-tight tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-xl">Portal
                                NU</span>
                            <span
                                class="mt-1 block text-[9px] font-extrabold uppercase tracking-[.2em] text-[#66746a] dark:text-[#a3b1a5]">Ranting
                                Pekuncen</span>
                        </span>
                    </a>

                    <nav class="hidden items-center gap-1 lg:flex" aria-label="Navigasi utama">
                        <a href="{{ route('home') }}"
                            class="rounded-full px-4 py-2.5 text-sm font-bold transition {{ request()->routeIs('home') ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'text-[#66746a] hover:bg-[#f0efe7] hover:text-[#192b23] dark:text-[#bdc8bc] dark:hover:bg-[#253127] dark:hover:text-white' }}">Beranda</a>
                        <a href="{{ route('news.index') }}"
                            class="rounded-full px-4 py-2.5 text-sm font-bold transition {{ request()->routeIs('news.*') ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'text-[#66746a] hover:bg-[#f0efe7] hover:text-[#192b23] dark:text-[#bdc8bc] dark:hover:bg-[#253127] dark:hover:text-white' }}">Semua
                            berita</a>
                        <a href="{{ route('events.index') }}"
                            class="rounded-full px-4 py-2.5 text-sm font-bold transition {{ request()->routeIs('events.*') ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'text-[#66746a] hover:bg-[#f0efe7] hover:text-[#192b23] dark:text-[#bdc8bc] dark:hover:bg-[#253127] dark:hover:text-white' }}">Kegiatan</a>
                        <a href="{{ route('about') }}"
                            class="rounded-full px-4 py-2.5 text-sm font-bold transition {{ request()->routeIs('about') ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'text-[#66746a] hover:bg-[#f0efe7] hover:text-[#192b23] dark:text-[#bdc8bc] dark:hover:bg-[#253127] dark:hover:text-white' }}">Tentang
                            Kami</a>
                        <a href="{{ route('contact.index') }}"
                            class="rounded-full px-4 py-2.5 text-sm font-bold transition {{ request()->routeIs('contact.*') ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'text-[#66746a] hover:bg-[#f0efe7] hover:text-[#192b23] dark:text-[#bdc8bc] dark:hover:bg-[#253127] dark:hover:text-white' }}">Kontak</a>
                    </nav>

                    <div class="hidden items-center gap-2 lg:flex">
                        <x-theme-toggle />
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex min-h-11 items-center gap-2 rounded-full bg-[#1a5b41] px-5 text-sm font-bold text-white transition hover:bg-[#134832] dark:bg-[#80ca9d] dark:text-[#17251b] dark:hover:bg-[#a0dfb5]"><x-portal-icon
                                    name="dashboard" class="h-4 w-4" />Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex min-h-11 items-center gap-2 rounded-full border border-[#cbd8ca] px-5 text-sm font-bold text-[#1a5b41] transition hover:bg-[#e7eee5] dark:border-[#405646] dark:text-[#a8ddb8] dark:hover:bg-[#2a3b2f]"><x-portal-icon
                                    name="log-in" class="h-4 w-4" />Masuk</a>
                            <a href="{{ route('register') }}"
                                class="inline-flex min-h-11 items-center gap-2 rounded-full bg-[#1a5b41] px-5 text-sm font-bold text-white transition hover:bg-[#134832] dark:bg-[#80ca9d] dark:text-[#17251b] dark:hover:bg-[#a0dfb5]"><x-portal-icon
                                    name="user-round" class="h-4 w-4" />Buat akun</a>
                        @endauth
                    </div>

                    <button type="button" @click="open = !open"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#dde0d6] text-[#1a5b41] lg:hidden dark:border-[#364339] dark:text-[#a8ddb8]"
                        :aria-label="open ? 'Tutup menu navigasi' : 'Buka menu navigasi'"
                        aria-controls="mobile-navigation" :aria-expanded="open.toString()">
                        <svg x-show="!open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="open" x-cloak class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M6 6l12 12M18 6L6 18" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="open" x-cloak x-transition id="mobile-navigation"
                class="border-t border-[#dde0d6] bg-[#fffef9] px-4 py-4 lg:hidden dark:border-[#364339] dark:bg-[#19221c]">
                <nav class="mx-auto max-w-[1500px] space-y-1" aria-label="Navigasi seluler">
                    <a href="{{ route('home') }}"
                        class="block rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('home') ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'text-[#526156] hover:bg-[#f0efe7] dark:text-[#c2cdc1] dark:hover:bg-[#253127]' }}">Beranda</a>
                    <a href="{{ route('news.index') }}"
                        class="block rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('news.*') ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'text-[#526156] hover:bg-[#f0efe7] dark:text-[#c2cdc1] dark:hover:bg-[#253127]' }}">Semua
                        berita</a>
                    <a href="{{ route('events.index') }}"
                        class="block rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('events.*') ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'text-[#526156] hover:bg-[#f0efe7] dark:text-[#c2cdc1] dark:hover:bg-[#253127]' }}">Kegiatan</a>
                    <a href="{{ route('about') }}"
                        class="block rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('about') ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'text-[#526156] hover:bg-[#f0efe7] dark:text-[#c2cdc1] dark:hover:bg-[#253127]' }}">Tentang
                        Kami</a>
                    <a href="{{ route('contact.index') }}"
                        class="block rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('contact.*') ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'text-[#526156] hover:bg-[#f0efe7] dark:text-[#c2cdc1] dark:hover:bg-[#253127]' }}">Kontak</a>
                    <div class="flex items-center gap-2 pt-2">
                        <x-theme-toggle />
                        @auth
                            <a href="{{ route('dashboard') }}" class="portal-button flex-1 rounded-xl"><x-portal-icon
                                    name="dashboard" class="h-4 w-4" />Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="portal-button flex-1 rounded-xl"><x-portal-icon
                                    name="log-in" class="h-4 w-4" />Masuk</a>
                            <a href="{{ route('register') }}" class="portal-button flex-1 rounded-xl"><x-portal-icon
                                    name="user-round" class="h-4 w-4" />Buat akun</a>
                        @endauth
                    </div>
                </nav>
            </div>
        </header>

        <main class="w-full flex-1">{{ $slot }}</main>

        <footer class="mt-auto bg-[#192b23] text-[#e3e8dc] dark:bg-[#0d130f]">
            <div class="mx-auto max-w-[1500px] px-4 py-12 sm:px-7 lg:px-10 lg:py-16">
                <div class="grid gap-10 border-b border-white/15 pb-10 md:grid-cols-[1.4fr_.7fr_.9fr]">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-16 items-center justify-center border border-[#80ca9d] bg-white px-1"><img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Nahdlatul_Ulama_Logo.svg" alt="Lambang resmi Nahdlatul Ulama" class="h-9 w-full object-contain" loading="lazy" decoding="async"></span>
                            <div>
                                <p class="font-editorial text-xl font-extrabold tracking-[-.04em] text-white">Portal NU
                                </p>
                                <p class="mt-1 text-[9px] font-extrabold uppercase tracking-[.2em] text-[#a8b8a8]">
                                    Ranting Pekuncen</p>
                            </div>
                        </div>
                        <p class="mt-5 max-w-md text-sm leading-7 text-[#b9c7b8]">Kabar kegiatan, informasi, dan cerita
                            dari lingkungan Nahdlatul Ulama di Pekuncen. Dekat dengan warga, terbuka untuk semua.</p>
                    </div>
                    <div>
                        <p class="portal-kicker !text-[#a8ddb8]">Jelajahi</p>
                        <div class="mt-4 space-y-3 text-sm font-semibold text-[#d1dbcf]">
                            <a href="{{ route('home') }}" class="block transition hover:text-white">Beranda</a>
                            <a href="{{ route('news.index') }}" class="block transition hover:text-white">Semua
                                berita</a>
                            <a href="{{ route('about') }}" class="block transition hover:text-white">Tentang Kami</a>
                            <a href="{{ route('contact.index') }}" class="block transition hover:text-white">Hubungi
                                kami</a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="block transition hover:text-white">Dashboard
                                    anggota</a>
                            @else
                                <a href="{{ route('login') }}" class="block transition hover:text-white">Masuk
                                    anggota</a>
                            @endauth
                        </div>
                    </div>
                    <div>
                        <p class="portal-kicker !text-[#a8ddb8]">Tentang portal</p>
                        <p class="mt-4 text-sm leading-7 text-[#b9c7b8]">Ruang digital untuk mendokumentasikan
                            kegiatan, memperluas informasi, dan menjaga kabar lokal tetap mudah ditemukan.</p>
                    </div>
                </div>
                <div
                    class="flex flex-col gap-2 pt-6 text-xs text-[#93a393] sm:flex-row sm:items-center sm:justify-between">
                    <p>© {{ date('Y') }} Portal Berita NU Pekuncen</p>
                    <p>Informasi lokal. Jejak yang berkelanjutan.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
