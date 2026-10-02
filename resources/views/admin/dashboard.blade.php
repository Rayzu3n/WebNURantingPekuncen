<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                Admin Dashboard
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Manage portal content and members.
            </p>
        </div>
    </x-slot>

    <div class="space-y-8">

        <!-- Welcome -->
        <section>
            <div
                class="overflow-hidden rounded-2xl border
                border-blue-100 bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-700
                px-6 py-7 text-white shadow-lg shadow-blue-200/50
                dark:border-blue-400/10 dark:from-[#172554] dark:via-[#172554] dark:to-[#164E63]
                dark:shadow-black/30
                sm:px-8">
                <p class="text-sm font-medium text-blue-100">
                    Welcome back
                </p>

                <h1 class="mt-2 text-2xl font-semibold tracking-tight">
                    {{ auth()->user()->name }}
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-blue-100">
                    Manage news, categories, and member data from this dashboard.
                </p>
            </div>
        </section>

        <!-- Statistics -->
        <section>

            <div class="grid gap-5 md:grid-cols-3">

                <!-- News -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6
                    shadow-lg shadow-gray-300/40
                    transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl
                    dark:border-gray-800 dark:bg-[#111827]
                    dark:shadow-black/20">
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Total News
                            </p>

                            <p class="mt-3 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                {{ $newsCount }}
                            </p>
                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl
                            bg-blue-50 text-blue-600
                            dark:bg-blue-500/10 dark:text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 5h16v14H4zM8 9h8M8 13h8M8 17h5" />
                            </svg>
                        </div>

                    </div>

                    <a href="{{ route('admin.news.index') }}"
                        class="mt-5 inline-flex items-center text-sm font-semibold
                        text-blue-600 transition-colors hover:text-blue-700
                        dark:text-blue-400 dark:hover:text-blue-300">
                        Manage news
                        <span class="ml-1">→</span>
                    </a>
                </div>

                <!-- Members -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6
                    shadow-lg shadow-gray-300/40
                    transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl
                    dark:border-gray-800 dark:bg-[#111827]
                    dark:shadow-black/20">
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Total Members
                            </p>

                            <p class="mt-3 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                {{ $memberCount }}
                            </p>
                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl
                            bg-cyan-50 text-cyan-600
                            dark:bg-cyan-500/10 dark:text-cyan-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                            </svg>
                        </div>

                    </div>

                    <a href="{{ route('admin.members.index') }}"
                        class="mt-5 inline-flex items-center text-sm font-semibold
                        text-cyan-600 transition-colors hover:text-cyan-700
                        dark:text-cyan-400 dark:hover:text-cyan-300">
                        Manage members
                        <span class="ml-1">→</span>
                    </a>
                </div>

                <!-- Categories -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6
                    shadow-lg shadow-gray-300/40
                    transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl
                    dark:border-gray-800 dark:bg-[#111827]
                    dark:shadow-black/20">
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Categories
                            </p>

                            <p class="mt-3 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                {{ $categoryCount }}
                            </p>
                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl
                            bg-sky-50 text-sky-600
                            dark:bg-sky-500/10 dark:text-sky-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 6h6v6H4zM14 6h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" />
                            </svg>
                        </div>

                    </div>

                    <a href="{{ route('admin.categories.index') }}"
                        class="mt-5 inline-flex items-center text-sm font-semibold
                        text-sky-600 transition-colors hover:text-sky-700
                        dark:text-sky-400 dark:hover:text-sky-300">
                        Manage categories
                        <span class="ml-1">→</span>
                    </a>
                </div>

            </div>

        </section>

        <!-- Management -->
        <section>

            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Management
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Access the main administration sections.
                </p>
            </div>

            <div class="grid gap-5 md:grid-cols-3">

                <!-- News -->
                <a href="{{ route('admin.news.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-6
                    shadow-lg shadow-gray-300/40
                    transition-all duration-200
                    hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl
                    dark:border-gray-800 dark:bg-[#111827]
                    dark:shadow-black/20 dark:hover:border-blue-500/30">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl
                        bg-blue-50 text-blue-600
                        transition-colors
                        group-hover:bg-blue-600 group-hover:text-white
                        dark:bg-blue-500/10 dark:text-blue-400
                        dark:group-hover:bg-blue-500 dark:group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 5h16v14H4zM8 9h8M8 13h8M8 17h5" />
                        </svg>
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900 dark:text-white">
                        News
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
                        Create, edit, publish, and manage portal news.
                    </p>

                    <span class="mt-4 inline-block text-sm font-semibold text-blue-600 dark:text-blue-400">
                        Open section →
                    </span>
                </a>

                <!-- Categories -->
                <a href="{{ route('admin.categories.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-6
                    shadow-lg shadow-gray-300/40
                    transition-all duration-200
                    hover:-translate-y-1 hover:border-sky-200 hover:shadow-xl
                    dark:border-gray-800 dark:bg-[#111827]
                    dark:shadow-black/20 dark:hover:border-sky-500/30">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl
                        bg-sky-50 text-sky-600
                        transition-colors
                        group-hover:bg-sky-600 group-hover:text-white
                        dark:bg-sky-500/10 dark:text-sky-400
                        dark:group-hover:bg-sky-500 dark:group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6h6v6H4zM14 6h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" />
                        </svg>
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900 dark:text-white">
                        Categories
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
                        Organize news content into categories.
                    </p>

                    <span class="mt-4 inline-block text-sm font-semibold text-sky-600 dark:text-sky-400">
                        Open section →
                    </span>
                </a>

                <!-- Members -->
                <a href="{{ route('admin.members.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-6
                    shadow-lg shadow-gray-300/40
                    transition-all duration-200
                    hover:-translate-y-1 hover:border-cyan-200 hover:shadow-xl
                    dark:border-gray-800 dark:bg-[#111827]
                    dark:shadow-black/20 dark:hover:border-cyan-500/30">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl
                        bg-cyan-50 text-cyan-600
                        transition-colors
                        group-hover:bg-cyan-600 group-hover:text-white
                        dark:bg-cyan-500/10 dark:text-cyan-400
                        dark:group-hover:bg-cyan-500 dark:group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                        </svg>
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900 dark:text-white">
                        Members
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
                        Manage member accounts and membership data.
                    </p>

                    <span class="mt-4 inline-block text-sm font-semibold text-cyan-600 dark:text-cyan-400">
                        Open section →
                    </span>
                </a>

            </div>

        </section>

    </div>

</x-app-layout>
