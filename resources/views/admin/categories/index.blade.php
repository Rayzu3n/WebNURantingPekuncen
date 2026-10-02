<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                News Categories
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Organize news content into manageable categories.
            </p>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    Category Management
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Create and manage categories used by portal news.
                </p>
            </div>

            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl
                bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                shadow-lg shadow-blue-200/40 transition-all
                hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-xl
                dark:bg-blue-500 dark:shadow-blue-950/20
                dark:hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                </svg>

                Add Category
            </a>

        </div>

        <!-- Success -->
        @if (session('success'))
            <div
                class="flex items-start gap-3 rounded-xl border
                border-green-200 bg-green-50 px-4 py-4
                text-sm text-green-800 shadow-sm
                dark:border-green-500/20 dark:bg-green-500/10
                dark:text-green-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>

                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Category Table -->
        <div
            class="overflow-hidden rounded-2xl border
            border-gray-200 bg-white
            shadow-lg shadow-gray-300/40
            dark:border-gray-800 dark:bg-[#111827]
            dark:shadow-black/20">

            @if ($categories->count())

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[650px] text-left">

                        <thead>
                            <tr
                                class="border-b border-gray-200 bg-gray-50/80
                                dark:border-gray-800 dark:bg-gray-900/60">
                                <th
                                    class="w-16 px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    #
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Name
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Slug
                                </th>

                                <th
                                    class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                            @foreach ($categories as $category)
                                <tr class="transition-colors hover:bg-gray-50/80 dark:hover:bg-gray-900/50">

                                    <td class="px-5 py-5 text-sm font-medium text-gray-400 dark:text-gray-500">
                                        {{ $categories->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-5 py-5">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center
                                                rounded-xl bg-blue-50 text-blue-600
                                                dark:bg-blue-500/10 dark:text-blue-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 6h6v6H4zM14 6h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" />
                                                </svg>
                                            </div>

                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $category->name }}
                                                </p>

                                                <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">
                                                    News category
                                                </p>
                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-5 py-5">

                                        <code
                                            class="rounded-lg bg-gray-100 px-2.5 py-1.5
                                            text-xs font-medium text-gray-700
                                            dark:bg-gray-800 dark:text-gray-300">
                                            {{ $category->slug }}
                                        </code>

                                    </td>

                                    <td class="px-5 py-5">

                                        <div class="flex items-center justify-end gap-2">

                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                class="inline-flex items-center rounded-lg border
                                                border-blue-200 bg-blue-50 px-3 py-2
                                                text-xs font-semibold text-blue-700
                                                transition-colors hover:bg-blue-100
                                                dark:border-blue-500/20 dark:bg-blue-500/10
                                                dark:text-blue-400 dark:hover:bg-blue-500/20">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                action="{{ route('admin.categories.destroy', $category) }}">
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
                    {{ $categories->links() }}
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
                                d="M4 6h6v6H4zM14 6h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-base font-semibold text-gray-900 dark:text-white">
                        No categories found
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Create a category to start organizing your news.
                    </p>

                    <a href="{{ route('admin.categories.create') }}"
                        class="mt-5 inline-flex items-center rounded-xl
                        bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                        transition hover:bg-blue-700
                        dark:bg-blue-500 dark:hover:bg-blue-600">
                        Add your first category
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>
