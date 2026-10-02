<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                Members
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Manage member accounts and membership data.
            </p>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    Member Management
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Manage registered members and their membership status.
                </p>
            </div>

            <a href="{{ route('admin.members.create') }}"
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

                Add Member
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

        <!-- Members Table -->
        <div
            class="overflow-hidden rounded-2xl border
            border-gray-200 bg-white
            shadow-lg shadow-gray-300/40
            dark:border-gray-800 dark:bg-[#111827]
            dark:shadow-black/20">

            @if ($members->count())

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[850px] text-left">

                        <thead>
                            <tr
                                class="border-b border-gray-200 bg-gray-50/80
                                dark:border-gray-800 dark:bg-gray-900/60">
                                <th
                                    class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Member Number
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Member
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Email
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Status
                                </th>

                                <th
                                    class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                            @foreach ($members as $member)
                                <tr class="transition-colors hover:bg-gray-50/80 dark:hover:bg-gray-900/50">

                                    <!-- Member Number -->
                                    <td class="px-5 py-5">

                                        <code
                                            class="rounded-lg bg-blue-50 px-2.5 py-1.5
                                            text-xs font-semibold text-blue-700
                                            dark:bg-blue-500/10 dark:text-blue-400">
                                            {{ $member->member_number }}
                                        </code>

                                    </td>

                                    <!-- Member -->
                                    <td class="px-5 py-5">

                                        <div class="flex items-center gap-3">

                                            @if ($member->photo)
                                                <img src="{{ asset('storage/' . $member->photo) }}"
                                                    alt="{{ $member->user->name }}"
                                                    class="h-10 w-10 shrink-0 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                                            @else
                                                <div
                                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full
                                                    bg-blue-50 text-sm font-bold text-blue-600
                                                    dark:bg-blue-500/10 dark:text-blue-400">
                                                    {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                                </div>
                                            @endif

                                            <div class="min-w-0">

                                                <p class="truncate font-semibold text-gray-900 dark:text-white">
                                                    {{ $member->user->name }}
                                                </p>

                                                <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">
                                                    {{ $member->nik }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    <!-- Email -->
                                    <td class="px-5 py-5">

                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ $member->user->email }}
                                        </p>

                                    </td>

                                    <!-- Status -->
                                    <td class="px-5 py-5">

                                        @if ($member->status === 'active')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full
                                                bg-green-50 px-2.5 py-1 text-xs font-semibold
                                                text-green-700
                                                dark:bg-green-500/10 dark:text-green-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full
                                                bg-gray-100 px-2.5 py-1 text-xs font-semibold
                                                text-gray-700
                                                dark:bg-gray-700/50 dark:text-gray-300">
                                                <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span>
                                                Inactive
                                            </span>
                                        @endif

                                    </td>

                                    <!-- Actions -->
                                    <td class="px-5 py-5">

                                        <div class="flex items-center justify-end gap-2">

                                            <a href="{{ route('admin.members.edit', $member) }}"
                                                class="inline-flex items-center rounded-lg border
                                                border-blue-200 bg-blue-50 px-3 py-2
                                                text-xs font-semibold text-blue-700
                                                transition-colors hover:bg-blue-100
                                                dark:border-blue-500/20 dark:bg-blue-500/10
                                                dark:text-blue-400 dark:hover:bg-blue-500/20">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                action="{{ route('admin.members.destroy', $member) }}">
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
                    {{ $members->links() }}
                </div>
            @else
                <!-- Empty -->
                <div class="px-6 py-16 text-center">

                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl
                        bg-blue-50 text-blue-600
                        dark:bg-blue-500/10 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-base font-semibold text-gray-900 dark:text-white">
                        No members found
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Create a member account to start managing membership data.
                    </p>

                    <a href="{{ route('admin.members.create') }}"
                        class="mt-5 inline-flex items-center rounded-xl
                        bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                        transition hover:bg-blue-700
                        dark:bg-blue-500 dark:hover:bg-blue-600">
                        Add your first member
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>
