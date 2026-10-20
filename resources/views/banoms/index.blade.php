<x-public-layout>
    <main class="mx-auto w-full max-w-[1500px] px-4 py-10 sm:px-7 sm:py-14 lg:px-10 lg:py-16">
        <section class="grid gap-8 border-b border-[#dde0d6] pb-10 dark:border-[#364339] sm:pb-14 lg:grid-cols-[1.2fr_.8fr] lg:items-end lg:gap-16">
            <div>
                <p class="portal-kicker">Organisasi · Khidmah · Kaderisasi</p>
                <h1 class="mt-5 max-w-4xl font-editorial text-4xl font-extrabold leading-[1.04] tracking-[-.065em] text-[#192b23] dark:text-[#ebefe5] sm:text-5xl lg:text-6xl">
                    Badan Otonom &amp;<br><span class="text-[#1a5b41] dark:text-[#80ca9d]">kepengurusan.</span>
                </h1>
            </div>
            <div class="max-w-xl lg:justify-self-end">
                <div class="mb-5 h-px w-20 bg-[#b75d3c]"></div>
                <p class="text-base leading-7 text-[#66746a] dark:text-[#a3b1a5] sm:text-lg sm:leading-8">
                    Kenali badan otonom dan susunan pengurus yang berkhidmat bersama NU Ranting Pekuncen.
                    Informasi ditampilkan sesuai data yang dimasukkan oleh pengelola organisasi.
                </p>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.banoms.index') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">
                            Kelola data Banom <x-portal-icon name="users" class="h-4 w-4" />
                        </a>
                    @endif
                @endauth
            </div>
        </section>

        <section class="py-8 sm:py-10">
            <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <p class="portal-kicker">Direktori organisasi</p>
                    <h2 class="mt-3 font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5] sm:text-3xl">Banom dan susunan pengurus</h2>
                </div>
                <p class="text-sm text-[#66746a] dark:text-[#a3b1a5]">{{ $banoms->count() }} organisasi ditampilkan</p>
            </div>

            @forelse ($banoms as $banom)
                <article id="{{ $banom->slug }}" class="mb-6 scroll-mt-28 border border-[#dde0d6] bg-[#fffef9] dark:border-[#364339] dark:bg-[#19221c]">
                    <div class="grid gap-0 lg:grid-cols-[minmax(0,1fr)_minmax(280px,.72fr)]">
                        <div class="p-5 sm:p-7 lg:p-8">
                            <p class="text-[10px] font-extrabold uppercase tracking-[.15em] text-[#1a5b41] dark:text-[#a8ddb8]">{{ $banom->category }}</p>
                            <h3 class="mt-3 font-editorial text-2xl font-extrabold leading-tight tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-3xl">{{ $banom->name }}</h3>
                            @if ($banom->title)
                                <p class="mt-2 text-sm font-semibold text-[#66746a] dark:text-[#a3b1a5]">{{ $banom->title }}</p>
                            @endif
                            @if ($banom->motto)
                                <p class="mt-4 border-l-2 border-[#b75d3c] pl-3 text-sm font-semibold leading-6 text-[#405347] dark:text-[#c5d2c4]">{{ $banom->motto }}</p>
                            @endif
                            <p class="mt-4 whitespace-pre-line text-sm leading-7 text-[#66746a] dark:text-[#a3b1a5]">{{ $banom->description }}</p>

                            @if ($banom->term || $banom->coverage || $banom->legal_status)
                                <dl class="mt-6 grid gap-3 border-t border-[#dde0d6] pt-5 dark:border-[#364339] sm:grid-cols-2">
                                    @if ($banom->term)
                                        <div><dt class="text-[10px] font-extrabold uppercase tracking-[.12em] text-[#88968a]">Masa khidmat</dt><dd class="mt-1 text-sm font-semibold text-[#192b23] dark:text-[#ebefe5]">{{ $banom->term }}</dd></div>
                                    @endif
                                    @if ($banom->coverage)
                                        <div><dt class="text-[10px] font-extrabold uppercase tracking-[.12em] text-[#88968a]">Cakupan</dt><dd class="mt-1 text-sm font-semibold text-[#192b23] dark:text-[#ebefe5]">{{ $banom->coverage }}</dd></div>
                                    @endif
                                    @if ($banom->legal_status)
                                        <div class="sm:col-span-2"><dt class="text-[10px] font-extrabold uppercase tracking-[.12em] text-[#88968a]">Legalitas / SK</dt><dd class="mt-1 text-sm font-semibold text-[#192b23] dark:text-[#ebefe5]">{{ $banom->legal_status }}</dd></div>
                                    @endif
                                </dl>
                            @endif
                            @if ($banom->note)
                                <p class="mt-5 border-t border-[#dde0d6] pt-4 text-xs leading-6 text-[#66746a] dark:border-[#364339] dark:text-[#a3b1a5]">{{ $banom->note }}</p>
                            @endif
                        </div>

                        <aside class="border-t border-[#dde0d6] bg-[#f4f4ec] p-5 dark:border-[#364339] dark:bg-[#151d18] sm:p-7 lg:border-l lg:border-t-0 lg:p-8">
                            <div class="flex items-center justify-between gap-3 border-b border-[#d6dbd0] pb-4 dark:border-[#364339]">
                                <div>
                                    <p class="text-[10px] font-extrabold uppercase tracking-[.14em] text-[#b75d3c]">Kepengurusan</p>
                                    <h4 class="mt-1 font-editorial text-lg font-extrabold text-[#192b23] dark:text-[#ebefe5]">Susunan pengurus</h4>
                                </div>
                                <span class="text-xs font-semibold text-[#66746a] dark:text-[#a3b1a5]">{{ $banom->members->count() }} orang</span>
                            </div>

                            @if ($banom->members->isNotEmpty())
                                <dl class="divide-y divide-[#d6dbd0] dark:divide-[#364339]">
                                    @foreach ($banom->members as $member)
                                        <div class="py-3">
                                            <dt class="text-[10px] font-extrabold uppercase tracking-[.1em] text-[#66746a] dark:text-[#a3b1a5]">{{ $member->position }}</dt>
                                            <dd class="mt-1 text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">{{ $member->name }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            @else
                                <p class="py-6 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Susunan pengurus belum dicantumkan.</p>
                            @endif
                        </aside>
                    </div>
                </article>
            @empty
                <div class="border border-dashed border-[#c6cec0] px-5 py-14 text-center dark:border-[#465648]">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#e4ede2] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]">
                        <x-portal-icon name="users" class="h-5 w-5" />
                    </div>
                    <h3 class="mt-4 font-editorial text-xl font-extrabold text-[#192b23] dark:text-[#ebefe5]">Data Banom sedang disiapkan</h3>
                    <p class="mx-auto mt-2 max-w-lg text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Informasi organisasi akan ditampilkan setelah pengelola memasukkan data resmi yang sudah dikonfirmasi.</p>
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.banoms.create') }}" class="portal-button mt-5">Tambah data Banom</a>
                        @endif
                    @endauth
                </div>
            @endforelse
        </section>
    </main>
</x-public-layout>
