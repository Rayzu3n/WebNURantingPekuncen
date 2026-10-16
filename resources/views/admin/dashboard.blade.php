<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[9px] font-extrabold uppercase tracking-[.17em] text-[#b75d3c]">Workspace redaksi</p>
            <h2 class="mt-1 font-editorial text-xl font-extrabold tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">Ringkasan dashboard</h2>
        </div>
    </x-slot>

    <div class="space-y-9">
        <section class="relative overflow-hidden bg-[#1a5b41] px-6 py-8 text-white sm:px-9 sm:py-10 dark:bg-[#183b2a]">
            <div class="relative z-10 max-w-3xl">
                <p class="text-[10px] font-extrabold uppercase tracking-[.17em] text-[#c5e0c4]">Senang melihatmu kembali</p>
                <h1 class="mt-4 font-editorial text-3xl font-extrabold leading-tight tracking-[-.055em] sm:text-4xl">Selamat datang, {{ auth()->user()->name }}.</h1>
                <p class="mt-3 max-w-xl text-sm leading-7 text-white/75">Kelola kabar, rapikan kategori, dan jaga informasi anggota tetap terorganisasi dari satu tempat.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('admin.news.create') }}" class="inline-flex min-h-11 items-center gap-2 rounded-full bg-[#fffef9] px-5 text-sm font-extrabold text-[#1a5b41] transition hover:bg-[#e7eee5]">Tulis berita <span>↗</span></a>
                    <a href="{{ route('admin.news.index') }}" class="inline-flex min-h-11 items-center rounded-full border border-white/35 px-5 text-sm font-bold text-white transition hover:bg-white/10">Kelola berita</a>
                </div>
            </div>
            <span aria-hidden="true" class="pointer-events-none absolute -bottom-12 right-4 font-editorial text-[10rem] font-extrabold leading-none tracking-[-.1em] text-white/[.06] sm:right-10 sm:text-[15rem]">NU.</span>
        </section>

        <section>
            <div class="mb-4 flex items-end justify-between gap-4">
                <div>
                    <p class="portal-kicker">Sekilas portal</p>
                    <h2 class="mt-2 font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5]">Angka hari ini</h2>
                </div>
                <p class="hidden text-xs text-[#66746a] dark:text-[#a3b1a5] sm:block">Ringkasan konten dan komunitas</p>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
                <article class="portal-surface p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div><p class="text-xs font-bold text-[#66746a] dark:text-[#a3b1a5]">Total berita</p><p class="mt-3 font-editorial text-4xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5]">{{ $newsCount }}</p></div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e4ede2] text-lg text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]">▤</span>
                    </div>
                    <a href="{{ route('admin.news.index') }}" class="mt-5 inline-flex items-center gap-2 text-xs font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Buka daftar berita ↗</a>
                </article>
                <article class="portal-surface p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div><p class="text-xs font-bold text-[#66746a] dark:text-[#a3b1a5]">Anggota terdaftar</p><p class="mt-3 font-editorial text-4xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5]">{{ $memberCount }}</p></div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#f5e9e0] text-lg text-[#a45134] dark:bg-[#412b22] dark:text-[#e7a68c]">♧</span>
                    </div>
                    <a href="{{ route('admin.members.index') }}" class="mt-5 inline-flex items-center gap-2 text-xs font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Buka daftar anggota ↗</a>
                </article>
                <article class="portal-surface p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div><p class="text-xs font-bold text-[#66746a] dark:text-[#a3b1a5]">Kategori berita</p><p class="mt-3 font-editorial text-4xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5]">{{ $categoryCount }}</p></div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e7eee5] text-lg text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]">▦</span>
                    </div>
                    <a href="{{ route('admin.categories.index') }}" class="mt-5 inline-flex items-center gap-2 text-xs font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Buka kategori ↗</a>
                </article>
                <article class="portal-surface p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div><p class="text-xs font-bold text-[#66746a] dark:text-[#a3b1a5]">Agenda aktif</p><p class="mt-3 font-editorial text-4xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5]">{{ $upcomingEventCount }}</p></div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#f5e9e0] text-lg text-[#a45134] dark:bg-[#412b22] dark:text-[#e7a68c]">◷</span>
                    </div>
                    <a href="{{ route('admin.events.index') }}" class="mt-5 inline-flex items-center gap-2 text-xs font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Kelola kegiatan ↗</a>
                </article>
                <article class="portal-surface p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div><p class="text-xs font-bold text-[#66746a] dark:text-[#a3b1a5]">Pesan belum dibaca</p><p class="mt-3 font-editorial text-4xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5]">{{ $unreadMessageCount }}</p></div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#f5e9e0] text-lg text-[#a45134] dark:bg-[#412b22] dark:text-[#e7a68c]">✉</span>
                    </div>
                    <a href="{{ route('admin.messages.index', ['status' => 'new']) }}" class="mt-5 inline-flex items-center gap-2 text-xs font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Buka inbox ↗</a>
                </article>
            </div>
        </section>

        <section>
            <div class="mb-4"><p class="portal-kicker">Akses cepat</p><h2 class="mt-2 font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5]">Mulai dari sini</h2></div>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                <a href="{{ route('admin.news.index') }}" class="group portal-surface p-5 transition hover:-translate-y-1 hover:border-[#1a5b41] sm:p-6">
                    <p class="text-[10px] font-extrabold uppercase tracking-[.15em] text-[#66746a] dark:text-[#a3b1a5]">01 / Publikasi</p><h3 class="mt-4 font-editorial text-lg font-extrabold tracking-[-.04em] text-[#192b23] group-hover:text-[#1a5b41] dark:text-[#ebefe5] dark:group-hover:text-[#a8ddb8]">Berita</h3><p class="mt-2 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Susun, perbarui, dan terbitkan kabar terbaru.</p><span class="mt-5 inline-flex text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Buka bagian ↗</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="group portal-surface p-5 transition hover:-translate-y-1 hover:border-[#1a5b41] sm:p-6">
                    <p class="text-[10px] font-extrabold uppercase tracking-[.15em] text-[#66746a] dark:text-[#a3b1a5]">02 / Organisasi</p><h3 class="mt-4 font-editorial text-lg font-extrabold tracking-[-.04em] text-[#192b23] group-hover:text-[#1a5b41] dark:text-[#ebefe5] dark:group-hover:text-[#a8ddb8]">Kategori</h3><p class="mt-2 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Buat struktur topik agar informasi mudah ditelusuri.</p><span class="mt-5 inline-flex text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Buka bagian ↗</span>
                </a>
                <a href="{{ route('admin.members.index') }}" class="group portal-surface p-5 transition hover:-translate-y-1 hover:border-[#1a5b41] sm:p-6">
                    <p class="text-[10px] font-extrabold uppercase tracking-[.15em] text-[#66746a] dark:text-[#a3b1a5]">03 / Komunitas</p><h3 class="mt-4 font-editorial text-lg font-extrabold tracking-[-.04em] text-[#192b23] group-hover:text-[#1a5b41] dark:text-[#ebefe5] dark:group-hover:text-[#a8ddb8]">Anggota</h3><p class="mt-2 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Kelola profil dan data keanggotaan portal.</p><span class="mt-5 inline-flex text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Buka bagian ↗</span>
                </a>
                <a href="{{ route('admin.events.index') }}" class="group portal-surface p-5 transition hover:-translate-y-1 hover:border-[#1a5b41] sm:p-6">
                    <p class="text-[10px] font-extrabold uppercase tracking-[.15em] text-[#66746a] dark:text-[#a3b1a5]">04 / Komunitas</p><h3 class="mt-4 font-editorial text-lg font-extrabold tracking-[-.04em] text-[#192b23] group-hover:text-[#1a5b41] dark:text-[#ebefe5] dark:group-hover:text-[#a8ddb8]">Kegiatan</h3><p class="mt-2 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Susun agenda mendatang dan simpan arsip acara.</p><span class="mt-5 inline-flex text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Kelola agenda ↗</span>
                </a>
                <a href="{{ route('admin.messages.index') }}" class="group portal-surface p-5 transition hover:-translate-y-1 hover:border-[#1a5b41] sm:p-6">
                    <p class="text-[10px] font-extrabold uppercase tracking-[.15em] text-[#66746a] dark:text-[#a3b1a5]">05 / Komunikasi</p><h3 class="mt-4 font-editorial text-lg font-extrabold tracking-[-.04em] text-[#192b23] group-hover:text-[#1a5b41] dark:text-[#ebefe5] dark:group-hover:text-[#a8ddb8]">Inbox kontak</h3><p class="mt-2 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Baca pesan dan catat tindak lanjut dari warga.</p><span class="mt-5 inline-flex text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Buka inbox ↗</span>
                </a>
            </div>
        </section>
    </div>
</x-app-layout>
