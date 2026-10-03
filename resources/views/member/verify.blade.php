<x-public-layout>

    <div class="py-12 sm:py-16">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl
                    bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m5.5 2a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0z" />
                    </svg>
                </div>

                <p class="mt-4 text-sm font-semibold uppercase tracking-[0.16em] text-green-700 dark:text-green-400">
                    Membership Verification
                </p>

                <h1 class="mt-2 font-editorial text-3xl font-semibold tracking-tight text-[#15201B] dark:text-white">
                    Member Verification
                </h1>

                <p class="mt-2 text-sm text-[#68736E] dark:text-[#9DAAA2]">
                    Membership information for the submitted member number.
                </p>
            </div>

            <div
                class="overflow-hidden rounded-2xl border border-[#CFD0C3] bg-white
                shadow-lg shadow-gray-300/40 dark:border-[#2b312d] dark:bg-[#181c1a]
                dark:shadow-black/20">
                <div class="p-6 sm:p-8">
                    <div class="text-center">
                        <div
                            class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl
                            bg-green-50 text-2xl font-bold text-green-700
                            dark:bg-green-500/10 dark:text-green-400">
                            {{ strtoupper(substr($member->user->name, 0, 1)) }}
                        </div>

                        <h2 class="mt-5 text-2xl font-semibold text-[#15201B] dark:text-white">
                            {{ $member->user->name }}
                        </h2>

                        <p class="mt-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ $member->member_number }}
                        </p>
                    </div>

                    <div class="mt-8 flex justify-center">
                        @if ($member->status === 'active')
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1.5
                                text-xs font-semibold text-green-700 dark:bg-green-500/10 dark:text-green-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                Active Member
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1.5
                                text-xs font-semibold text-gray-700 dark:bg-gray-700/50 dark:text-gray-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span>
                                Inactive Member
                            </span>
                        @endif
                    </div>

                    <div class="mt-8 border-t border-gray-200 pt-8 dark:border-gray-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                            Verification Status
                        </p>

                        <p class="mt-2 text-sm text-[#68736E] dark:text-[#9DAAA2]">
                            This member number belongs to a registered member of the organization.
                        </p>
                    </div>
                </div>

                <div
                    class="border-t border-gray-200 bg-gray-50/70 px-6 py-4 text-center
                    dark:border-gray-800 dark:bg-gray-900/40">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Only information necessary for membership verification is displayed.
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-public-layout>
