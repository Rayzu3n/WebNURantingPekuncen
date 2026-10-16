<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Portal NU Pekuncen') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        (() => {
            const savedTheme = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', savedTheme === 'dark' || (!savedTheme && systemDark));
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen bg-[#f8f7f1] font-sans antialiased text-[#192b23] dark:bg-[#121915] dark:text-[#ebefe5]">
    <main class="grid min-h-screen lg:grid-cols-[.88fr_1.12fr]">
        <aside class="relative flex min-h-[280px] flex-col justify-between overflow-hidden bg-[#1a5b41] px-6 py-7 text-white sm:px-10 sm:py-9 lg:min-h-screen lg:px-14 lg:py-12 dark:bg-[#183b2a]">
            <div class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center border border-white/50 text-sm font-extrabold tracking-[-.08em]">NU</span>
                <div>
                    <p class="font-editorial text-lg font-extrabold tracking-[-.04em]">Portal NU</p>
                    <p class="mt-1 text-[9px] font-bold uppercase tracking-[.2em] text-white/65">Ranting Pekuncen</p>
                </div>
            </div>

            <div class="relative z-10 max-w-xl py-10">
                <p class="inline-flex items-center gap-2 text-[10px] font-extrabold uppercase tracking-[.18em] text-[#c5e0c4]"><span class="h-1.5 w-1.5 rounded-full bg-[#e2a082]"></span> Ruang anggota</p>
                <h1 class="mt-6 font-editorial text-4xl font-extrabold leading-[.98] tracking-[-.065em] sm:text-5xl lg:text-6xl xl:text-7xl">Tetap terhubung.<br><span class="text-[#c5e0c4]">Terus bergerak.</span></h1>
                <p class="mt-6 max-w-md text-sm leading-7 text-white/75 sm:text-base">Akses informasi keanggotaan dan layanan digital dalam satu ruang yang lebih dekat dengan komunitas.</p>
            </div>

            <div class="relative z-10 flex items-end justify-between gap-4 border-t border-white/20 pt-5">
                <p class="max-w-xs text-xs leading-5 text-white/60">Portal informasi dan keanggotaan<br>Ranting Pekuncen</p>
                <span class="font-editorial text-5xl font-extrabold tracking-[-.1em] text-white/15 sm:text-7xl" aria-hidden="true">NU.</span>
            </div>
        </aside>

        <section class="relative flex min-h-screen flex-col items-center justify-center px-4 py-10 sm:px-8 lg:px-12">
            <div class="absolute right-5 top-5 sm:right-8 sm:top-8"><x-theme-toggle /></div>
            <div class="w-full max-w-md">
                <a href="{{ route('home') }}" class="mb-8 inline-flex min-h-11 items-center gap-2.5 rounded-xl border border-[#cbd8ca] bg-[#f5f8f1] px-4 py-3 text-sm font-extrabold text-[#1a5b41] shadow-sm transition hover:border-[#1a5b41] hover:bg-[#e7eee5] focus:outline-none focus:ring-2 focus:ring-[#1a5b41] focus:ring-offset-2 dark:border-[#405646] dark:bg-[#213127] dark:text-[#a8ddb8] dark:hover:border-[#80ca9d] dark:hover:bg-[#2a3b2f]">
                    <svg aria-hidden="true" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 10 9-7 9 7"/>
                        <path d="M5 9v12h14V9"/>
                        <path d="M9 21v-7h6v7"/>
                    </svg>
                    <span>Kembali ke halaman utama</span>
                </a>
                <div class="mb-6">
                    <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-[#b75d3c]">Portal keanggotaan</p>
                    <h2 class="mt-2 font-editorial text-3xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5]">Selamat datang.</h2>
                    <p class="mt-2 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Masuk atau daftarkan akun untuk melanjutkan.</p>
                </div>
                <div class="rounded-[1.5rem] border border-[#dde0d6] bg-[#fffef9] p-6 shadow-[0_24px_70px_-48px_rgba(25,43,35,.45)] sm:p-8 dark:border-[#364339] dark:bg-[#19221c] dark:shadow-black/25">
                    {{ $slot }}
                </div>
                <p class="mt-6 text-center text-[11px] leading-5 text-[#88968a] dark:text-[#86968a]">© {{ date('Y') }} Portal Berita NU Pekuncen</p>
            </div>
        </section>
    </main>
</body>
</html>
