<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                Member Card
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                View and download your digital member card.
            </p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl">

        <!-- Card Preview -->
        <div
            class="overflow-hidden rounded-2xl border
            border-gray-200 bg-white
            p-4 shadow-lg shadow-gray-300/40
            dark:border-gray-800 dark:bg-[#111827]
            dark:shadow-black/20
            sm:p-6">

            <div class="mb-5 flex items-center justify-between gap-4">

                <div>
                    <h1 class="text-base font-semibold text-gray-900 dark:text-white">
                        Digital Member Card
                    </h1>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        This card can be verified using its QR code.
                    </p>
                </div>

                <span
                    class="hidden rounded-full bg-green-50 px-3 py-1.5
                    text-xs font-semibold text-green-700
                    dark:bg-green-500/10 dark:text-green-400 sm:inline-flex">
                    {{ ucfirst($member->status) }}
                </span>

            </div>

            <!-- CARD EXPORT AREA -->
            <div id="member-card" data-member-number="{{ $member->member_number }}"
                class="overflow-hidden rounded-2xl border border-gray-200
                bg-white text-gray-900 shadow-xl">

                <!-- Card Accent -->
                <div class="h-2 bg-gradient-to-r from-green-700 via-blue-600 to-cyan-500"></div>

                <div class="p-6 sm:p-8">

                    <!-- Header -->
                    <div class="flex items-start justify-between gap-5">

                        <div class="min-w-0">

                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">
                                ORGANISATION
                            </p>

                            <h1 class="mt-2 text-2xl font-bold tracking-tight text-gray-900">
                                NU MEMBER CARD
                            </h1>

                            <p class="mt-1 text-sm text-gray-500">
                                Digital Membership Identification
                            </p>

                        </div>

                        @if ($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->user->name }}"
                                class="h-24 w-24 shrink-0 rounded-xl border border-gray-200 object-cover shadow-sm">
                        @endif

                    </div>

                    <!-- Information -->
                    <div class="mt-8 grid gap-x-6 gap-y-5 sm:grid-cols-2">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                                Member Number
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $member->member_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                                Name
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $member->user->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                                Birth
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $member->birth_place }},
                                {{ $member->birth_date?->format('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                                Gender
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $member->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </p>
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                                Address
                            </p>

                            <p class="mt-1 font-semibold leading-6 text-gray-900">
                                {{ $member->address }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                                Status
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ ucfirst($member->status) }}
                            </p>
                        </div>

                    </div>

                    <!-- QR -->
                    <div class="mt-8 flex justify-center">

                        <div class="text-center">

                            <div class="inline-flex rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
                                <img src="{{ $qrCode }}" alt="Member verification QR Code" class="h-32 w-32">
                            </div>

                            <p class="mt-3 text-xs text-gray-500">
                                Scan to verify membership
                            </p>

                        </div>

                    </div>

                </div>

                <!-- Footer Accent -->
                <div class="border-t border-gray-200 bg-gray-50 px-6 py-3 text-center">
                    <p class="text-[10px] font-medium uppercase tracking-[0.2em] text-gray-400">
                        Official Digital Membership Card
                    </p>
                </div>

            </div>

            <!-- Download -->
            <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:justify-end">

                <button type="button" onclick="downloadMemberCard('png')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl
                    bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                    shadow-lg shadow-blue-200/40 transition
                    hover:bg-blue-700
                    dark:bg-blue-500 dark:shadow-blue-950/20
                    dark:hover:bg-blue-600">
                    Download PNG
                </button>

                <button type="button" onclick="downloadMemberCard('jpg')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl
                    border border-gray-300 bg-white px-4 py-2.5
                    text-sm font-semibold text-gray-700 transition
                    hover:bg-gray-50
                    dark:border-gray-700 dark:bg-gray-800
                    dark:text-gray-300 dark:hover:bg-gray-700">
                    Download JPG
                </button>

            </div>

        </div>

    </div>

</x-app-layout>
