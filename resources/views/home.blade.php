<x-public-layout>
    {{-- Breaking news ticker --}}
    @if ($latestNews->isNotEmpty())
        <div class="border-b border-stone-200 bg-stone-50 dark:border-white/10 dark:bg-[#151a17]">
            <div class="mx-auto flex max-w-7xl items-center gap-3 px-4 py-3 sm:px-6 lg:px-8">
                <span class="shrink-0 rounded-sm bg-emerald-800 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-white dark:bg-emerald-400 dark:text-emerald-950">Terkini</span>
                <a href="{{ route('news.show', $latestNews->first()->slug) }}" class="min-w-0 truncate text-sm font-medium text-stone-700 transition hover:text-emerald-800 dark:text-stone-200 dark:hover:text-emerald-300">
                    {{ $latestNews->first()->title }}
                </a>
                <span class="ml-auto hidden shrink-0 text-xs text-stone-400 sm:block">{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    @endif

    <main class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Masthead --}}
        <section class="flex flex-col gap-3 border-b border-stone-200 py-7 dark:border-white/10 sm:flex-row sm:items-end sm:justify-between sm:py-9">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-800 dark:text-emerald-300">Informasi • Kabar • Khidmah</p>
                <h1 class="mt-2 max-w-3xl font-editorial text-3xl font-semibold leading-tight tracking-[-0.04em] text-stone-950 dark:text-stone-50 sm:text-4xl lg:text-5xl">
                    Kabar terbaru dari <span class="text-emerald-800 dark:text-emerald-300">Pekuncen.</span>
                </h1>
            </div>
            <p class="max-w-sm text-sm leading-6 text-stone-600 dark:text-stone-400 sm:text-right">
                Berita, kegiatan, dan cerita dari lingkungan Nahdlatul Ulama di Pekuncen.
            </p>
        </section>

        {{-- Featured story --}}
        @if ($featuredNews)
            <section class="grid gap-6 border-b border-stone-200 py-7 dark:border-white/10 sm:py-9 lg:grid-cols-12 lg:gap-8 lg:py-10">
                <div class="lg:col-span-8">
                    <a href="{{ route('news.show', $featuredNews->slug) }}" class="group block">
                        <div class="relative overflow-hidden rounded-md bg-stone-200 dark:bg-stone-800">
                            <div class="aspect-[5/4] sm:aspect-[16/9] lg:aspect-[1.42/1]">
                                @if ($featuredNews->thumbnail)
                                    <img src="{{ asset('storage/' . $featuredNews->thumbnail) }}" alt="{{ $featuredNews->title }}" fetchpriority="high" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]">
                                @else
                                    <div class="flex h-full items-center justify-center text-sm text-stone-500">Gambar berita belum tersedia</div>
                                @endif
                            </div>
                            <span class="absolute left-3 top-3 bg-white px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.14em] text-emerald-900 shadow-sm sm:left-5 sm:top-5">Sorotan utama</span>
                        </div>
                    </a>
                </div>

                <div class="flex flex-col justify-center lg:col-span-4 lg:py-2">
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-bold uppercase tracking-[0.12em] text-emerald-800 dark:text-emerald-300">
                        <span>{{ $featuredNews->category->name }}</span>
                        @if ($featuredNews->published_at)
                            <span aria-hidden="true" class="text-stone-400">/</span>
                            <time datetime="{{ $featuredNews->published_at->toDateString() }}" class="font-medium tracking-normal text-stone-500 dark:text-stone-400">{{ $featuredNews->published_at->translatedFormat('d F Y') }}</time>
                        @endif
                    </div>

                    <h2 class="mt-3 font-editorial text-3xl font-semibold leading-[1.08] tracking-[-0.035em] text-stone-950 dark:text-stone-50 sm:text-4xl lg:text-[2.65rem]">
                        <a href="{{ route('news.show', $featuredNews->slug) }}" class="transition-colors hover:text-emerald-800 dark:hover:text-emerald-300">{{ $featuredNews->title }}</a>
                    </h2>

                    @if ($featuredNews->excerpt)
                        <p class="mt-4 line-clamp-4 text-sm leading-7 text-stone-600 dark:text-stone-300 sm:text-base">{{ $featuredNews->excerpt }}</p>
                    @endif

                    <div class="mt-6 flex items-center gap-3 border-t border-stone-200 pt-5 dark:border-white/10">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-900 dark:bg-emerald-900 dark:text-emerald-100">
                            {{ mb_strtoupper(mb_substr($featuredNews->author->name, 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-stone-900 dark:text-stone-100">{{ $featuredNews->author->name }}</p>
                            <p class="mt-0.5 text-xs text-stone-500 dark:text-stone-400">Penulis berita</p>
                        </div>
                        <a href="{{ route('news.show', $featuredNews->slug) }}" class="ml-auto shrink-0 text-sm font-semibold text-emerald-800 hover:underline dark:text-emerald-300">Baca berita <span aria-hidden="true">↗</span></a>
                    </div>
                </div>
            </section>
        @endif

        {{-- Latest stories --}}
        <section class="py-8 sm:py-10 lg:py-12">
            <div class="flex items-end justify-between gap-4 border-b-2 border-emerald-800 pb-3 dark:border-emerald-400">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-emerald-800 dark:text-emerald-300">Dari redaksi</p>
                    <h2 class="mt-1 font-editorial text-3xl font-semibold tracking-[-0.03em] text-stone-950 dark:text-stone-50 sm:text-4xl">Berita terkini</h2>
                </div>
                <a href="{{ route('news.index') }}" class="shrink-0 pb-1 text-xs font-semibold text-emerald-800 hover:underline dark:text-emerald-300 sm:text-sm">Semua berita <span aria-hidden="true">↗</span></a>
            </div>

            @if ($latestNews->isNotEmpty())
                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2 lg:grid-cols-3 lg:gap-y-10">
                    @foreach ($latestNews as $item)
                        <article class="group flex min-w-0 flex-col">
                            <a href="{{ route('news.show', $item->slug) }}" class="block overflow-hidden rounded-md bg-stone-100 dark:bg-stone-800">
                                <div class="aspect-[16/10]">
                                    @if ($item->thumbnail)
                                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]">
                                    @else
                                        <div class="flex h-full items-center justify-center text-xs text-stone-500">Gambar tidak tersedia</div>
                                    @endif
                                </div>
                            </a>
                            <div class="flex flex-1 flex-col pt-4">
                                <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[10px] font-bold uppercase tracking-[0.12em] text-emerald-800 dark:text-emerald-300">
                                    <span>{{ $item->category->name }}</span>
                                    @if ($item->published_at)
                                        <span aria-hidden="true" class="text-stone-400">/</span>
                                        <time datetime="{{ $item->published_at->toDateString() }}" class="font-medium tracking-normal text-stone-500 dark:text-stone-400">{{ $item->published_at->translatedFormat('d M Y') }}</time>
                                    @endif
                                </div>
                                <h3 class="mt-2 font-editorial text-2xl font-semibold leading-tight tracking-[-0.025em] text-stone-950 dark:text-stone-50 sm:text-[1.65rem]">
                                    <a href="{{ route('news.show', $item->slug) }}" class="transition-colors group-hover:text-emerald-800 dark:group-hover:text-emerald-300">{{ $item->title }}</a>
                                </h3>
                                @if ($item->excerpt)
                                    <p class="mt-2 line-clamp-3 text-sm leading-6 text-stone-600 dark:text-stone-400">{{ \Illuminate\Support\Str::limit($item->excerpt, 125) }}</p>
                                @endif
                                <div class="mt-4 flex items-center justify-between gap-3 border-t border-stone-200 pt-3 dark:border-white/10">
                                    <span class="truncate text-xs text-stone-500 dark:text-stone-400">{{ $item->author->name }}</span>
                                    <a href="{{ route('news.show', $item->slug) }}" class="shrink-0 text-xs font-semibold text-emerald-800 hover:underline dark:text-emerald-300">Baca ↗</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="mt-6 rounded-md border border-dashed border-stone-300 px-5 py-12 text-center dark:border-white/15">
                    <p class="text-sm text-stone-500 dark:text-stone-400">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endif
        </section>

        {{-- Browse categories --}}
        <section class="border-t border-stone-200 py-8 dark:border-white/10 sm:py-10">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-emerald-800 dark:text-emerald-300">Jelajahi topik</p>
                    <h2 class="mt-1 font-editorial text-2xl font-semibold tracking-[-0.025em] text-stone-950 dark:text-stone-50 sm:text-3xl">Telusuri kategori</h2>
                </div>
                <p class="max-w-md text-sm leading-6 text-stone-500 dark:text-stone-400">Temukan kabar berdasarkan topik yang ingin kamu ikuti.</p>
            </div>

            <div class="mt-5 flex flex-wrap gap-2">
                @forelse (\App\Models\NewsCategory::orderBy('name')->get() as $category)
                    <a href="{{ route('news.index') }}" class="inline-flex min-h-10 items-center gap-3 rounded-full border border-stone-300 px-4 py-2 text-sm font-medium text-stone-700 transition hover:border-emerald-800 hover:bg-emerald-50 hover:text-emerald-900 dark:border-white/15 dark:text-stone-200 dark:hover:border-emerald-400 dark:hover:bg-emerald-950/40 dark:hover:text-emerald-200">
                        {{ $category->name }} <span aria-hidden="true" class="text-emerald-800 dark:text-emerald-300">↗</span>
                    </a>
                @empty
                    <p class="text-sm text-stone-500 dark:text-stone-400">Belum ada kategori.</p>
                @endforelse
            </div>
        </section>
    </main>
</x-public-layout>
