<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                Member Profile
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                View and update your membership information.
            </p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl">

        @if (session('success'))
            <div
                class="mb-6 flex items-start gap-3 rounded-xl border
                border-green-200 bg-green-50 px-4 py-4
                text-sm text-green-800 shadow-sm
                dark:border-green-500/20 dark:bg-green-500/10
                dark:text-green-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>

                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div
            class="overflow-hidden rounded-2xl border
            border-gray-200 bg-white
            shadow-lg shadow-gray-300/40
            dark:border-gray-800 dark:bg-[#111827]
            dark:shadow-black/20">

            <!-- Profile Header -->
            <div
                class="border-b border-gray-200 bg-gray-50/70 px-6 py-6
                dark:border-gray-800 dark:bg-gray-900/40
                sm:px-8">
                <div class="flex items-center gap-4">

                    @if ($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->user->name }}"
                            class="h-16 w-16 rounded-2xl object-cover border border-gray-200 shadow-sm dark:border-gray-700">
                    @else
                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-2xl
                            bg-blue-50 text-xl font-bold text-blue-600
                            dark:bg-blue-500/10 dark:text-blue-400">
                            {{ strtoupper(substr($member->user->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="min-w-0">
                        <h1 class="truncate text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $member->user->name }}
                        </h1>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Member Number:
                            <span class="font-semibold text-gray-700 dark:text-gray-300">
                                {{ $member->member_number }}
                            </span>
                        </p>
                    </div>

                </div>
            </div>

            <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="space-y-8 px-6 py-6 sm:px-8 sm:py-8">

                    <!-- Photo -->
                    <section>

                        <div class="mb-5">
                            <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                                Profile Photo
                            </h2>
                        </div>

                        @if ($member->photo)
                            <div
                                class="mb-4 rounded-xl border
                                border-gray-200 bg-gray-50 p-4
                                dark:border-gray-700 dark:bg-gray-900/50">
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->user->name }}"
                                    class="h-36 w-36 rounded-xl object-cover border border-gray-200 shadow-sm dark:border-gray-700">
                            </div>
                        @endif

                        <div
                            class="rounded-xl border border-dashed
                            border-gray-300 bg-gray-50 p-5
                            dark:border-gray-700 dark:bg-gray-900/50">
                            <input id="photo" type="file" name="photo" accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm text-gray-600
                                file:mr-4 file:rounded-lg file:border-0
                                file:bg-blue-50 file:px-4 file:py-2
                                file:text-sm file:font-semibold file:text-blue-700
                                hover:file:bg-blue-100
                                dark:text-gray-400
                                dark:file:bg-blue-500/10 dark:file:text-blue-400
                                dark:hover:file:bg-blue-500/20">

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                JPG, JPEG, PNG, or WebP. Maximum 2 MB.
                            </p>
                        </div>

                        <x-input-error :messages="$errors->get('photo')" class="mt-2" />

                    </section>

                    <!-- Identity -->
                    <section>

                        <div class="mb-5">
                            <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                                Identity
                            </h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">

                            <div>
                                <x-input-label for="nik" value="NIK" />

                                <x-text-input id="nik" class="mt-2 block w-full" type="text" name="nik"
                                    :value="old('nik', $member->nik)" required />

                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="phone" value="Phone" />

                                <x-text-input id="phone" class="mt-2 block w-full" type="text" name="phone"
                                    :value="old('phone', $member->phone)" />

                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="birth_place" value="Birth Place" />

                                <x-text-input id="birth_place" class="mt-2 block w-full" type="text"
                                    name="birth_place" :value="old('birth_place', $member->birth_place)" required />

                                <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="birth_date" value="Birth Date" />

                                <x-text-input id="birth_date" class="mt-2 block w-full" type="date" name="birth_date"
                                    :value="old('birth_date', $member->birth_date?->format('Y-m-d'))" required />

                                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="gender" value="Gender" />

                                <select id="gender" name="gender"
                                    class="mt-2 block w-full rounded-xl border-gray-300 bg-white
                                    px-4 py-2.5 text-sm text-gray-900 shadow-sm
                                    focus:border-blue-500 focus:ring-blue-500
                                    dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                    dark:focus:border-blue-400 dark:focus:ring-blue-400"
                                    required>
                                    <option value="L" @selected(old('gender', $member->gender) === 'L')>
                                        Laki-laki
                                    </option>

                                    <option value="P" @selected(old('gender', $member->gender) === 'P')>
                                        Perempuan
                                    </option>
                                </select>

                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                        </div>

                    </section>

                    <!-- Address -->
                    <section>

                        <div class="mb-5">
                            <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                                Address
                            </h2>
                        </div>

                        <textarea id="address" name="address" rows="5"
                            class="block w-full rounded-xl border-gray-300 bg-white
                            px-4 py-3 text-sm leading-6 text-gray-900 shadow-sm
                            focus:border-blue-500 focus:ring-blue-500
                            dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                            dark:focus:border-blue-400 dark:focus:ring-blue-400"
                            required>{{ old('address', $member->address) }}</textarea>

                        <x-input-error :messages="$errors->get('address')" class="mt-2" />

                    </section>

                </div>

                <!-- Footer -->
                <div
                    class="flex justify-end border-t border-gray-200
                    bg-gray-50/70 px-6 py-5
                    dark:border-gray-800 dark:bg-gray-900/40
                    sm:px-8">
                    <x-primary-button
                        class="rounded-xl bg-blue-600 px-5 py-2.5
                        shadow-lg shadow-blue-200/40
                        hover:bg-blue-700
                        dark:bg-blue-500 dark:shadow-blue-950/20
                        dark:hover:bg-blue-600">
                        Save Changes
                    </x-primary-button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>
