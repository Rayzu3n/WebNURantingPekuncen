<x-public-layout>
    <main class="mx-auto w-full max-w-[1500px] px-4 py-9 sm:px-7 sm:py-12 lg:px-10 lg:py-16">
        <header class="border-b border-[#dde0d6] pb-8 dark:border-[#364339] sm:pb-10">
            <p class="portal-kicker">Agenda • Kebersamaan • Khidmah</p>
            <div class="mt-4 flex flex-col justify-between gap-5 lg:flex-row lg:items-end">
                <div class="max-w-3xl">
                    <h1 class="font-editorial text-4xl font-extrabold leading-[1.02] tracking-[-.065em] text-[#192b23] dark:text-[#ebefe5] sm:text-5xl lg:text-6xl">Kegiatan Ranting</h1>
                    <p class="mt-4 max-w-2xl text-base leading-7 text-[#66746a] dark:text-[#a3b1a5] sm:text-lg">Temukan agenda, pertemuan, dan kegiatan bersama dari lingkungan NU Pekuncen. Arsip kegiatan sebelumnya tetap bisa dibaca kembali.</p>
                </div>
                <span class="text-xs font-extrabold uppercase tracking-[.14em] text-[#66746a] dark:text-[#a3b1a5]">{{ $upcomingEvents->total() }} agenda mendatang</span>
            </div>

            <form method="GET" action="{{ route('events.index') }}" class="mt-7 flex flex-col gap-3 border-t border-[#dde0d6] pt-5 dark:border-[#364339] sm:flex-row sm:items-center">
                <label for="category" class="sr-only">Filter kategori kegiatan</label>
                <select id="category" name="category" class="w-full sm:max-w-xs">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item }}" @selected($category === $item)>{{ $item }}</option>
                    @endforeach
                </select>
                <button class="portal-button" type="submit">Terapkan filter</button>
                @if ($category)
                    <a href="{{ route('events.index') }}" class="text-sm font-bold text-[#1a5b41] dark:text-[#a8ddb8]">Hapus filter</a>
                @endif
            </form>
        </header>

        <section class="py-9 sm:py-12">
            <div class="flex flex-col gap-3 border-b border-[#dde0d6] pb-4 dark:border-[#364339] sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="portal-kicker">Yang akan datang</p>
                    <h2 class="mt-2 font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5] sm:text-3xl">Agenda berikutnya</h2>
                </div>
                <span class="text-xs text-[#66746a] dark:text-[#a3b1a5]">Jadwal dalam waktu lokal</span>
            </div>

            @if ($upcomingEvents->isNotEmpty())
                <div class="mt-7 grid gap-x-7 gap-y-9 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($upcomingEvents as $event)
                        <article class="group flex min-w-0 flex-col">
                            <a href="{{ route('events.show', $event->slug) }}" class="relative block aspect-[16/10] overflow-hidden bg-[#e4e8df] dark:bg-[#27362b]">
                                @if ($event->imageUrl())
                                    <img src="{{ $event->imageUrl() }}" alt="{{ $event->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.035]">
                                @else
                                    <div class="flex h-full flex-col items-center justify-center gap-2 text-[#1a5b41] dark:text-[#a8ddb8]">
                                        <span class="text-4xl font-black">{{ $event->starts_at->format('d') }}</span>
                                        <span class="text-[10px] font-extrabold uppercase tracking-[.16em]">{{ $event->starts_at->translatedFormat('M Y') }}</span>
                                    </div>
                                @endif
                                <span class="absolute left-3 top-3 bg-[#fffef9] px-3 py-1.5 text-[9px] font-extrabold uppercase tracking-[.13em] text-[#1a5b41]">{{ $event->category ?: 'Kegiatan NU' }}</span>
                            </a>
                            <div class="flex flex-1 flex-col pt-4">
                                <div class="flex flex-wrap gap-x-3 gap-y-1 text-[10px] font-extrabold uppercase tracking-[.12em] text-[#1a5b41] dark:text-[#a8ddb8]">
                                    <time datetime="{{ $event->starts_at->toIso8601String() }}">{{ $event->starts_at->translatedFormat('l, d F Y') }}</time>
                                    <span class="text-[#b75d3c]">/</span>
                                    <span>{{ $event->starts_at->format('H:i') }} WIB</span>
                                </div>
                                <h3 class="mt-3 font-editorial text-xl font-extrabold leading-tight tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">
                                    <a href="{{ route('events.show', $event->slug) }}" class="transition-colors hover:text-[#1a5b41] dark:hover:text-[#80ca9d]">{{ $event->title }}</a>
                                </h3>
                                @if ($event->excerpt)
                                    <p class="mt-3 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">{{ \Illuminate\Support\Str::limit($event->excerpt, 150) }}</p>
                                @endif
                                @if ($event->location)
                                    <p class="mt-4 flex items-start gap-2 text-xs font-semibold text-[#66746a] dark:text-[#a3b1a5]"><span aria-hidden="true">⌖</span><span>{{ $event->location }}</span></p>
                                @endif
                                <a href="{{ route('events.show', $event->slug) }}" class="mt-auto inline-flex items-center gap-2 border-t border-[#dde0d6] pt-4 mt-5 text-sm font-extrabold text-[#1a5b41] dark:border-[#364339] dark:text-[#a8ddb8]">Detail kegiatan <span>↗</span></a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-9">{{ $upcomingEvents->links() }}</div>
            @else
                <div class="mt-7 border border-dashed border-[#c6cec0] px-5 py-12 text-center dark:border-[#465648]">
                    <p class="font-editorial text-xl font-extrabold text-[#192b23] dark:text-[#ebefe5]">Belum ada agenda mendatang</p>
                    <p class="mt-2 text-sm text-[#66746a] dark:text-[#a3b1a5]">Silakan periksa kembali nanti untuk informasi kegiatan terbaru.</p>
                </div>
            @endif
        </section>

        <section class="border-t-2 border-[#192b23] py-9 dark:border-[#ebefe5] sm:py-12">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="portal-kicker">Rekam jejak bersama</p>
                    <h2 class="mt-3 font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5] sm:text-3xl">Arsip kegiatan</h2>
                </div>
                <span class="text-xs text-[#66746a] dark:text-[#a3b1a5]">{{ $archivedEvents->total() }} kegiatan selesai</span>
            </div>

            @if ($archivedEvents->isNotEmpty())
                <div class="mt-6 divide-y divide-[#dde0d6] dark:divide-[#364339]">
                    @foreach ($archivedEvents as $event)
                        <article class="grid gap-3 py-5 sm:grid-cols-[140px_minmax(0,1fr)_auto] sm:items-center sm:gap-6">
                            <time datetime="{{ $event->starts_at->toIso8601String() }}" class="text-xs font-extrabold uppercase tracking-[.1em] text-[#b75d3c]">{{ $event->starts_at->translatedFormat('d M Y') }}</time>
                            <div class="min-w-0">
                                <h3 class="font-editorial text-lg font-extrabold tracking-[-.035em] text-[#192b23] dark:text-[#ebefe5]"><a href="{{ route('events.show', $event->slug) }}" class="hover:text-[#1a5b41] dark:hover:text-[#a8ddb8]">{{ $event->title }}</a></h3>
                                <p class="mt-1 text-sm text-[#66746a] dark:text-[#a3b1a5]">{{ $event->category ?: 'Kegiatan NU' }}@if ($event->location) · {{ $event->location }}@endif</p>
                            </div>
                            <a href="{{ route('events.show', $event->slug) }}" class="text-xs font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Buka arsip ↗</a>
                        </article>
                    @endforeach
                </div>
                <div class="mt-6">{{ $archivedEvents->links() }}</div>
            @else
                <p class="mt-6 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Arsip kegiatan akan muncul di sini setelah ada acara yang selesai dipublikasikan.</p>
            @endif
        </section>
    </main>
</x-public-layout>
