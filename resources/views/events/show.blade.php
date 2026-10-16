<x-public-layout :title="$event->title . ' - Portal NU Pekuncen'">
    <main class="mx-auto w-full max-w-[1500px] px-4 py-8 sm:px-7 sm:py-12 lg:px-10 lg:py-16">
        <nav aria-label="Breadcrumb" class="mb-8 text-xs font-bold text-[#66746a] dark:text-[#a3b1a5]">
            <a href="{{ route('home') }}" class="hover:text-[#1a5b41] dark:hover:text-[#a8ddb8]">Beranda</a>
            <span class="mx-2 text-[#b75d3c]">/</span>
            <a href="{{ route('events.index') }}" class="hover:text-[#1a5b41] dark:hover:text-[#a8ddb8]">Kegiatan</a>
            <span class="mx-2 text-[#b75d3c]">/</span>
            <span>{{ $event->category ?: 'Agenda' }}</span>
        </nav>

        <article>
            <header class="mx-auto max-w-5xl">
                <p class="portal-kicker">{{ $event->category ?: 'Kegiatan Ranting' }}</p>
                <h1 class="mt-4 font-editorial text-4xl font-extrabold leading-[1.02] tracking-[-.065em] text-[#192b23] dark:text-[#ebefe5] sm:text-5xl lg:text-7xl">{{ $event->title }}</h1>
                @if ($event->excerpt)
                    <p class="mt-5 max-w-3xl text-lg leading-8 text-[#66746a] dark:text-[#a3b1a5] sm:text-xl">{{ $event->excerpt }}</p>
                @endif

                <div class="mt-7 grid gap-4 border-y border-[#dde0d6] py-5 dark:border-[#364339] sm:grid-cols-2">
                    <div class="flex gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center bg-[#e4ede2] text-lg text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]" aria-hidden="true">◷</span>
                        <div>
                            <p class="text-[10px] font-extrabold uppercase tracking-[.14em] text-[#66746a] dark:text-[#a3b1a5]">Waktu kegiatan</p>
                            <p class="mt-1 text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">{{ $event->starts_at->translatedFormat('l, d F Y') }}</p>
                            <p class="mt-1 text-sm text-[#66746a] dark:text-[#a3b1a5]">{{ $event->starts_at->format('H:i') }} WIB@if ($event->ends_at) · selesai {{ $event->ends_at->translatedFormat('d M Y H:i') }}@endif</p>
                        </div>
                    </div>
                    @if ($event->location)
                        <div class="flex gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center bg-[#f3e6dd] text-lg text-[#a45134] dark:bg-[#412b22] dark:text-[#e7a68c]" aria-hidden="true">⌖</span>
                            <div>
                                <p class="text-[10px] font-extrabold uppercase tracking-[.14em] text-[#66746a] dark:text-[#a3b1a5]">Lokasi</p>
                                <p class="mt-1 text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">{{ $event->location }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </header>

            @if ($event->imageUrl())
                <figure class="mx-auto mt-8 max-w-6xl overflow-hidden bg-[#e4e8df] dark:bg-[#27362b]">
                    <img src="{{ $event->imageUrl() }}" alt="{{ $event->title }}" class="max-h-[720px] w-full object-cover">
                </figure>
            @endif

            <div class="mx-auto mt-10 grid max-w-6xl gap-8 lg:grid-cols-[minmax(0,1fr)_240px] lg:gap-16">
                <div class="article-copy max-w-3xl whitespace-pre-line break-words text-base leading-8 text-[#33473a] dark:text-[#d0dbcf] sm:text-lg sm:leading-9">{{ $event->description }}</div>
                <aside class="h-fit border-t border-[#dde0d6] pt-5 dark:border-[#364339] lg:border-l lg:border-t-0 lg:pl-6 lg:pt-0">
                    <p class="portal-kicker">Jelajahi lagi</p>
                    <p class="mt-4 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Lihat agenda mendatang dan dokumentasi kegiatan yang sudah selesai.</p>
                    <a href="{{ route('events.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Semua kegiatan ↗</a>
                </aside>
            </div>
        </article>

        @if ($relatedEvents->isNotEmpty())
            <section class="mt-16 border-t-2 border-[#192b23] pt-8 dark:border-[#ebefe5]">
                <p class="portal-kicker">Agenda terkait</p>
                <h2 class="mt-3 font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5] sm:text-3xl">Kegiatan lainnya</h2>
                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    @foreach ($relatedEvents as $related)
                        <article class="border-t border-[#dde0d6] pt-4 dark:border-[#364339]">
                            <p class="text-[10px] font-extrabold uppercase tracking-[.12em] text-[#b75d3c]">{{ $related->starts_at->translatedFormat('d M Y') }} · {{ $related->category ?: 'Agenda' }}</p>
                            <h3 class="mt-2 font-editorial text-lg font-extrabold leading-tight text-[#192b23] dark:text-[#ebefe5]"><a href="{{ route('events.show', $related->slug) }}" class="hover:text-[#1a5b41] dark:hover:text-[#a8ddb8]">{{ $related->title }}</a></h3>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
</x-public-layout>
