<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                Member Dashboard
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Access your member profile and digital member card.
            </p>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Welcome -->
        <section
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
                Manage your member information and access your digital member card.
            </p>
        </section>

        <!-- Member Actions -->
        <section>

            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Member Area
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Manage your membership information.
                </p>
            </div>

            <div class="grid gap-5 md:grid-cols-2">

                <!-- Profile -->
                <a href="{{ route('member.profile') }}"
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
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0116.5 0" />
                        </svg>
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900 dark:text-white">
                        Member Profile
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
                        View and update your personal membership information.
                    </p>

                    <span class="mt-4 inline-block text-sm font-semibold text-blue-600 dark:text-blue-400">
                        Open profile →
                    </span>

                </a>

                <!-- Member Card -->
                <a href="{{ route('member.card') }}"
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
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 9h4M7 13h3" />
                        </svg>
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900 dark:text-white">
                        Member Card
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
                        View, verify, and download your digital member card.
                    </p>

                    <span class="mt-4 inline-block text-sm font-semibold text-cyan-600 dark:text-cyan-400">
                        Open member card →
                    </span>

                </a>

            </div>

        </section>

    </div>

</x-app-layout>
