<x-public-layout>
    <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <section class="border-b-2 border-[#2ec486] pb-5">
            <p class="font-interface text-[10px] font-bold uppercase tracking-[0.16em] text-[#1C775A] dark:text-[#53e0a0]">
                {{ $selectedCategory ? 'Kategori berita' : 'Portal berita' }}
            </p>

            <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="font-editorial text-4xl font-semibold tracking-[-0.025em] text-[#15201B] dark:text-[#e0e3df] lg:text-5xl">
                        {{ $selectedCategory?->name ?? 'Berita' }}
                    </h1>
                    <p class="mt-3 max-w-2xl font-interface text-sm leading-6 text-[#68746e] dark:text-[#98a49c]">
                        @if ($selectedCategory)
                            Kumpulan berita yang diterbitkan dalam kategori {{ $selectedCategory->name }}.
                        @else
                            Kabar terbaru dan informasi dari lingkungan NU.
                        @endif
                    </p>
                </div>

                @if ($selectedCategory)
                    <a href="{{ route('news.index') }}" class="inline-flex w-fit items-center gap-2 font-interface text-sm font-semibold text-[#1C775A] hover:underline dark:text-[#53e0a0]">
                        <span aria-hidden="true">←</span>
                        Semua berita
                    </a>
                @endif
            </div>
        </section>

        @if ($news->isNotEmpty())
            <section class="mt-8">
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($news as $item)
                        <article class="group flex flex-col overflow-hidden rounded-xl border border-[#d9ddd9] bg-white transition-colors hover:border-[#91b6a0] dark:border-[#2b312d] dark:bg-[#181c1a] dark:hover:border-[#3e6e53]">
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
                                    <time datetime="{{ $item->published_at?->toDateString() }}">{{ $item->published_at?->translatedFormat('d M Y') ?? 'Tanggal belum tersedia' }}</time>
                                </div>

                                <h2 class="mt-3 font-editorial text-2xl font-semibold leading-tight text-[#15201B] dark:text-[#e0e3df]">
                                    <a href="{{ route('news.show', $item->slug) }}" class="transition-colors group-hover:text-[#1C775A] dark:group-hover:text-[#53e0a0]">
                                        {{ $item->title }}
                                    </a>
                                </h2>

                                @if ($item->excerpt)
                                    <p class="mt-3 font-interface text-sm leading-6 text-[#68746e] dark:text-[#98a49c]">
                                        {{ \Illuminate\Support\Str::limit($item->excerpt, 135) }}
                                    </p>
                                @endif

                                <div class="mt-5 flex items-center justify-between gap-3 border-t border-[#e4e7e3] pt-4 dark:border-[#2b312d]">
                                    <span class="font-interface text-xs text-[#68746e] dark:text-[#98a49c]">
                                        {{ $item->published_at?->translatedFormat('d M Y') ?? 'Tanggal belum tersedia' }}
                                    </span>
                                    <a href="{{ route('news.show', $item->slug) }}" class="font-interface text-xs font-semibold text-[#1C775A] hover:underline dark:text-[#53e0a0]">
                                        Baca <span aria-hidden="true">→</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $news->links() }}
                </div>
            </section>
        @else
            <section class="mt-8 rounded-xl border border-dashed border-[#b8c8bd] px-5 py-12 text-center dark:border-[#3a4b40]">
                <h2 class="font-editorial text-2xl font-semibold text-[#15201B] dark:text-[#e0e3df]">Belum ada berita di sini</h2>
                <p class="mt-2 font-interface text-sm leading-6 text-[#68746e] dark:text-[#98a49c]">
                    @if ($selectedCategory)
                        Belum ada berita yang diterbitkan dalam kategori ini.
                    @else
                        Berita yang sudah dipublikasikan akan tampil di halaman ini.
                    @endif
                </p>
                @if ($selectedCategory)
                    <a href="{{ route('news.index') }}" class="mt-5 inline-flex items-center gap-2 rounded-lg bg-[#1C775A] px-4 py-2.5 font-interface text-sm font-semibold text-white transition-colors hover:bg-[#155A44]">
                        Jelajahi semua berita <span aria-hidden="true">↗</span>
                    </a>
                @endif
            </section>
        @endif
    </main>
</x-public-layout>
