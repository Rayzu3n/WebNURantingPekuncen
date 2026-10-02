<x-public-layout>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">

        {{-- Page Header --}}
        <section class="border-b-2 border-[#2ec486] pb-5">

            <p
                class="font-interface text-[10px] font-bold uppercase
                       tracking-[0.12em]
                       text-[#1C775A]
                       dark:text-[#53e0a0]"
            >
                Portal Berita
            </p>

            <h1
                class="mt-2 font-editorial text-4xl lg:text-5xl
                       font-semibold tracking-[-0.02em]
                       text-[#15201B]
                       dark:text-[#e0e3df]"
            >
                Berita
            </h1>

            <p
                class="mt-3 max-w-2xl font-interface text-sm leading-6
                       text-[#68746e]
                       dark:text-[#929e97]"
            >
                Informasi dan berita terbaru dari lingkungan NU.
            </p>

        </section>


        {{-- News List --}}
        @if ($news->isNotEmpty())

            <section class="mt-8">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach ($news as $item)

                        <article
                            class="group flex flex-col overflow-hidden rounded-xl
                                   border border-[#d9ddd9]
                                   bg-white
                                   transition-all duration-300
                                   hover:-translate-y-0.5
                                   hover:border-[#2ec486]/70
                                   hover:shadow-lg
                                   dark:border-[#2b312d]
                                   dark:bg-[#181c1a]"
                        >

                            {{-- Thumbnail --}}
                            @if ($item->thumbnail)

                                <a
                                    href="{{ route('news.show', $item->slug) }}"
                                    class="block overflow-hidden"
                                >
                                    <div class="aspect-[16/10] overflow-hidden">

                                        <img
                                            src="{{ asset('storage/' . $item->thumbnail) }}"
                                            alt="{{ $item->title }}"
                                            class="w-full h-full object-cover
                                                   transition-transform duration-500
                                                   group-hover:scale-[1.025]"
                                        >

                                    </div>
                                </a>

                            @endif


                            {{-- Content --}}
                            <div class="flex flex-col flex-1 p-5">

                                <div class="flex items-center gap-2">

                                    <span
                                        class="font-interface text-[10px]
                                               font-bold uppercase
                                               tracking-[0.1em]
                                               text-[#1C775A]
                                               dark:text-[#53e0a0]"
                                    >
                                        {{ $item->category->name }}
                                    </span>

                                    <span class="text-gray-400 dark:text-gray-600">
                                        •
                                    </span>

                                    <span
                                        class="font-interface text-xs
                                               text-[#6b7771]
                                               dark:text-[#889990]"
                                    >
                                        {{ $item->published_at?->format('d M Y') }}
                                    </span>

                                </div>


                                <h2
                                    class="mt-3 font-editorial text-2xl
                                           leading-tight font-semibold
                                           text-[#15201B]
                                           dark:text-[#e0e3df]"
                                >
                                    <a
                                        href="{{ route('news.show', $item->slug) }}"
                                        class="transition-colors
                                               group-hover:text-[#1C775A]
                                               dark:group-hover:text-[#53e0a0]"
                                    >
                                        {{ $item->title }}
                                    </a>
                                </h2>


                                @if ($item->excerpt)

                                    <p
                                        class="mt-3 font-interface text-sm
                                               leading-6
                                               text-[#5f6b65]
                                               dark:text-[#889990]"
                                    >
                                        {{ \Illuminate\Support\Str::limit($item->excerpt, 140) }}
                                    </p>

                                @endif


                                <div
                                    class="mt-auto pt-5
                                           border-t border-[#d9ddd9]
                                           dark:border-[#2b312d]"
                                >

                                    <div class="flex items-center justify-between gap-3">

                                        <span
                                            class="font-interface text-xs font-medium
                                                   text-[#5f6b65]
                                                   dark:text-[#889990]"
                                        >
                                            {{ $item->author->name }}
                                        </span>

                                        <a
                                            href="{{ route('news.show', $item->slug) }}"
                                            class="font-interface text-xs font-semibold
                                                   text-[#1C775A]
                                                   dark:text-[#53e0a0]"
                                        >
                                            Baca berita →
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $news->links() }}
                </div>

            </section>

        @else

            <section class="mt-8">

                <div
                    class="rounded-xl border border-[#d9ddd9]
                           p-10 text-center
                           dark:border-[#2b312d]"
                >
                    <p
                        class="font-interface text-sm
                               text-[#68746e]
                               dark:text-[#929e97]"
                    >
                        Belum ada berita yang dipublikasikan.
                    </p>
                </div>

            </section>

        @endif

    </main>

</x-public-layout>