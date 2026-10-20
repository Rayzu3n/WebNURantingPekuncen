<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Portal NU Pekuncen') }}</title>
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="workspace-ui min-h-screen bg-[#f8f7f1] font-sans antialiased text-[#192b23] dark:bg-[#121915] dark:text-[#ebefe5]">
    @php($isAdmin = auth()->user()->isAdmin())
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-[#101a13]/55 lg:hidden"></div>
        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-[min(84vw,278px)] -translate-x-full flex-col border-r border-[#dde0d6] bg-[#fffef9] transition-transform duration-200 dark:border-[#364339] dark:bg-[#19221c] lg:w-[278px] lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div
                class="flex h-[88px] shrink-0 items-center justify-between border-b border-[#dde0d6] px-6 dark:border-[#364339]">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <span class="flex h-11 w-16 items-center justify-center border border-[#cbd8ca] bg-white px-1 dark:border-[#405646]"><img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Nahdlatul_Ulama_Logo.svg" alt="Lambang resmi Nahdlatul Ulama" class="h-9 w-full object-contain" decoding="async"></span>
                    <span><span
                            class="block font-editorial text-base font-extrabold tracking-[-.04em] text-[#192b23] dark:text-[#ebefe5]">Portal
                            NU</span><span
                            class="mt-1 block text-[9px] font-extrabold uppercase tracking-[.16em] text-[#66746a] dark:text-[#a3b1a5]">{{ $isAdmin ? 'Administrator' : 'Anggota' }}</span></span>
                </a>
                <button type="button" @click="sidebarOpen = false"
                    class="rounded-full p-2 text-[#66746a] hover:bg-[#f0efe7] lg:hidden dark:text-[#a3b1a5] dark:hover:bg-[#253127]"
                    aria-label="Tutup menu">✕</button>
            </div>
            <div class="px-5 pb-2 pt-6">
                <p class="px-3 text-[9px] font-extrabold uppercase tracking-[.18em] text-[#88968a]">
                    {{ $isAdmin ? 'Workspace redaksi' : 'Ruang anggota' }}</p>
            </div>
            <nav class="min-h-0 flex-1 space-y-1 overflow-y-auto px-4 py-2" aria-label="Navigasi dashboard">
                @php($navItems = $isAdmin ? [['label' => 'Ringkasan', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'icon' => 'dashboard'], ['label' => 'Berita', 'route' => 'admin.news.index', 'pattern' => 'admin.news.*', 'icon' => 'newspaper'], ['label' => 'Kegiatan', 'route' => 'admin.events.index', 'pattern' => 'admin.events.*', 'icon' => 'calendar'], ['label' => 'Kategori', 'route' => 'admin.categories.index', 'pattern' => 'admin.categories.*', 'icon' => 'tags'], ['label' => 'Anggota', 'route' => 'admin.members.index', 'pattern' => 'admin.members.*', 'icon' => 'users'], ['label' => 'Pendaftaran', 'route' => 'admin.membership-applications.index', 'pattern' => 'admin.membership-applications.*', 'icon' => 'clipboard-check']] : [['label' => 'Ringkasan', 'route' => 'member.dashboard', 'pattern' => 'member.dashboard', 'icon' => 'dashboard'], ['label' => 'Profil saya', 'route' => 'member.profile', 'pattern' => 'member.profile*', 'icon' => 'user-round'], ['label' => 'Kartu anggota', 'route' => 'member.card', 'pattern' => 'member.card', 'icon' => 'id-card']])
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-bold transition {{ request()->routeIs($item['pattern']) ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'text-[#66746a] hover:bg-[#f0efe7] hover:text-[#192b23] dark:text-[#bdc8bc] dark:hover:bg-[#253127] dark:hover:text-white' }}">
                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-current/15">
                            <x-portal-icon :name="$item['icon']" class="h-4 w-4" />
                        </span>
                        <span class="min-w-0 flex-1">{{ $item['label'] }}</span>
                        @if (request()->routeIs($item['pattern']))
                            <span class="ml-auto h-1.5 w-1.5 rounded-full bg-[#b75d3c]"></span>
                        @endif
                    </a>
                @endforeach
            </nav>
            <div class="shrink-0 border-t border-[#dde0d6] p-4 dark:border-[#364339]">
                <div class="flex items-center gap-3 px-1 pb-2">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#e4ede2] text-xs font-extrabold text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]">
                        {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 2)) }}</div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-xs font-extrabold text-[#192b23] dark:text-[#ebefe5]">
                            {{ auth()->user()->name }}</p>
                        <p class="mt-1 truncate text-[10px] text-[#66746a] dark:text-[#a3b1a5]">
                            {{ auth()->user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('home') }}"
                    class="mb-4 mt-3 flex min-h-12 items-center gap-3 rounded-xl border border-[#cbd8ca] bg-[#f5f8f1] px-3.5 py-3 text-sm font-extrabold text-[#1a5b41] shadow-sm transition hover:border-[#1a5b41] hover:bg-[#e7eee5] focus:outline-none focus:ring-2 focus:ring-[#1a5b41] focus:ring-offset-2 dark:border-[#405646] dark:bg-[#213127] dark:text-[#a8ddb8] dark:hover:border-[#80ca9d] dark:hover:bg-[#2a3b2f]">
                    <svg aria-hidden="true" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 10 9-7 9 7" />
                        <path d="M5 9v12h14V9" />
                        <path d="M9 21v-7h6v7" />
                    </svg>
                    <span class="flex-1">Kembali ke halaman utama</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit"
                        class="group flex min-h-11 w-full items-center gap-3 rounded-xl border border-[#f0cfc8] bg-[#fff7f4] px-3.5 py-2.5 text-sm font-extrabold text-[#a33f2e] transition hover:border-[#b75d3c] hover:bg-[#fbe9e3] focus:outline-none focus:ring-2 focus:ring-[#b75d3c] focus:ring-offset-2 dark:border-[#5a3931] dark:bg-[#2a201d] dark:text-[#f0aa98] dark:hover:border-[#b75d3c] dark:hover:bg-[#392721]">
                        <svg aria-hidden="true" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <path d="M16 17l5-5-5-5" />
                            <path d="M21 12H9" />
                        </svg>
                        <span>Keluar dari akun</span>
                    </button>
                </form>
            </div>
        </aside>
        <div class="min-h-screen lg:pl-[278px]">
            <header
                class="sticky top-0 z-30 border-b border-[#dde0d6] bg-[#f8f7f1]/90 backdrop-blur-xl dark:border-[#364339] dark:bg-[#121915]/90">
                <div class="flex min-h-[88px] items-center justify-between gap-4 px-4 sm:px-7 lg:px-10">
                    <div class="flex min-w-0 items-center gap-3">
                        <button type="button" @click="sidebarOpen = true"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-[#dde0d6] text-[#1a5b41] lg:hidden dark:border-[#364339] dark:text-[#a8ddb8]"
                            aria-label="Buka menu">☰</button>
                        <div class="min-w-0">
                            @isset($header)
                                {{ $header }}
                            @else
                                <p
                                    class="font-editorial text-lg font-extrabold tracking-[-.04em] text-[#192b23] dark:text-[#ebefe5]">
                                    {{ $isAdmin ? 'Workspace redaksi' : 'Ruang anggota' }}</p>
                                <p class="mt-1 text-xs text-[#66746a] dark:text-[#a3b1a5]">Portal NU · Ranting Pekuncen</p>
                            @endisset
                        </div>
                    </div>
                    <div class="flex items-center gap-2"><span
                            class="hidden text-[10px] font-bold uppercase tracking-[.12em] text-[#88968a] md:inline">{{ now()->translatedFormat('d M Y') }}</span><x-theme-toggle />
                    </div>
                </div>
            </header>
            <main class="min-h-[calc(100vh-88px)] px-4 py-7 sm:px-7 sm:py-9 lg:px-10 lg:py-10">
                <div class="mx-auto w-full max-w-[1400px]">{{ $slot }}</div>
            </main>
        </div>
    </div>
</body>

</html>
