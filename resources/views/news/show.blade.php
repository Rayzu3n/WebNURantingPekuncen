<x-public-layout>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">

        {{-- Article Header --}}
        <article>

            <div class="max-w-4xl">

                <div class="flex flex-wrap items-center gap-2">

                    <span
                        class="font-interface text-[10px] font-bold uppercase
                               tracking-[0.1em]
                               text-[#1C775A]
                               dark:text-[#53e0a0]"
                    >
                        {{ $news->category->name }}
                    </span>

                    <span class="text-gray-400 dark:text-gray-600">
                        •
                    </span>

                    <span
                        class="font-interface text-xs
                               text-[#6b7771]
                               dark:text-[#889990]"
                    >
                        {{ $news->published_at?->format('d M Y H:i') }}
                    </span>

                </div>


                <h1
                    class="mt-5 font-editorial text-4xl sm:text-5xl lg:text-6xl
                           leading-[1.05]
                           font-semibold tracking-[-0.025em]
                           text-[#15201B]
                           dark:text-[#e0e3df]"
                >
                    {{ $news->title }}
                </h1>


                @if ($news->excerpt)

                    <p
                        class="mt-6 max-w-3xl
                               font-editorial text-xl
                               leading-8
                               text-[#5b6761]
                               dark:text-[#abb6ae]"
                    >
                        {{ $news->excerpt }}
                    </p>

                @endif


                {{-- Author --}}
                <div
                    class="mt-7 pt-5
                           border-t border-[#d9ddd9]
                           dark:border-[#2b312d]"
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 shrink-0
                                   items-center justify-center
                                   rounded-full bg-[#2ec486]
                                   font-interface text-xs font-bold
                                   text-[#003822]"
                        >
                            {{ mb_strtoupper(mb_substr($news->author->name, 0, 2)) }}
                        </div>

                        <div>

                            <p
                                class="font-interface text-sm font-semibold
                                       text-[#15201B]
                                       dark:text-[#e0e3df]"
                            >
                                {{ $news->author->name }}
                            </p>

                            <p
                                class="mt-0.5 font-interface text-xs
                                       text-[#6b7771]
                                       dark:text-[#889990]"
                            >
                                {{ $news->published_at?->format('d M Y H:i') }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Featured Image --}}
            @if ($news->thumbnail)

                <div
                    class="mt-8 overflow-hidden rounded-xl
                           border border-[#d9ddd9]
                           dark:border-[#2b312d]"
                >
                    <img
                        src="{{ asset('storage/' . $news->thumbnail) }}"
                        alt="{{ $news->title }}"
                        class="w-full max-h-[650px] object-cover"
                    >
                </div>

            @endif


            {{-- Article Content --}}
            <div class="mt-10 max-w-4xl">

                <div
                    class="font-editorial text-lg sm:text-xl
                           leading-8 sm:leading-9
                           text-[#27332d]
                           dark:text-[#d0d8d2]"
                >
                    {!! nl2br(e($news->content)) !!}
                </div>

            </div>


            {{-- Back --}}
            <div
                class="mt-10 pt-6
                       border-t border-[#d9ddd9]
                       dark:border-[#2b312d]"
            >

                <a
                    href="{{ route('news.index') }}"
                    class="inline-flex items-center gap-2
                           font-interface text-sm font-semibold
                           text-[#1C775A]
                           hover:text-[#155A44]
                           dark:text-[#53e0a0]
                           dark:hover:text-[#71fcb8]"
                >
                    ← Kembali ke berita
                </a>

            </div>

        </article>

    </main>

</x-public-layout>