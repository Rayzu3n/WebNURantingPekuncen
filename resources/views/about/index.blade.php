<x-public-layout :title="($profile?->name ?? 'Tentang Kami') . ' - Portal NU Pekuncen'">
    <main class="mx-auto w-full max-w-[1500px] px-4 py-10 sm:px-7 sm:py-14 lg:px-10 lg:py-18">
        <section
            class="relative overflow-hidden bg-[#1a5b41] px-6 py-10 text-white sm:px-10 sm:py-14 lg:px-14 lg:py-20 dark:bg-[#183b2a]">
            <div class="relative z-10 max-w-4xl">
                <p class="text-[10px] font-extrabold uppercase tracking-[.2em] text-[#c5e0c4]">Tentang organisasi</p>
                <h1
                    class="mt-5 font-editorial text-4xl font-extrabold leading-[1.02] tracking-[-.065em] sm:text-5xl lg:text-7xl">
                    {{ $profile?->name ?? 'NU Ranting Pekuncen' }}</h1>
                @if (filled($profile?->tagline))
                    <p class="mt-5 max-w-3xl text-base leading-8 text-white/80 sm:text-xl">{{ $profile->tagline }}</p>
                @else
                    <p class="mt-5 max-w-3xl text-base leading-8 text-white/80 sm:text-xl">Mengenal organisasi, arah
                        gerak, dan ruang kontribusi untuk warga.</p>
                @endif
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('events.index') }}"
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-full bg-[#fffef9] px-5 text-sm font-extrabold text-[#1a5b41] transition hover:bg-[#e7eee5]">
                        <span>Lihat kegiatan</span>
                        <x-portal-icon name="calendar" class="h-4 w-4" />
                    </a>
                    <a href="{{ route('contact.index') }}"
                        class="inline-flex min-h-11 items-center justify-center rounded-full border border-white/40 px-5 text-sm font-bold text-white transition hover:bg-white/10">Hubungi
                        kami</a>
                </div>
            </div>
            <span aria-hidden="true"
                class="pointer-events-none absolute -bottom-12 right-2 font-editorial text-[10rem] font-extrabold leading-none tracking-[-.1em] text-white/[.06] sm:right-8 sm:text-[16rem]">NU.</span>
        </section>

        @if (
            !$profile ||
                (!filled($profile->history) &&
                    !filled($profile->vision) &&
                    !filled($profile->mission) &&
                    !filled($profile->structure) &&
                    !filled($profile->programs)))
            <div
                class="mt-8 border border-[#dde0d6] bg-[#fffef9] px-5 py-6 text-sm leading-7 text-[#66746a] dark:border-[#364339] dark:bg-[#19221c] dark:text-[#a3b1a5]">
                Profil organisasi sedang disiapkan. Informasi akan ditampilkan setelah pengelola melengkapi konten
                halaman ini.
            </div>
        @endif

        @if (filled($profile?->history))
            <section
                class="grid gap-6 border-b border-[#dde0d6] py-10 dark:border-[#364339] sm:py-14 lg:grid-cols-[.7fr_1.3fr] lg:gap-16">
                <div>
                    <p class="portal-kicker">Latar belakang</p>
                    <h2
                        class="mt-3 font-editorial text-3xl font-extrabold tracking-[-.055em] text-[#192b23] dark:text-[#ebefe5] sm:text-4xl">
                        Sejarah singkat</h2>
                </div>
                <div class="whitespace-pre-line break-words text-base leading-8 text-[#526156] dark:text-[#c2cdc1]">
                    {{ $profile->history }}</div>
            </section>
        @endif

        <div class="grid gap-5 py-8 sm:grid-cols-2 sm:py-10">
            @if (filled($profile?->vision))
                <section
                    class="border border-[#dde0d6] bg-[#fffef9] p-6 dark:border-[#364339] dark:bg-[#19221c] sm:p-8">
                    <p class="portal-kicker">Arah bersama</p>
                    <h2
                        class="mt-3 font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5]">
                        Visi</h2>
                    <p
                        class="mt-4 whitespace-pre-line break-words text-sm leading-7 text-[#526156] dark:text-[#c2cdc1]">
                        {{ $profile->vision }}</p>
                </section>
            @endif
            @if (filled($profile?->mission))
                <section
                    class="border border-[#dde0d6] bg-[#fffef9] p-6 dark:border-[#364339] dark:bg-[#19221c] sm:p-8">
                    <p class="portal-kicker">Langkah nyata</p>
                    <h2
                        class="mt-3 font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5]">
                        Misi</h2>
                    <div class="whitespace-pre-line break-words text-sm leading-7 text-[#526156] dark:text-[#c2cdc1]">
                        {{ $profile->mission }}</div>
                </section>
            @endif
        </div>

        @if (filled($profile?->structure) || filled($profile?->programs))
            <section
                class="grid gap-8 border-t border-[#dde0d6] py-10 dark:border-[#364339] sm:py-14 lg:grid-cols-2 lg:gap-16">
                @if (filled($profile?->structure))
                    <div>
                        <p class="portal-kicker">Pengelola dan bagian</p>
                        <h2
                            class="mt-3 font-editorial text-3xl font-extrabold tracking-[-.055em] text-[#192b23] dark:text-[#ebefe5]">
                            Struktur organisasi</h2>
                        <div
                            class="mt-5 whitespace-pre-line break-words border-l-2 border-[#b75d3c] pl-5 text-sm leading-8 text-[#526156] dark:text-[#c2cdc1]">
                            {{ $profile->structure }}</div>
                    </div>
                @endif
                @if (filled($profile?->programs))
                    <div>
                        <p class="portal-kicker">Fokus kegiatan</p>
                        <h2
                            class="mt-3 font-editorial text-3xl font-extrabold tracking-[-.055em] text-[#192b23] dark:text-[#ebefe5]">
                            Program dan kegiatan</h2>
                        <div
                            class="mt-5 whitespace-pre-line break-words text-sm leading-8 text-[#526156] dark:text-[#c2cdc1]">
                            {{ $profile->programs }}</div>
                        <a href="{{ route('events.index') }}"
                            class="mt-5 inline-flex items-center gap-2 text-sm font-extrabold text-[#1a5b41] hover:underline dark:text-[#a8ddb8]">
                            <span>Jelajahi agenda kegiatan</span>
                            <x-portal-icon name="calendar" class="h-4 w-4" />
                        </a>
                    </div>
                @endif
            </section>
        @endif

        @if (filled($profile?->address) ||
                filled($profile?->contact_email) ||
                filled($profile?->contact_phone) ||
                filled($profile?->website_url) ||
                filled($profile?->facebook_url) ||
                filled($profile?->instagram_url))
            <section class="border-t-2 border-[#192b23] py-10 dark:border-[#ebefe5] sm:py-14">
                <div class="grid gap-8 lg:grid-cols-[.7fr_1.3fr] lg:gap-16">
                    <div>
                        <p class="portal-kicker">Tetap terhubung</p>
                        <h2
                            class="mt-3 font-editorial text-3xl font-extrabold tracking-[-.055em] text-[#192b23] dark:text-[#ebefe5] sm:text-4xl">
                            Informasi kontak</h2>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        @if (filled($profile?->address))
                            <div>
                                <p
                                    class="text-[10px] font-extrabold uppercase tracking-[.14em] text-[#66746a] dark:text-[#a3b1a5]">
                                    Alamat</p>
                                <p
                                    class="mt-2 whitespace-pre-line break-words text-sm leading-7 text-[#192b23] dark:text-[#ebefe5]">
                                    {{ $profile->address }}</p>
                            </div>
                        @endif
                        @if (filled($profile?->contact_email))
                            <div>
                                <p
                                    class="text-[10px] font-extrabold uppercase tracking-[.14em] text-[#66746a] dark:text-[#a3b1a5]">
                                    Email</p><a href="mailto:{{ $profile->contact_email }}"
                                    class="mt-2 inline-block break-all text-sm font-semibold text-[#1a5b41] hover:underline dark:text-[#a8ddb8]">{{ $profile->contact_email }}</a>
                            </div>
                        @endif
                        @if (filled($profile?->contact_phone))
                            <div>
                                <p
                                    class="text-[10px] font-extrabold uppercase tracking-[.14em] text-[#66746a] dark:text-[#a3b1a5]">
                                    Telepon</p><a
                                    href="tel:{{ preg_replace('/[^0-9+]/', '', $profile->contact_phone) }}"
                                    class="mt-2 inline-block text-sm font-semibold text-[#1a5b41] hover:underline dark:text-[#a8ddb8]">{{ $profile->contact_phone }}</a>
                            </div>
                        @endif
                        @if (filled($profile?->website_url))
                            <div>
                                <p
                                    class="text-[10px] font-extrabold uppercase tracking-[.14em] text-[#66746a] dark:text-[#a3b1a5]">
                                    Website</p><a href="{{ $profile->website_url }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="mt-2 inline-block break-all text-sm font-semibold text-[#1a5b41] hover:underline dark:text-[#a8ddb8]">{{ $profile->website_url }}</a>
                            </div>
                        @endif
                        @if (filled($profile?->facebook_url) || filled($profile?->instagram_url))
                            <div class="sm:col-span-2">
                                <p
                                    class="text-[10px] font-extrabold uppercase tracking-[.14em] text-[#66746a] dark:text-[#a3b1a5]">
                                    Media sosial</p>
                                <div
                                    class="mt-2 flex flex-wrap gap-4 text-sm font-bold text-[#1a5b41] dark:text-[#a8ddb8]">
                                    @if (filled($profile?->facebook_url))
                                        <a href="{{ $profile->facebook_url }}" target="_blank"
                                            rel="noopener noreferrer" class="inline-flex items-center gap-1 hover:underline">
                                            <span>Facebook</span>
                                            <x-portal-icon name="external-link" class="h-3.5 w-3.5" />
                                        </a>
                                    @endif
                                    @if (filled($profile?->instagram_url))
                                        <a href="{{ $profile->instagram_url }}" target="_blank"
                                            rel="noopener noreferrer" class="inline-flex items-center gap-1 hover:underline">
                                            <span>Instagram</span>
                                            <x-portal-icon name="external-link" class="h-3.5 w-3.5" />
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif
    </main>
</x-public-layout>
