<x-public-layout>
    <main class="mx-auto max-w-[1500px] px-4 py-10 sm:px-7 sm:py-14 lg:px-10 lg:py-16">
        <header class="grid gap-7 border-b-2 border-[#192b23] pb-8 dark:border-[#ebefe5] sm:grid-cols-[1fr_.65fr] sm:items-end sm:pb-10">
            <div>
                <p class="portal-kicker">Arsip kabar Pekuncen</p>
                <h1 class="mt-4 font-editorial text-5xl font-extrabold leading-[.98] tracking-[-.07em] text-[#192b23] dark:text-[#ebefe5] sm:text-6xl">{{ $activeCategory?->name ?? 'Semua berita' }}<span class="text-[#b75d3c]">.</span></h1>
            </div>
            <div class="max-w-lg sm:justify-self-end">
                <p class="text-base leading-7 text-[#66746a] dark:text-[#a3b1a5]">
                    @if ($activeCategory)
                        Kumpulan cerita dan informasi terbaru dalam kategori {{ $activeCategory->name }}.
                    @else
                        Kabar, kegiatan, dan cerita dari lingkungan Nahdlatul Ulama di Pekuncen.
                    @endif
                </p>
                @if ($activeCategory)
                    <a href="{{ route('news.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]"><x-portal-icon name="arrow-left" class="h-4 w-4" /> Kembali ke semua berita</a>
                @endif
            </div>
        </header>

        @if ($news->isNotEmpty())
            <section class="py-8 sm:py-10">
                <div class="mb-6 flex items-center justify-between gap-4">
                    <p class="text-[10px] font-extrabold uppercase tracking-[.15em] text-[#66746a] dark:text-[#a3b1a5]">Jelajahi tulisan</p>
                    <p class="text-xs font-semibold text-[#66746a] dark:text-[#a3b1a5]">{{ $news->total() }} berita</p>
                </div>
                <div class="grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($news as $item)
                        <article class="group flex min-w-0 flex-col">
                            <a href="{{ route('news.show', $item->slug) }}" class="block overflow-hidden bg-[#e2e4d9] dark:bg-[#27362b]">
                                <div class="aspect-[16/10]">
                                    @if ($item->thumbnail)
                                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.035]">
                                    @else
                                        <div class="flex h-full items-center justify-center px-4 text-center text-xs text-[#66746a] dark:text-[#a3b1a5]">Gambar berita belum tersedia</div>
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
                                <h2 class="mt-3 font-editorial text-xl font-extrabold leading-tight tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">
                                    <a href="{{ route('news.show', $item->slug) }}" class="transition-colors group-hover:text-[#1a5b41] dark:group-hover:text-[#80ca9d]">{{ $item->title }}</a>
                                </h2>
                                @if ($item->excerpt)
                                    <p class="mt-3 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">{{ \Illuminate\Support\Str::limit($item->excerpt, 150) }}</p>
                                @endif
                                <div class="mt-auto flex items-center justify-between gap-3 border-t border-[#dde0d6] pt-4 mt-5 dark:border-[#364339]">
                                    <span class="truncate text-xs font-semibold text-[#66746a] dark:text-[#a3b1a5]">{{ $item->author?->name ?? 'Redaksi' }}</span>
                                    <a href="{{ route('news.show', $item->slug) }}" class="shrink-0 text-xs font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Baca <x-portal-icon name="book-open" class="h-3.5 w-3.5" /></a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-12">{{ $news->links() }}</div>
            </section>
        @else
            <section class="mt-10 border border-dashed border-[#c6cec0] px-5 py-16 text-center dark:border-[#465648]">
                <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#e4ede2] text-xl text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]">⌕</span>
                <h2 class="mt-4 font-editorial text-xl font-extrabold text-[#192b23] dark:text-[#ebefe5]">Belum ada berita di sini</h2>
                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">
                    @if ($activeCategory)
                        Belum ada berita yang dipublikasikan dalam kategori ini.
                    @else
                        Belum ada berita yang dipublikasikan. Silakan kembali lagi nanti.
                    @endif
                </p>
                @if ($activeCategory)
                    <a href="{{ route('news.index') }}" class="mt-5 inline-flex text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Tampilkan semua berita <x-portal-icon name="newspaper" class="h-4 w-4" /></a>
                @endif
            </section>
        @endif
    </main>
</x-public-layout>
