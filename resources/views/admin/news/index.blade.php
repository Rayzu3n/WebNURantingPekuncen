<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                News
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Manage published and draft news articles.
            </p>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Header Actions -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    News Management
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Create, edit, and manage portal news.
                </p>
            </div>

            <a href="{{ route('admin.news.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl
                bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                shadow-lg shadow-blue-200/40 transition-all
                hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-xl
                dark:bg-blue-500 dark:shadow-blue-950/20 dark:hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                </svg>

                Add News
            </a>

        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div
                class="flex items-start gap-3 rounded-xl border
                border-green-200 bg-green-50 px-4 py-4
                text-sm text-green-800 shadow-sm
                dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>

                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- News Table -->
        <div
            class="overflow-hidden rounded-2xl border
            border-gray-200 bg-white
            shadow-lg shadow-gray-300/40
            dark:border-gray-800 dark:bg-[#111827]
            dark:shadow-black/20">

            @if ($news->count())

                <div class="overflow-x-auto">

                    <table class="min-w-[900px] w-full text-left">

                        <thead>
                            <tr
                                class="border-b border-gray-200 bg-gray-50/80
                                dark:border-gray-800 dark:bg-gray-900/60">
                                <th
                                    class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Title
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Category
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Author
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Status
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Published
                                </th>

                                <th
                                    class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                            @foreach ($news as $item)
                                <tr class="transition-colors hover:bg-gray-50/80 dark:hover:bg-gray-900/50">

                                    <!-- Title -->
                                    <td class="px-5 py-5">

                                        <div class="max-w-sm">

                                            <p class="font-semibold leading-6 text-gray-900 dark:text-white">
                                                {{ $item->title }}
                                            </p>

                                            @if ($item->excerpt)
                                                <p
                                                    class="mt-1 line-clamp-2 text-sm leading-5 text-gray-500 dark:text-gray-400">
                                                    {{ $item->excerpt }}
                                                </p>
                                            @endif

                                        </div>

                                    </td>

                                    <!-- Category -->
                                    <td class="px-5 py-5">

                                        <span
                                            class="inline-flex items-center rounded-lg
                                            bg-sky-50 px-2.5 py-1 text-xs font-semibold
                                            text-sky-700
                                            dark:bg-sky-500/10 dark:text-sky-400">
                                            {{ $item->category->name }}
                                        </span>

                                    </td>

                                    <!-- Author -->
                                    <td class="px-5 py-5">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full
                                                bg-blue-50 text-xs font-bold text-blue-600
                                                dark:bg-blue-500/10 dark:text-blue-400">
                                                {{ strtoupper(substr($item->author->name, 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">
                                                <p
                                                    class="truncate text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $item->author->name }}
                                                </p>
                                            </div>

                                        </div>

                                    </td>

                                    <!-- Status -->
                                    <td class="px-5 py-5">

                                        @if ($item->status === 'published')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full
                                                bg-green-50 px-2.5 py-1 text-xs font-semibold
                                                text-green-700
                                                dark:bg-green-500/10 dark:text-green-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                                Published
                                            </span>
                                        @elseif ($item->status === 'draft')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full
                                                bg-amber-50 px-2.5 py-1 text-xs font-semibold
                                                text-amber-700
                                                dark:bg-amber-500/10 dark:text-amber-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                Draft
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full
                                                bg-gray-100 px-2.5 py-1 text-xs font-semibold
                                                text-gray-700
                                                dark:bg-gray-700/50 dark:text-gray-300">
                                                <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span>
                                                Archived
                                            </span>
                                        @endif

                                    </td>

                                    <!-- Published -->
                                    <td class="px-5 py-5">

                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ $item->published_at?->format('d M Y') ?? '-' }}
                                        </div>

                                        @if ($item->published_at)
                                            <div class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">
                                                {{ $item->published_at->format('H:i') }}
                                            </div>
                                        @endif

                                    </td>

                                    <!-- Actions -->
                                    <td class="px-5 py-5">

                                        <div class="flex items-center justify-end gap-2">

                                            <a href="{{ route('admin.news.edit', $item) }}"
                                                class="inline-flex items-center rounded-lg border
                                                border-blue-200 bg-blue-50 px-3 py-2
                                                text-xs font-semibold text-blue-700
                                                transition-colors hover:bg-blue-100
                                                dark:border-blue-500/20 dark:bg-blue-500/10
                                                dark:text-blue-400 dark:hover:bg-blue-500/20">
                                                Edit
                                            </a>

                                            <form method="POST" action="{{ route('admin.news.destroy', $item) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="inline-flex items-center rounded-lg border
                                                    border-red-200 bg-red-50 px-3 py-2
                                                    text-xs font-semibold text-red-700
                                                    transition-colors hover:bg-red-100
                                                    dark:border-red-500/20 dark:bg-red-500/10
                                                    dark:text-red-400 dark:hover:bg-red-500/20">
                                                    Delete
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->
                <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800">
                    {{ $news->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="px-6 py-16 text-center">

                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl
                        bg-blue-50 text-blue-600
                        dark:bg-blue-500/10 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 5h16v14H4zM8 9h8M8 13h8M8 17h5" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-base font-semibold text-gray-900 dark:text-white">
                        No news found
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        There are no news articles to display yet.
                    </p>

                    <a href="{{ route('admin.news.create') }}"
                        class="mt-5 inline-flex items-center rounded-xl
                        bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                        transition hover:bg-blue-700
                        dark:bg-blue-500 dark:hover:bg-blue-600">
                        Add your first news
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>
