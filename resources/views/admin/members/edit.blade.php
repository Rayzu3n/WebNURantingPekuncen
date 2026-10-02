<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                Edit Member
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Update member account and membership information.
            </p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl">

        <div
            class="overflow-hidden rounded-2xl border
            border-gray-200 bg-white
            shadow-lg shadow-gray-300/40
            dark:border-gray-800 dark:bg-[#111827]
            dark:shadow-black/20">

            <!-- Header -->
            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800 sm:px-8">

                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Member Information
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Update the information for this member.
                </p>

            </div>

            <form method="POST" action="{{ route('admin.members.update', $member) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-8 px-6 py-6 sm:px-8 sm:py-8">

                    <!-- Account -->
                    <section>

                        <div class="mb-5">
                            <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                                Account
                            </h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" value="Name" />

                                <x-text-input id="name" class="mt-2 block w-full" type="text" name="name"
                                    :value="old('name', $member->user->name)" required autofocus />

                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" value="Email" />

                                <x-text-input id="email" class="mt-2 block w-full" type="email" name="email"
                                    :value="old('email', $member->user->email)" required />

                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                        </div>

                    </section>

                    <!-- Membership -->
                    <section>

                        <div class="mb-5">
                            <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                                Membership
                            </h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">

                            <!-- Member Number -->
                            <div>
                                <x-input-label for="member_number" value="Member Number" />

                                <x-text-input id="member_number" class="mt-2 block w-full" type="text"
                                    name="member_number" :value="old('member_number', $member->member_number)" required />

                                <x-input-error :messages="$errors->get('member_number')" class="mt-2" />
                            </div>

                            <!-- NIK -->
                            <div>
                                <x-input-label for="nik" value="NIK" />

                                <x-text-input id="nik" class="mt-2 block w-full" type="text" name="nik"
                                    :value="old('nik', $member->nik)" required />

                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                            </div>

                            <!-- Birth Place -->
                            <div>
                                <x-input-label for="birth_place" value="Birth Place" />

                                <x-text-input id="birth_place" class="mt-2 block w-full" type="text"
                                    name="birth_place" :value="old('birth_place', $member->birth_place)" required />

                                <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <x-input-label for="birth_date" value="Birth Date" />

                                <x-text-input id="birth_date" class="mt-2 block w-full" type="date" name="birth_date"
                                    :value="old('birth_date', $member->birth_date?->format('Y-m-d'))" required />

                                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                            </div>

                            <!-- Gender -->
                            <div>
                                <x-input-label for="gender" value="Gender" />

                                <select id="gender" name="gender"
                                    class="mt-2 block w-full rounded-xl border-gray-300 bg-white
                                    px-4 py-2.5 text-sm text-gray-900 shadow-sm
                                    transition focus:border-blue-500 focus:ring-blue-500
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

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone" value="Phone" />

                                <x-text-input id="phone" class="mt-2 block w-full" type="text" name="phone"
                                    :value="old('phone', $member->phone)" />

                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                        </div>

                        <!-- Address -->
                        <div class="mt-6">

                            <x-input-label for="address" value="Address" />

                            <textarea id="address" name="address" rows="4"
                                class="mt-2 block w-full rounded-xl border-gray-300 bg-white
                                px-4 py-3 text-sm leading-6 text-gray-900 shadow-sm
                                placeholder:text-gray-400
                                transition focus:border-blue-500 focus:ring-blue-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                dark:placeholder:text-gray-500
                                dark:focus:border-blue-400 dark:focus:ring-blue-400"
                                required>{{ old('address', $member->address) }}</textarea>

                            <x-input-error :messages="$errors->get('address')" class="mt-2" />

                        </div>

                    </section>

                    <!-- Profile -->
                    <section>

                        <div class="mb-5">
                            <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                                Profile
                            </h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">

                            <!-- Photo -->
                            <div>

                                <x-input-label for="photo" value="Photo" />

                                @if ($member->photo)
                                    <div
                                        class="mt-2 overflow-hidden rounded-xl border
                                        border-gray-200 bg-gray-50 p-4
                                        dark:border-gray-700 dark:bg-gray-900/50">

                                        <p
                                            class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Current Photo
                                        </p>

                                        <img src="{{ asset('storage/' . $member->photo) }}"
                                            alt="{{ $member->user->name }}"
                                            class="h-32 w-32 rounded-xl object-cover border border-gray-200 shadow-sm dark:border-gray-700">

                                    </div>
                                @endif

                                <div
                                    class="mt-3 rounded-xl border border-dashed
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
                                        Leave empty to keep the current photo.
                                    </p>

                                </div>

                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />

                            </div>

                            <!-- Status -->
                            <div>

                                <x-input-label for="status" value="Status" />

                                <select id="status" name="status"
                                    class="mt-2 block w-full rounded-xl border-gray-300 bg-white
                                    px-4 py-2.5 text-sm text-gray-900 shadow-sm
                                    transition focus:border-blue-500 focus:ring-blue-500
                                    dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                    dark:focus:border-blue-400 dark:focus:ring-blue-400"
                                    required>
                                    <option value="active" @selected(old('status', $member->status) === 'active')>
                                        Active
                                    </option>

                                    <option value="inactive" @selected(old('status', $member->status) === 'inactive')>
                                        Inactive
                                    </option>
                                </select>

                                <x-input-error :messages="$errors->get('status')" class="mt-2" />

                            </div>

                        </div>

                    </section>

                </div>

                <!-- Footer -->
                <div
                    class="flex flex-col-reverse gap-3 border-t
                    border-gray-200 bg-gray-50/70 px-6 py-5
                    dark:border-gray-800 dark:bg-gray-900/40
                    sm:flex-row sm:items-center sm:justify-end sm:px-8">

                    <a href="{{ route('admin.members.index') }}"
                        class="inline-flex items-center justify-center rounded-xl
                        border border-gray-300 bg-white px-4 py-2.5
                        text-sm font-semibold text-gray-700
                        transition-colors hover:bg-gray-50
                        dark:border-gray-700 dark:bg-gray-800
                        dark:text-gray-300 dark:hover:bg-gray-700">
                        Cancel
                    </a>

                    <x-primary-button
                        class="justify-center rounded-xl bg-blue-600
                        px-5 py-2.5 text-sm font-semibold
                        shadow-lg shadow-blue-200/40
                        hover:bg-blue-700
                        dark:bg-blue-500 dark:shadow-blue-950/20
                        dark:hover:bg-blue-600">
                        Update Member
                    </x-primary-button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
