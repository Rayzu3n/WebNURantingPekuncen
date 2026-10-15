<x-public-layout>
    <main class="mx-auto w-full max-w-screen-2xl px-4 py-10 sm:px-8 lg:px-12 2xl:px-16 lg:py-14">
        <section class="border-b-2 border-emerald-700 pb-5 dark:border-emerald-400">
            <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-emerald-800 dark:text-emerald-300">Portal Berita</p>
            <h1 class="mt-2 font-editorial text-4xl font-semibold tracking-[-0.03em] text-stone-950 dark:text-stone-50 lg:text-5xl">
                {{ $activeCategory?->name ?? 'Berita' }}
            </h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-stone-600 dark:text-stone-400">
                @if ($activeCategory)
                    Berita terbaru dalam kategori {{ $activeCategory->name }}.
                @else
                    Informasi dan berita terbaru dari lingkungan NU.
                @endif
            </p>
            @if ($activeCategory)
                <a href="{{ route('news.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-emerald-800 hover:underline dark:text-emerald-300">
                    <span aria-hidden="true">←</span> Tampilkan semua berita
                </a>
            @endif
        </section>

        @if ($news->isNotEmpty())
            <section class="mt-8">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($news as $item)
                        <article class="group flex flex-col overflow-hidden rounded-lg border border-stone-200 bg-white transition duration-300 hover:-translate-y-0.5 hover:border-emerald-700/50 hover:shadow-lg dark:border-white/10 dark:bg-[#181c1a]">
                            <a href="{{ route('news.show', $item->slug) }}" class="block overflow-hidden bg-stone-100 dark:bg-stone-800">
                                <div class="aspect-[16/10]">
                                    @if ($item->thumbnail)
                                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]">
                                    @else
                                        <div class="flex h-full items-center justify-center text-xs text-stone-500">Gambar berita belum tersedia</div>
                                    @endif
                                </div>
                            </a>
                            <div class="flex flex-1 flex-col p-5">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-emerald-800 dark:text-emerald-300">{{ $item->category?->name ?? 'Berita' }}</span>
                                    @if ($item->published_at)
                                        <span aria-hidden="true" class="text-stone-400">•</span>
                                        <time datetime="{{ $item->published_at->toDateString() }}" class="text-xs text-stone-500 dark:text-stone-400">{{ $item->published_at->translatedFormat('d M Y') }}</time>
                                    @endif
                                </div>
                                <h2 class="mt-3 font-editorial text-2xl font-semibold leading-tight tracking-[-0.025em] text-stone-950 dark:text-stone-50">
                                    <a href="{{ route('news.show', $item->slug) }}" class="transition-colors group-hover:text-emerald-800 dark:group-hover:text-emerald-300">{{ $item->title }}</a>
                                </h2>
                                @if ($item->excerpt)
                                    <p class="mt-3 text-sm leading-6 text-stone-600 dark:text-stone-400">{{ \Illuminate\Support\Str::limit($item->excerpt, 140) }}</p>
                                @endif
                                <div class="mt-auto flex items-center justify-between gap-3 border-t border-stone-200 pt-5 dark:border-white/10">
                                    <span class="truncate text-xs font-medium text-stone-500 dark:text-stone-400">{{ $item->author?->name ?? 'Redaksi' }}</span>
                                    <a href="{{ route('news.show', $item->slug) }}" class="shrink-0 text-xs font-semibold text-emerald-800 hover:underline dark:text-emerald-300">Baca berita ↗</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-10">{{ $news->links() }}</div>
            </section>
        @else
            <section class="mt-8 rounded-lg border border-dashed border-stone-300 px-5 py-12 text-center dark:border-white/15">
                <p class="text-sm text-stone-600 dark:text-stone-400">
                    @if ($activeCategory)
                        Belum ada berita yang dipublikasikan dalam kategori ini.
                    @else
                        Belum ada berita yang dipublikasikan.
                    @endif
                </p>
                @if ($activeCategory)
                    <a href="{{ route('news.index') }}" class="mt-3 inline-block text-sm font-semibold text-emerald-800 hover:underline dark:text-emerald-300">Lihat semua berita</a>
                @endif
            </section>
        @endif
    </main>
</x-public-layout>
