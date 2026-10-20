<x-public-layout>
    @php($tickerNews = $featuredNews ?? $latestNews->first())
    <div class="border-b border-[#dde0d6] bg-[#f0efe7] dark:border-[#364339] dark:bg-[#1b251e]">
        <div class="mx-auto flex max-w-[1500px] items-center gap-3 px-4 py-3 sm:px-7 lg:px-10">
            <span class="shrink-0 bg-[#b75d3c] px-2.5 py-1 text-[9px] font-extrabold uppercase tracking-[.16em] text-white">Warta</span>
            @if ($tickerNews)
                <a href="{{ route('news.show', $tickerNews->slug) }}" class="min-w-0 flex-1 truncate text-sm font-semibold text-[#33473a] transition hover:text-[#1a5b41] dark:text-[#d9e2d5] dark:hover:text-[#a8ddb8]">{{ $tickerNews->title }}</a>
            @else
                <span class="min-w-0 flex-1 truncate text-sm font-semibold text-[#66746a] dark:text-[#a3b1a5]">Kabar lokal dari lingkungan Pekuncen.</span>
            @endif
            <span class="hidden text-[10px] font-bold uppercase tracking-[.12em] text-[#66746a] dark:text-[#a3b1a5] sm:block">Edisi {{ now()->format('d.m.Y') }}</span>
        </div>
    </div>

    <main class="mx-auto w-full max-w-[1500px] px-4 sm:px-7 lg:px-10">
        <section class="grid gap-8 border-b border-[#dde0d6] py-10 dark:border-[#364339] sm:py-14 lg:grid-cols-[1.2fr_.8fr] lg:items-end lg:gap-16 lg:py-20">
            <div>
                <p class="portal-kicker">Nahdlatul Ulama · Ranting Pekuncen</p>
                <h1 class="mt-5 max-w-4xl font-editorial text-5xl font-extrabold leading-[.98] tracking-[-.075em] text-[#192b23] dark:text-[#ebefe5] sm:text-6xl lg:text-7xl xl:text-[5.9rem]">
                    Merawat tradisi,<br><span class="text-[#1a5b41] dark:text-[#80ca9d]">menguatkan khidmah.</span>
                </h1>
            </div>
            <div class="max-w-xl lg:justify-self-end">
                <div class="mb-5 h-px w-20 bg-[#b75d3c]"></div>
                <p class="max-w-lg text-base leading-7 text-[#66746a] dark:text-[#a3b1a5] sm:text-lg sm:leading-8">Ruang informasi, berita, dan kegiatan Nahdlatul Ulama yang tumbuh bersama warga Ranting Pekuncen.</p>
                <a href="{{ route('news.index') }}" class="mt-6 inline-flex items-center gap-3 text-sm font-extrabold text-[#1a5b41] transition hover:gap-4 dark:text-[#a8ddb8]">Jelajahi seluruh berita <span class="flex h-8 w-8 items-center justify-center rounded-full border border-[#c5d0c4] dark:border-[#465648]"><x-portal-icon name="newspaper" class="h-4 w-4" /></span></a>
                <a href="{{ route('about') }}" class="ml-4 mt-6 inline-flex items-center gap-2 text-sm font-bold text-[#66746a] transition hover:text-[#1a5b41] dark:text-[#a3b1a5] dark:hover:text-[#a8ddb8]">Tentang ranting <span aria-hidden="true">→</span></a>
            </div>
        </section>

        @if ($featuredNews)
            <section class="grid gap-7 border-b border-[#dde0d6] py-8 dark:border-[#364339] sm:py-10 lg:grid-cols-12 lg:gap-10 lg:py-12">
                <a href="{{ route('news.show', $featuredNews->slug) }}" class="group relative block lg:col-span-7">
                    <div class="aspect-[5/4] overflow-hidden bg-[#e2e4d9] dark:bg-[#27362b] sm:aspect-[16/10]">
                        @if ($featuredNews->thumbnail)
                            <img src="{{ asset('storage/' . $featuredNews->thumbnail) }}" alt="{{ $featuredNews->title }}" fetchpriority="high" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.035]">
                        @else
                            <div class="flex h-full items-center justify-center px-6 text-center text-sm font-semibold text-[#66746a] dark:text-[#a3b1a5]">Gambar berita belum tersedia</div>
                        @endif
                    </div>
                    <span class="absolute left-4 top-4 inline-flex items-center gap-2 bg-[#fffef9] px-3 py-2 text-[9px] font-extrabold uppercase tracking-[.15em] text-[#1a5b41] sm:left-6 sm:top-6"><span class="h-1.5 w-1.5 rounded-full bg-[#b75d3c]"></span> Sorotan redaksi</span>
                </a>

                <article class="flex min-w-0 flex-col justify-center lg:col-span-5 lg:py-4">
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-[10px] font-extrabold uppercase tracking-[.14em] text-[#1a5b41] dark:text-[#a8ddb8]">
                        <span>{{ $featuredNews->category?->name ?? 'Berita' }}</span>
                        @if ($featuredNews->published_at)
                            <span class="text-[#b75d3c]">/</span>
                            <time datetime="{{ $featuredNews->published_at->toDateString() }}" class="font-semibold tracking-normal text-[#66746a] dark:text-[#a3b1a5]">{{ $featuredNews->published_at->translatedFormat('d F Y') }}</time>
                        @endif
                    </div>
                    <h2 class="mt-4 font-editorial text-3xl font-extrabold leading-[1.04] tracking-[-.055em] text-[#192b23] dark:text-[#ebefe5] sm:text-4xl lg:text-[2.9rem]">
                        <a href="{{ route('news.show', $featuredNews->slug) }}" class="transition-colors hover:text-[#1a5b41] dark:hover:text-[#80ca9d]">{{ $featuredNews->title }}</a>
                    </h2>
                    @if ($featuredNews->excerpt)
                        <p class="mt-5 text-sm leading-7 text-[#66746a] dark:text-[#a3b1a5] sm:text-base">{{ $featuredNews->excerpt }}</p>
                    @endif
                    <div class="mt-7 flex items-center gap-3 border-t border-[#dde0d6] pt-5 dark:border-[#364339]">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#e4ede2] text-xs font-extrabold text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]">{{ mb_strtoupper(mb_substr($featuredNews->author?->name ?? 'NU', 0, 2)) }}</div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">{{ $featuredNews->author?->name ?? 'Redaksi' }}</p>
                            <p class="mt-1 text-[11px] text-[#66746a] dark:text-[#a3b1a5]">Kontributor portal</p>
                        </div>
                        <a href="{{ route('news.show', $featuredNews->slug) }}" class="ml-auto shrink-0 text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Baca cerita <x-portal-icon name="book-open" class="h-4 w-4" /></a>
                    </div>
                </article>
            </section>
        @endif

        @if ($upcomingEvents->isNotEmpty())
            <section class="border-y border-[#dde0d6] py-10 dark:border-[#364339] sm:py-14">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="portal-kicker">Kalender komunitas</p>
                        <h2 class="mt-3 font-editorial text-3xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5] sm:text-4xl">Agenda mendatang</h2>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Catat kegiatan berikutnya dan tetap terhubung dengan lingkungan sekitar.</p>
                    </div>
                    <a href="{{ route('events.index') }}" class="inline-flex shrink-0 items-center gap-2 text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Semua kegiatan <x-portal-icon name="calendar" class="h-4 w-4" /></a>
                </div>
                <div class="mt-7 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($upcomingEvents as $event)
                        <article class="group flex min-w-0 flex-col border-t-2 border-[#1a5b41] pt-4 dark:border-[#80ca9d]">
                            <div class="flex items-start gap-4">
                                <div class="flex w-16 shrink-0 flex-col items-center justify-center bg-[#e4ede2] px-2 py-3 text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]">
                                    <span class="font-editorial text-2xl font-extrabold leading-none">{{ $event->starts_at->format('d') }}</span>
                                    <span class="mt-1 text-[9px] font-extrabold uppercase tracking-[.14em]">{{ $event->starts_at->translatedFormat('M Y') }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[10px] font-extrabold uppercase tracking-[.13em] text-[#b75d3c]">{{ $event->category ?: 'Kegiatan NU' }} / {{ $event->starts_at->format('H:i') }} WIB</p>
                                    <h3 class="mt-2 font-editorial text-xl font-extrabold leading-tight tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5]"><a href="{{ route('events.show', $event->slug) }}" class="transition-colors group-hover:text-[#1a5b41] dark:group-hover:text-[#a8ddb8]">{{ $event->title }}</a></h3>
                                    @if ($event->excerpt)
                                        <p class="mt-2 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">{{ \Illuminate\Support\Str::limit($event->excerpt, 110) }}</p>
                                    @endif
                                    @if ($event->location)
                                        <p class="mt-3 text-xs font-semibold text-[#66746a] dark:text-[#a3b1a5]">⌖ {{ $event->location }}</p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="py-12 sm:py-16 lg:py-20">
            <div class="flex flex-col gap-5 border-b-2 border-[#192b23] pb-5 dark:border-[#ebefe5] sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="portal-kicker">Dari lingkungan kita</p>
                    <h2 class="mt-3 font-editorial text-3xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5] sm:text-4xl">Kabar terbaru</h2>
                </div>
                <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Semua berita <x-portal-icon name="newspaper" class="h-4 w-4" /></a>
            </div>

            @if ($latestNews->isNotEmpty())
                <div class="mt-8 grid gap-8 lg:grid-cols-12 lg:gap-12">
                    <div class="grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:col-span-8">
                        @foreach ($latestNews->take(4) as $item)
                            <article class="group flex min-w-0 flex-col">
                                <a href="{{ route('news.show', $item->slug) }}" class="block overflow-hidden bg-[#e2e4d9] dark:bg-[#27362b]">
                                    <div class="aspect-[16/10]">
                                        @if ($item->thumbnail)
                                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.035]">
                                        @else
                                            <div class="flex h-full items-center justify-center px-4 text-center text-xs text-[#66746a] dark:text-[#a3b1a5]">Gambar belum tersedia</div>
                                        @endif
                                    </div>
                                </a>
                                <div class="flex flex-1 flex-col pt-4">
                                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[10px] font-extrabold uppercase tracking-[.13em] text-[#1a5b41] dark:text-[#a8ddb8]">
                                        <span>{{ $item->category?->name ?? 'Berita' }}</span>
                                        @if ($item->published_at)
                                            <span class="text-[#b75d3c]">/</span>
                                            <time datetime="{{ $item->published_at->toDateString() }}" class="font-semibold tracking-normal text-[#66746a] dark:text-[#a3b1a5]">{{ $item->published_at->translatedFormat('d M Y') }}</time>
                                        @endif
                                    </div>
                                    <h3 class="mt-3 font-editorial text-xl font-extrabold leading-tight tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">
                                        <a href="{{ route('news.show', $item->slug) }}" class="transition-colors group-hover:text-[#1a5b41] dark:group-hover:text-[#80ca9d]">{{ $item->title }}</a>
                                    </h3>
                                    @if ($item->excerpt)
                                        <p class="mt-3 line-clamp-3 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">{{ \Illuminate\Support\Str::limit($item->excerpt, 130) }}</p>
                                    @endif
                                    <div class="mt-5 flex items-center justify-between gap-3 border-t border-[#dde0d6] pt-3 dark:border-[#364339]">
                                        <span class="truncate text-xs font-semibold text-[#66746a] dark:text-[#a3b1a5]">{{ $item->author?->name ?? 'Redaksi' }}</span>
                                        <a href="{{ route('news.show', $item->slug) }}" class="shrink-0 text-xs font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Baca <x-portal-icon name="book-open" class="h-3.5 w-3.5" /></a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if ($latestNews->count() > 4)
                        <aside class="lg:col-span-4">
                            <div class="flex items-center justify-between border-b border-[#dde0d6] pb-3 dark:border-[#364339]">
                                <h3 class="text-[10px] font-extrabold uppercase tracking-[.16em] text-[#66746a] dark:text-[#a3b1a5]">Urutan berikutnya</h3>
                                <span class="text-[10px] font-bold text-[#b75d3c]">{{ str_pad((string) ($latestNews->count() - 4), 2, '0', STR_PAD_LEFT) }} cerita</span>
                            </div>
                            <div class="divide-y divide-[#dde0d6] dark:divide-[#364339]">
                                @foreach ($latestNews->slice(4) as $item)
                                    <article class="group flex gap-4 py-5">
                                        <a href="{{ route('news.show', $item->slug) }}" class="h-24 w-24 shrink-0 overflow-hidden bg-[#e2e4d9] dark:bg-[#27362b] sm:h-28 sm:w-32">
                                            @if ($item->thumbnail)
                                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]">
                                            @else
                                                <span class="flex h-full items-center justify-center p-2 text-center text-[10px] text-[#66746a] dark:text-[#a3b1a5]">Tanpa gambar</span>
                                            @endif
                                        </a>
                                        <div class="min-w-0 pt-1">
                                            <p class="text-[10px] font-extrabold uppercase tracking-[.13em] text-[#1a5b41] dark:text-[#a8ddb8]">{{ $item->category?->name ?? 'Berita' }}</p>
                                            <h4 class="mt-2 line-clamp-3 text-sm font-bold leading-5 text-[#192b23] transition-colors group-hover:text-[#1a5b41] dark:text-[#ebefe5] dark:group-hover:text-[#80ca9d]">
                                                <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                                            </h4>
                                            @if ($item->published_at)
                                                <time datetime="{{ $item->published_at->toDateString() }}" class="mt-2 block text-[11px] text-[#66746a] dark:text-[#a3b1a5]">{{ $item->published_at->translatedFormat('d M Y') }}</time>
                                            @endif
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </aside>
                    @endif
                </div>
            @else
                <div class="mt-7 border border-dashed border-[#c6cec0] px-5 py-14 text-center dark:border-[#465648]">
                    <p class="text-sm text-[#66746a] dark:text-[#a3b1a5]">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endif
        </section>

        <section class="border-t border-[#dde0d6] py-10 dark:border-[#364339] sm:py-14">
            <div class="grid gap-6 md:grid-cols-[.8fr_1.2fr] md:items-end">
                <div>
                    <p class="portal-kicker">Baca berdasarkan topik</p>
                    <h2 class="mt-3 font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5] sm:text-3xl">Jelajahi kategori</h2>
                </div>
                <p class="max-w-lg text-sm leading-7 text-[#66746a] dark:text-[#a3b1a5] md:justify-self-end">Dari kegiatan warga hingga kabar organisasi, temukan tulisan yang sesuai dengan topik yang sedang kamu cari.</p>
            </div>
            <div class="mt-6 flex gap-2 overflow-x-auto pb-2">
                <a href="{{ route('news.index') }}" class="inline-flex min-h-11 shrink-0 items-center gap-3 rounded-full bg-[#1a5b41] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#134832] dark:bg-[#80ca9d] dark:text-[#17251b]">Semua berita <x-portal-icon name="newspaper" class="h-4 w-4" /></a>
                @forelse (\App\Models\NewsCategory::withCount(['news' => fn ($query) => $query->where('status', 'published')])->orderBy('name')->get() as $category)
                    <a href="{{ route('news.index', ['category' => $category->slug]) }}" class="inline-flex min-h-11 shrink-0 items-center gap-3 rounded-full border border-[#c8d0c3] bg-[#fffef9] px-4 py-2.5 text-sm font-bold text-[#405347] transition hover:border-[#1a5b41] hover:text-[#1a5b41] dark:border-[#465648] dark:bg-[#19221c] dark:text-[#d0dbcf] dark:hover:border-[#80ca9d] dark:hover:text-[#a8ddb8]">
                        {{ $category->name }} <span class="text-[11px] font-semibold text-[#88968a]">{{ $category->news_count }}</span>
                    </a>
                @empty
                    <p class="text-sm text-[#66746a] dark:text-[#a3b1a5]">Belum ada kategori.</p>
                @endforelse
            </div>
        </section>
    </main>
</x-public-layout>
