<x-public-layout>
    <main class="mx-auto max-w-[1500px] px-4 py-8 sm:px-7 sm:py-12 lg:px-10 lg:py-16">
        <nav aria-label="Breadcrumb" class="mb-8 text-xs font-bold text-[#66746a] dark:text-[#a3b1a5]">
            <a href="{{ route('home') }}" class="transition hover:text-[#1a5b41] dark:hover:text-[#a8ddb8]">Beranda</a>
            <span class="mx-2 text-[#b75d3c]">/</span>
            <a href="{{ route('news.index') }}" class="transition hover:text-[#1a5b41] dark:hover:text-[#a8ddb8]">Berita</a>
            <span class="mx-2 text-[#b75d3c]">/</span>
            <span>{{ $news->category?->name ?? 'Artikel' }}</span>
        </nav>

        <article>
            <header class="mx-auto max-w-5xl">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-[10px] font-extrabold uppercase tracking-[.15em] text-[#1a5b41] dark:text-[#a8ddb8]">
                    <span>{{ $news->category?->name ?? 'Berita' }}</span>
                    @if ($news->published_at)
                        <span class="text-[#b75d3c]">/</span>
                        <time datetime="{{ $news->published_at->toDateString() }}" class="font-semibold tracking-normal text-[#66746a] dark:text-[#a3b1a5]">{{ $news->published_at->translatedFormat('d F Y, H:i') }}</time>
                    @endif
                </div>

                <h1 class="mt-5 max-w-5xl font-editorial text-4xl font-extrabold leading-[1.01] tracking-[-.065em] text-[#192b23] dark:text-[#ebefe5] sm:text-5xl lg:text-7xl">{{ $news->title }}</h1>
                @if ($news->excerpt)
                    <p class="mt-6 max-w-3xl text-lg leading-8 text-[#66746a] dark:text-[#a3b1a5] sm:text-xl">{{ $news->excerpt }}</p>
                @endif

                <div class="mt-7 flex items-center gap-3 border-y border-[#dde0d6] py-5 dark:border-[#364339]">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#e4ede2] text-xs font-extrabold text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]">{{ mb_strtoupper(mb_substr($news->author?->name ?? 'NU', 0, 2)) }}</div>
                    <div>
                        <p class="text-sm font-extrabold text-[#192b23] dark:text-[#ebefe5]">{{ $news->author?->name ?? 'Redaksi' }}</p>
                        <p class="mt-1 text-xs text-[#66746a] dark:text-[#a3b1a5]">Kontributor portal</p>
                    </div>
                    <a href="{{ route('news.index') }}" class="ml-auto text-xs font-extrabold text-[#1a5b41] dark:text-[#a8ddb8] sm:text-sm">Kembali ke berita ←</a>
                </div>
            </header>

            @if ($news->thumbnail)
                <figure class="mx-auto mt-8 max-w-6xl overflow-hidden bg-[#e2e4d9] dark:bg-[#27362b]">
                    <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="max-h-[720px] w-full object-cover">
                </figure>
            @endif

            <div class="mx-auto mt-10 grid max-w-6xl gap-8 lg:grid-cols-[minmax(0,1fr)_220px] lg:gap-16">
                <div class="min-w-0">
                    <div class="article-copy max-w-3xl whitespace-normal break-words text-base leading-8 text-[#33473a] dark:text-[#d0dbcf] sm:text-lg sm:leading-9">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>
                <aside class="h-fit border-t border-[#dde0d6] pt-5 dark:border-[#364339] lg:border-l lg:border-t-0 lg:pl-6 lg:pt-0">
                    <p class="portal-kicker">Terhubung</p>
                    <p class="mt-4 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Baca kabar lainnya dari lingkungan Pekuncen.</p>
                    <a href="{{ route('news.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">Jelajahi berita ↗</a>
                </aside>
            </div>
        </article>
    </main>
</x-public-layout>
