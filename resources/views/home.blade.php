<x-public-layout>
    <main class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Editorial introduction --}}
        <section class="py-8 sm:py-10 lg:py-12">
            <div class="flex flex-col gap-5 border-b border-[#d9ddd9] pb-6 dark:border-[#2b312d] sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-3xl">
                    <p class="font-interface text-xs font-bold uppercase tracking-[0.18em] text-[#1C775A] dark:text-[#53e0a0]">
                        Portal Informasi NU Pekuncen
                    </p>
                    <h1 class="mt-3 font-editorial text-4xl font-semibold leading-tight tracking-[-0.035em] text-[#15201B] dark:text-[#e0e3df] sm:text-5xl lg:text-6xl">
                        Kabar, gerak, dan khidmah dalam satu ruang.
                    </h1>
                    <p class="mt-4 max-w-2xl font-interface text-sm leading-7 text-[#5f6b65] dark:text-[#aeb8b1] sm:text-base">
                        Ikuti kabar terbaru, cerita kegiatan, dan informasi dari lingkungan Nahdlatul Ulama Pekuncen.
                    </p>
                </div>

                <a href="{{ route('news.index') }}"
                    class="inline-flex w-fit shrink-0 items-center gap-2 rounded-lg bg-[#1C775A] px-4 py-3 font-interface text-sm font-semibold text-white transition-colors hover:bg-[#155A44] focus:outline-none focus:ring-2 focus:ring-[#2ec486] focus:ring-offset-2 dark:focus:ring-offset-[#101412]">
                    Jelajahi berita
                    <span aria-hidden="true">↗</span>
                </a>
            </div>
        </section>

        {{-- Featured story and quick reads --}}
        @if ($featuredNews)
            <section aria-labelledby="featured-heading" class="pb-12 lg:pb-16">
                <div class="grid gap-5 lg:grid-cols-12 lg:gap-6">
                    <article class="overflow-hidden rounded-2xl border border-[#d9ddd9] bg-white dark:border-[#2b312d] dark:bg-[#181c1a] lg:col-span-8">
                        <a href="{{ route('news.show', $featuredNews->slug) }}" class="group block">
                            <div class="relative aspect-[16/10] overflow-hidden bg-[#e8eee9] dark:bg-[#202923] sm:aspect-[16/9]">
                                @if ($featuredNews->thumbnail)
                                    <img src="{{ asset('storage/' . $featuredNews->thumbnail) }}"
                                        alt="{{ $featuredNews->title }}"
                                        fetchpriority="high"
                                        decoding="async"
                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.025]">
                                @else
                                    <div class="flex h-full min-h-[260px] items-end bg-gradient-to-br from-[#1C775A] via-[#174b37] to-[#102c22] p-6 sm:min-h-0 sm:p-8">
                                        <span class="font-editorial text-7xl font-semibold tracking-tight text-white/20 sm:text-9xl" aria-hidden="true">NU</span>
                                    </div>
                                @endif

                                <div class="absolute inset-0 bg-gradient-to-t from-[#071b12]/75 via-transparent to-[#071b12]/10"></div>
                                <span class="absolute left-4 top-4 inline-flex rounded-md bg-white/95 px-3 py-1.5 font-interface text-[10px] font-bold uppercase tracking-[0.12em] text-[#174b37] sm:left-6 sm:top-6">
                                    Sorotan utama
                                </span>
                                <span class="absolute bottom-4 left-4 right-4 font-interface text-xs font-medium text-white/90 sm:bottom-6 sm:left-6">
                                    {{ $featuredNews->category?->name ?? 'Berita' }}
                                    <span aria-hidden="true" class="px-1.5">·</span>
                                    {{ $featuredNews->published_at?->format('d/m/Y') ?? 'Tanggal belum tersedia' }}
                                </span>
                            </div>
                        </a>

                        <div class="p-5 sm:p-7">
                            <h2 id="featured-heading" class="font-editorial text-3xl font-semibold leading-tight tracking-[-0.025em] text-[#15201B] dark:text-[#e0e3df] sm:text-4xl">
                                <a href="{{ route('news.show', $featuredNews->slug) }}" class="transition-colors hover:text-[#1C775A] dark:hover:text-[#53e0a0]">
                                    {{ $featuredNews->title }}
                                </a>
                            </h2>

                            @if ($featuredNews->excerpt)
                                <p class="mt-4 max-w-3xl font-interface text-sm leading-7 text-[#5f6b65] dark:text-[#aeb8b1] sm:text-base">
                                    {{ IlluminateSupportStr::limit($featuredNews->excerpt, 220) }}
                                </p>
                            @endif

                            <div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-[#e4e7e3] pt-4 dark:border-[#2b312d]">
                                <span class="font-interface text-xs text-[#68746e] dark:text-[#98a49c]">
                                    Ditulis oleh {{ $featuredNews->author?->name ?? 'Redaksi' }}
                                </span>
                                <a href="{{ route('news.show', $featuredNews->slug) }}" class="font-interface text-sm font-semibold text-[#1C775A] hover:text-[#155A44] dark:text-[#53e0a0] dark:hover:text-[#71fcb8]">
                                    Baca selengkapnya <span aria-hidden="true">→</span>
                                </a>
                            </div>
                        </div>
                    </article>

                    <aside class="flex flex-col rounded-2xl border border-[#d9ddd9] bg-[#f7f8f5] p-5 dark:border-[#2b312d] dark:bg-[#151a17] sm:p-6 lg:col-span-4" aria-labelledby="quick-reads-heading">
                        <div class="flex items-start justify-between gap-3 border-b border-[#d9ddd9] pb-4 dark:border-[#2b312d]">
                            <div>
                                <p class="font-interface text-[10px] font-bold uppercase tracking-[0.16em] text-[#1C775A] dark:text-[#53e0a0]">Pilihan redaksi</p>
                                <h2 id="quick-reads-heading" class="mt-1 font-editorial text-2xl font-semibold text-[#15201B] dark:text-[#e0e3df]">Kabar lainnya</h2>
                            </div>
                            <span class="font-interface text-xs text-[#68746e] dark:text-[#98a49c]">01—02</span>
                        </div>

                        <div class="flex flex-1 flex-col divide-y divide-[#d9ddd9] dark:divide-[#2b312d]">
                            @forelse ($secondaryNews as $item)
                                <article class="flex flex-1 flex-col gap-3 py-5 first:pt-5 last:pb-1">
                                    <div class="flex flex-wrap items-center gap-2 font-interface text-[10px] font-bold uppercase tracking-[0.1em] text-[#1C775A] dark:text-[#53e0a0]">
                                        <span>{{ $item->category?->name ?? 'Berita' }}</span>
                                        <span class="text-[#a4ada7]" aria-hidden="true">·</span>
                                        <time datetime="{{ $item->published_at?->toDateString() }}">{{ $item->published_at?->format('d/m/Y') ?? 'Tanggal belum tersedia' }}</time>
                                    </div>
                                    <h3 class="font-editorial text-xl font-semibold leading-snug text-[#15201B] dark:text-[#e0e3df] sm:text-2xl">
                                        <a href="{{ route('news.show', $item->slug) }}" class="transition-colors hover:text-[#1C775A] dark:hover:text-[#53e0a0]">
                                            {{ $item->title }}
                                        </a>
                                    </h3>
                                    @if ($item->excerpt)
                                        <p class="font-interface text-sm leading-6 text-[#68746e] dark:text-[#98a49c]">
                                            {{ IlluminateSupportStr::limit($item->excerpt, 105) }}
                                        </p>
                                    @endif
                                    <a href="{{ route('news.show', $item->slug) }}" class="mt-auto w-fit font-interface text-xs font-semibold text-[#1C775A] hover:underline dark:text-[#53e0a0]">
                                        Baca berita <span aria-hidden="true">↗</span>
                                    </a>
                                </article>
                            @empty
                                <p class="py-5 font-interface text-sm leading-6 text-[#68746e] dark:text-[#98a49c]">
                                    Berita pilihan lainnya akan tampil di sini setelah dipublikasikan.
                                </p>
                            @endforelse
                        </div>
                    </aside>
                </div>
            </section>
        @else
            <section class="pb-12 lg:pb-16">
                <div class="rounded-2xl border border-dashed border-[#b8c8bd] bg-[#f7f8f5] px-6 py-12 text-center dark:border-[#3a4b40] dark:bg-[#151a17]">
                    <p class="font-interface text-sm text-[#68746e] dark:text-[#98a49c]">Belum ada berita yang dipublikasikan. Berita akan muncul di sini setelah tersedia.</p>
                </div>
            </section>
        @endif

        {{-- Visual story mosaic: uses real thumbnails from published stories --}}
        @if ($galleryNews->count() > 1)
            <section aria-labelledby="visual-highlights-heading" class="border-t border-[#d9ddd9] py-12 dark:border-[#2b312d] lg:py-16">
                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div class="max-w-2xl">
                        <p class="font-interface text-[10px] font-bold uppercase tracking-[0.16em] text-[#1C775A] dark:text-[#53e0a0]">Cerita lewat gambar</p>
                        <h2 id="visual-highlights-heading" class="mt-2 font-editorial text-3xl font-semibold tracking-[-0.025em] text-[#15201B] dark:text-[#e0e3df] sm:text-4xl">Sorotan visual</h2>
                        <p class="mt-2 font-interface text-sm leading-6 text-[#68746e] dark:text-[#98a49c]">Potret dari berita dan kegiatan yang telah dipublikasikan.</p>
                    </div>
                    <a href="{{ route('news.index') }}" class="inline-flex w-fit items-center gap-2 font-interface text-sm font-semibold text-[#1C775A] hover:underline dark:text-[#53e0a0]">
                        Semua berita <span aria-hidden="true">↗</span>
                    </a>
                </div>

                <div @class([
                    'grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4',
                    'lg:grid-cols-4 lg:grid-rows-2' => $galleryNews->count() > 3,
                    'lg:grid-cols-2' => $galleryNews->count() <= 3,
                ])>
                    @foreach ($galleryNews as $item)
                        @php($isMosaicLead = $loop->first && $galleryNews->count() > 3)
                        <article @class([
                            'group relative isolate overflow-hidden rounded-2xl bg-[#e8eee9] dark:bg-[#202923]',
                            'col-span-2 min-h-[300px] sm:min-h-[380px] lg:row-span-2 lg:min-h-[470px]' => $isMosaicLead,
                            'min-h-[210px] sm:min-h-[240px]' => !$isMosaicLead,
                        ])>
                            <a href="{{ route('news.show', $item->slug) }}" class="absolute inset-0 block focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#2ec486]">
                                <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                    alt="{{ $item->title }}"
                                    loading="lazy"
                                    decoding="async"
                                    class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.04]">
                                <span class="absolute inset-0 bg-gradient-to-t from-[#071b12]/90 via-[#071b12]/15 to-transparent"></span>
                                <span class="absolute inset-x-0 bottom-0 p-4 sm:p-5">
                                    <span class="block font-interface text-[10px] font-bold uppercase tracking-[0.12em] text-[#b8f5ce]">
                                        {{ $item->category?->name ?? 'Berita' }}
                                    </span>
                                    <span class="mt-2 block font-editorial text-lg font-semibold leading-snug text-white sm:text-xl {{ $isMosaicLead ? 'lg:text-3xl' : '' }}">
                                        {{ $item->title }}
                                    </span>
                                    <span class="mt-2 block font-interface text-xs text-white/75">
                                        {{ $item->published_at?->format('d/m/Y') ?? 'Tanggal belum tersedia' }}
                                    </span>
                                </span>
                            </a>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Remaining published stories --}}
        <section aria-labelledby="latest-news-heading" class="border-t border-[#d9ddd9] py-12 dark:border-[#2b312d] lg:py-16">
            <div class="flex flex-col gap-4 border-b-2 border-[#2ec486] pb-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="font-interface text-[10px] font-bold uppercase tracking-[0.16em] text-[#1C775A] dark:text-[#53e0a0]">Tetap terhubung</p>
                    <h2 id="latest-news-heading" class="mt-2 font-editorial text-3xl font-semibold tracking-[-0.025em] text-[#15201B] dark:text-[#e0e3df] sm:text-4xl">Berita lainnya</h2>
                    <p class="mt-2 font-interface text-sm leading-6 text-[#68746e] dark:text-[#98a49c]">Ikuti informasi terbaru dari lingkungan NU Pekuncen.</p>
                </div>
                <a href="{{ route('news.index') }}" class="inline-flex w-fit items-center gap-2 font-interface text-sm font-semibold text-[#1C775A] hover:underline dark:text-[#53e0a0]">
                    Lihat arsip berita <span aria-hidden="true">↗</span>
                </a>
            </div>

            @if ($latestNews->isNotEmpty())
                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($latestNews as $item)
                        <article class="group flex h-full flex-col overflow-hidden rounded-xl border border-[#d9ddd9] bg-white transition-colors hover:border-[#91b6a0] dark:border-[#2b312d] dark:bg-[#181c1a] dark:hover:border-[#3e6e53]">
                            @if ($item->thumbnail)
                                <a href="{{ route('news.show', $item->slug) }}" class="block overflow-hidden">
                                    <div class="aspect-[16/10] overflow-hidden bg-[#e8eee9] dark:bg-[#202923]">
                                        <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                            alt="{{ $item->title }}"
                                            loading="lazy"
                                            decoding="async"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.025]">
                                    </div>
                                </a>
                            @endif

                            <div class="flex flex-1 flex-col p-5">
                                <div class="flex flex-wrap items-center gap-2 font-interface text-[10px] font-bold uppercase tracking-[0.1em] text-[#1C775A] dark:text-[#53e0a0]">
                                    <span>{{ $item->category?->name ?? 'Berita' }}</span>
                                    <span class="text-[#a4ada7]" aria-hidden="true">·</span>
                                    <time datetime="{{ $item->published_at?->toDateString() }}">{{ $item->published_at?->format('d/m/Y') ?? 'Tanggal belum tersedia' }}</time>
                                </div>

                                <h3 class="mt-3 font-editorial text-2xl font-semibold leading-tight text-[#15201B] dark:text-[#e0e3df]">
                                    <a href="{{ route('news.show', $item->slug) }}" class="transition-colors group-hover:text-[#1C775A] dark:group-hover:text-[#53e0a0]">
                                        {{ $item->title }}
                                    </a>
                                </h3>

                                @if ($item->excerpt)
                                    <p class="mt-3 font-interface text-sm leading-6 text-[#68746e] dark:text-[#98a49c]">
                                        {{ IlluminateSupportStr::limit($item->excerpt, 135) }}
                                    </p>
                                @endif

                                <div class="mt-5 flex items-center justify-between gap-3 border-t border-[#e4e7e3] pt-4 dark:border-[#2b312d]">
                                    <span class="font-interface text-xs text-[#68746e] dark:text-[#98a49c]">
                                        {{ $item->author?->name ?? 'Redaksi' }}
                                    </span>
                                    <a href="{{ route('news.show', $item->slug) }}" class="font-interface text-xs font-semibold text-[#1C775A] hover:underline dark:text-[#53e0a0]">
                                        Baca <span aria-hidden="true">→</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="mt-6 rounded-xl border border-dashed border-[#b8c8bd] px-5 py-8 text-center dark:border-[#3a4b40]">
                    <p class="font-interface text-sm text-[#68746e] dark:text-[#98a49c]">Semua berita terbaru sudah ditampilkan di bagian sorotan.</p>
                </div>
            @endif
        </section>

        {{-- Dynamic topic shortcuts --}}
        @if ($categories->isNotEmpty())
            <section aria-labelledby="topics-heading" class="border-t border-[#d9ddd9] py-12 dark:border-[#2b312d] lg:py-14">
                <div class="mb-6">
                    <p class="font-interface text-[10px] font-bold uppercase tracking-[0.16em] text-[#1C775A] dark:text-[#53e0a0]">Jelajahi lebih jauh</p>
                    <h2 id="topics-heading" class="mt-2 font-editorial text-3xl font-semibold tracking-[-0.025em] text-[#15201B] dark:text-[#e0e3df]">Jelajahi berdasarkan topik</h2>
                    <p class="mt-2 font-interface text-sm leading-6 text-[#68746e] dark:text-[#98a49c]">Temukan kabar berdasarkan kategori yang tersedia.</p>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($categories as $category)
                        <a href="{{ route('news.index', ['category' => $category->slug]) }}"
                            class="group flex items-center justify-between gap-4 rounded-xl border border-[#d9ddd9] bg-white px-4 py-4 transition-colors hover:border-[#91b6a0] hover:bg-[#f7faf7] focus:outline-none focus:ring-2 focus:ring-[#2ec486] focus:ring-offset-2 dark:border-[#2b312d] dark:bg-[#181c1a] dark:hover:border-[#3e6e53] dark:hover:bg-[#1c201e] dark:focus:ring-offset-[#101412] sm:px-5">
                            <span class="min-w-0">
                                <span class="block font-interface text-sm font-semibold text-[#25342b] transition-colors group-hover:text-[#1C775A] dark:text-[#d5ded7] dark:group-hover:text-[#53e0a0]">
                                    {{ $category->name }}
                                </span>
                                <span class="mt-1 block font-interface text-xs text-[#68746e] dark:text-[#98a49c]">
                                    {{ $category->news_count }} berita
                                </span>
                            </span>
                            <span aria-hidden="true" class="text-lg text-[#1C775A] transition-transform group-hover:translate-x-1 dark:text-[#53e0a0]">↗</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
</x-public-layout>
