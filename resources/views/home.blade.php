<x-public-layout>

    {{-- Breaking News --}}
    @if ($latestNews->isNotEmpty())
        <section class="border-b border-[#d9ddd9] dark:border-[#2b312d]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4 py-3">

                    <span
                        class="shrink-0 rounded-md bg-[#1C775A] px-3 py-1.5
                               font-interface text-[10px] font-bold uppercase
                               tracking-[0.12em] text-white">
                        TERKINI
                    </span>

                    <a href="{{ route('news.show', $latestNews->first()->slug) }}"
                        class="min-w-0 truncate font-interface text-sm
                               text-[#4A5550] transition-colors
                               hover:text-[#1C775A]
                               dark:text-[#b8c1bb]
                               dark:hover:text-[#53e0a0]">
                        {{ $latestNews->first()->title }}
                    </a>

                </div>
            </div>
        </section>
    @endif


    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero --}}
        @if ($featuredNews)
            <section class="py-8 lg:py-12">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

                    {{-- Hero Image --}}
                    <div class="lg:col-span-8">

                        @if ($featuredNews->thumbnail)
                            <a href="{{ route('news.show', $featuredNews->slug) }}" class="group block">
                                <div
                                    class="relative overflow-hidden rounded-xl
                                            border border-[#d9ddd9]
                                            bg-[#eef2ef]
                                            dark:border-[#2b312d]
                                            dark:bg-[#181c1a]">

                                    <div class="aspect-[16/9] overflow-hidden">

                                        <img src="{{ asset('storage/' . $featuredNews->thumbnail) }}"
                                            alt="{{ $featuredNews->title }}"
                                            class="w-full h-full object-cover
                                                   transition-transform duration-500
                                                   group-hover:scale-[1.025]">

                                    </div>

                                    <div class="absolute top-4 left-4">
                                        <span
                                            class="rounded-md bg-[#15201B]/85 px-3 py-1.5
                                                   font-interface text-[10px] font-bold
                                                   uppercase tracking-[0.1em] text-white">
                                            Berita Utama
                                        </span>
                                    </div>

                                </div>
                            </a>
                        @else
                            <div
                                class="aspect-[16/9] rounded-xl border
                                       border-[#d9ddd9] bg-[#eef2ef]
                                       flex items-center justify-center
                                       dark:border-[#2b312d]
                                       dark:bg-[#181c1a]">
                                <span class="font-interface text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada gambar
                                </span>
                            </div>
                        @endif

                    </div>


                    {{-- Hero Information --}}
                    <div class="lg:col-span-4 flex flex-col justify-center">

                        <div class="flex items-center gap-2">
                            <span
                                class="font-interface text-[10px] font-bold
                                       uppercase tracking-[0.12em]
                                       text-[#1C775A]
                                       dark:text-[#53e0a0]">
                                {{ $featuredNews->category->name }}
                            </span>

                            <span class="text-gray-400 dark:text-gray-600">
                                •
                            </span>

                            <span
                                class="font-interface text-xs
                                       text-[#6b7771]
                                       dark:text-[#889990]">
                                {{ $featuredNews->published_at?->format('d M Y') }}
                            </span>
                        </div>


                        <h1
                            class="mt-4 font-editorial text-4xl
                                   leading-[1.08] font-semibold
                                   tracking-[-0.02em]
                                   text-[#15201B]
                                   dark:text-[#e0e3df]
                                   lg:text-[46px]">
                            <a href="{{ route('news.show', $featuredNews->slug) }}"
                                class="transition-colors
                                       hover:text-[#1C775A]
                                       dark:hover:text-[#53e0a0]">
                                {{ $featuredNews->title }}
                            </a>
                        </h1>


                        @if ($featuredNews->excerpt)
                            <p
                                class="mt-5 font-editorial text-lg
                                       leading-8
                                       text-[#5b6761]
                                       dark:text-[#abb6ae]">
                                {{ $featuredNews->excerpt }}
                            </p>
                        @endif


                        <div
                            class="mt-7 pt-5 border-t
                                    border-[#d9ddd9]
                                    dark:border-[#2b312d]">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center
                                           justify-center rounded-full
                                           bg-[#2ec486]
                                           font-interface text-xs font-bold
                                           text-[#003822]">
                                    {{ mb_strtoupper(mb_substr($featuredNews->author->name, 0, 2)) }}
                                </div>

                                <div>
                                    <p
                                        class="font-interface text-sm font-semibold
                                               text-[#15201B]
                                               dark:text-[#e0e3df]">
                                        {{ $featuredNews->author->name }}
                                    </p>

                                    <p
                                        class="mt-0.5 font-interface text-xs
                                               text-[#6b7771]
                                               dark:text-[#889990]">
                                        {{ $featuredNews->published_at?->format('d M Y H:i') }}
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>
        @endif


        {{-- Latest News --}}
        <section class="pb-12 lg:pb-16">

            <div class="flex items-end justify-between gap-4
                       border-b-2 border-[#2ec486] pb-3">

                <div>
                    <p
                        class="font-interface text-[10px] font-bold uppercase
                               tracking-[0.12em]
                               text-[#1C775A]
                               dark:text-[#53e0a0]">
                        Portal Berita
                    </p>

                    <h2
                        class="mt-1 font-editorial text-3xl font-semibold
                               tracking-[-0.015em]
                               text-[#15201B]
                               dark:text-[#e0e3df]">
                        Berita Terkini
                    </h2>
                </div>

                <a href="{{ route('news.index') }}"
                    class="hidden sm:inline-flex
                           font-interface text-sm font-semibold
                           text-[#1C775A]
                           transition-colors
                           hover:text-[#155A44]
                           dark:text-[#53e0a0]
                           dark:hover:text-[#71fcb8]">
                    Lihat semua →
                </a>

            </div>


            @if ($latestNews->isNotEmpty())

                <div class="mt-7 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach ($latestNews as $item)
                        <article
                            class="group overflow-hidden rounded-xl
                                   border border-[#d9ddd9]
                                   bg-white
                                   transition-all duration-300
                                   hover:-translate-y-0.5
                                   hover:border-[#2ec486]/60
                                   hover:shadow-lg
                                   dark:border-[#2b312d]
                                   dark:bg-[#181c1a]">

                            @if ($item->thumbnail)
                                <a href="{{ route('news.show', $item->slug) }}" class="block overflow-hidden">
                                    <div class="aspect-[16/10] overflow-hidden">
                                        <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                            alt="{{ $item->title }}"
                                            class="w-full h-full object-cover
                                                   transition-transform duration-500
                                                   group-hover:scale-[1.025]">
                                    </div>
                                </a>
                            @endif


                            <div class="p-5">

                                <div class="flex items-center gap-2">

                                    <span
                                        class="font-interface text-[10px]
                                               font-bold uppercase
                                               tracking-[0.1em]
                                               text-[#1C775A]
                                               dark:text-[#53e0a0]">
                                        {{ $item->category->name }}
                                    </span>

                                    <span class="text-gray-400 dark:text-gray-600">
                                        •
                                    </span>

                                    <span
                                        class="font-interface text-xs
                                               text-[#6b7771]
                                               dark:text-[#889990]">
                                        {{ $item->published_at?->format('d M Y') }}
                                    </span>

                                </div>


                                <h3
                                    class="mt-3 font-editorial text-2xl
                                           leading-tight font-semibold
                                           text-[#15201B]
                                           dark:text-[#e0e3df]">
                                    <a href="{{ route('news.show', $item->slug) }}"
                                        class="transition-colors
                                               group-hover:text-[#1C775A]
                                               dark:group-hover:text-[#53e0a0]">
                                        {{ $item->title }}
                                    </a>
                                </h3>


                                @if ($item->excerpt)
                                    <p
                                        class="mt-3 font-interface text-sm
                                               leading-6
                                               text-[#5f6b65]
                                               dark:text-[#889990]">
                                        {{ \Illuminate\Support\Str::limit($item->excerpt, 120) }}
                                    </p>
                                @endif


                                <div
                                    class="mt-5 flex items-center justify-between
                                           gap-3 border-t
                                           border-[#d9ddd9]
                                           pt-4
                                           dark:border-[#2b312d]">

                                    <span
                                        class="font-interface text-xs
                                               font-medium
                                               text-[#5f6b65]
                                               dark:text-[#889990]">
                                        {{ $item->author->name }}
                                    </span>

                                    <a href="{{ route('news.show', $item->slug) }}"
                                        class="font-interface text-xs
                                               font-semibold
                                               text-[#1C775A]
                                               dark:text-[#53e0a0]">
                                        Baca →
                                    </a>

                                </div>

                            </div>

                        </article>
                    @endforeach

                </div>
            @else
                <div
                    class="mt-7 rounded-xl border
                           border-[#d9ddd9] p-10 text-center
                           dark:border-[#2b312d]">
                    <p
                        class="font-interface text-sm
                               text-gray-500
                               dark:text-gray-400">
                        Belum ada berita yang dipublikasikan.
                    </p>
                </div>

            @endif


            <div class="mt-7 sm:hidden">
                <a href="{{ route('news.index') }}"
                    class="font-interface text-sm font-semibold
                           text-[#1C775A]
                           dark:text-[#53e0a0]">
                    Lihat semua berita →
                </a>
            </div>

        </section>


        {{-- Categories --}}
        <section class="pb-16">

            <div class="border-t border-[#d9ddd9] pt-8
                       dark:border-[#2b312d]">

                <div class="mb-6">
                    <p
                        class="font-interface text-[10px] font-bold
                               uppercase tracking-[0.12em]
                               text-[#1C775A]
                               dark:text-[#53e0a0]">
                        Jelajahi
                    </p>

                    <h2
                        class="mt-1 font-editorial text-2xl font-semibold
                               text-[#15201B]
                               dark:text-[#e0e3df]">
                        Kategori Berita
                    </h2>
                </div>


                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">

                    @forelse (\App\Models\NewsCategory::orderBy('name')->get() as $category)
                        <a href="{{ route('news.index') }}"
                            class="group flex items-center justify-between
                                   rounded-lg border
                                   border-[#d9ddd9]
                                   bg-[#f8faf8]
                                   px-4 py-4
                                   transition-colors
                                   hover:border-[#2ec486]
                                   hover:bg-[#f0f7f3]
                                   dark:border-[#2b312d]
                                   dark:bg-[#181c1a]
                                   dark:hover:bg-[#1c201e]">
                            <span
                                class="font-interface text-sm font-semibold
                                       text-[#3f4b45]
                                       group-hover:text-[#1C775A]
                                       dark:text-[#c0c9c3]
                                       dark:group-hover:text-[#53e0a0]">
                                {{ $category->name }}
                            </span>

                            <span
                                class="text-[#1C775A] transition-transform
                                       group-hover:translate-x-1
                                       dark:text-[#53e0a0]">
                                →
                            </span>
                        </a>

                    @empty

                        <p
                            class="font-interface text-sm text-gray-500
                                   dark:text-gray-400">
                            Belum ada kategori.
                        </p>
                    @endforelse

                </div>

            </div>

        </section>

    </main>

</x-public-layout>
