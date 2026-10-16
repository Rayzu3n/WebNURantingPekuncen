<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[9px] font-extrabold uppercase tracking-[.17em] text-[#b75d3c]">Ruang anggota</p>
            <h2 class="mt-1 font-editorial text-xl font-extrabold tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">Ringkasan saya</h2>
        </div>
    </x-slot>

    <div class="space-y-8">
        <section class="relative overflow-hidden bg-[#1a5b41] px-6 py-8 text-white sm:px-9 sm:py-10 dark:bg-[#183b2a]">
            <div class="relative z-10 max-w-2xl">
                <p class="text-[10px] font-extrabold uppercase tracking-[.17em] text-[#c5e0c4]">Ahlan wa sahlan</p>
                <h1 class="mt-4 font-editorial text-3xl font-extrabold leading-tight tracking-[-.055em] sm:text-4xl">Halo, {{ auth()->user()->name }}.</h1>
                <p class="mt-3 max-w-xl text-sm leading-7 text-white/75">Informasi keanggotaanmu, satu tempat. Perbarui detail profil atau buka kartu anggota digital kapan saja.</p>
            </div>
            <span aria-hidden="true" class="pointer-events-none absolute -bottom-12 right-4 font-editorial text-[9rem] font-extrabold leading-none tracking-[-.1em] text-white/[.06] sm:right-8 sm:text-[13rem]">NU.</span>
        </section>

        <section>
            <div class="mb-4"><p class="portal-kicker">Akun saya</p><h2 class="mt-2 font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5]">Layanan anggota</h2><p class="mt-2 text-sm text-[#66746a] dark:text-[#a3b1a5]">Pilih bagian yang ingin kamu kelola.</p></div>
            <div class="grid gap-4 md:grid-cols-2">
                <a href="{{ route('member.profile') }}" class="group portal-surface p-6 transition hover:-translate-y-1 hover:border-[#1a5b41] sm:p-8">
                    <div class="flex items-start justify-between gap-4"><span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#e4ede2] text-xl text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]">◎</span><x-portal-icon name="chevron-right" class="h-5 w-5 text-[#b75d3c] transition group-hover:translate-x-1" /></div>
                    <p class="mt-6 text-[10px] font-extrabold uppercase tracking-[.15em] text-[#66746a] dark:text-[#a3b1a5]">01 / Data diri</p><h3 class="mt-2 font-editorial text-xl font-extrabold tracking-[-.04em] text-[#192b23] group-hover:text-[#1a5b41] dark:text-[#ebefe5] dark:group-hover:text-[#a8ddb8]">Profil anggota</h3><p class="mt-3 max-w-md text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Periksa dan perbarui informasi keanggotaan agar tetap sesuai.</p><span class="mt-6 inline-flex border-b border-[#1a5b41] pb-1 text-xs font-extrabold text-[#1a5b41] dark:border-[#80ca9d] dark:text-[#a8ddb8]">Buka profil</span>
                </a>
                <a href="{{ route('member.card') }}" class="group portal-surface p-6 transition hover:-translate-y-1 hover:border-[#1a5b41] sm:p-8">
                    <div class="flex items-start justify-between gap-4"><span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#f5e9e0] text-xl text-[#a45134] dark:bg-[#412b22] dark:text-[#e7a68c]">▣</span><span class="text-lg text-[#b75d3c] transition group-hover:translate-x-1">↗</span></div>
                    <p class="mt-6 text-[10px] font-extrabold uppercase tracking-[.15em] text-[#66746a] dark:text-[#a3b1a5]">02 / Identitas</p><h3 class="mt-2 font-editorial text-xl font-extrabold tracking-[-.04em] text-[#192b23] group-hover:text-[#1a5b41] dark:text-[#ebefe5] dark:group-hover:text-[#a8ddb8]">Kartu anggota digital</h3><p class="mt-3 max-w-md text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Tampilkan, verifikasi, dan unduh kartu keanggotaan digitalmu.</p><span class="mt-6 inline-flex border-b border-[#1a5b41] pb-1 text-xs font-extrabold text-[#1a5b41] dark:border-[#80ca9d] dark:text-[#a8ddb8]">Buka kartu</span>
                </a>
            </div>
        </section>
    </div>
</x-app-layout>
