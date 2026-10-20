<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Membership Registration</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Submit your details. Portal access starts after admin approval.</p>
    </div>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div><x-input-label for="name" value="Full Name" /><x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus /><x-input-error :messages="$errors->get('name')" class="mt-2" /></div>
        <div><x-input-label for="email" value="Email Address" /><x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autocomplete="email" /><x-input-error :messages="$errors->get('email')" class="mt-2" /></div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div><x-input-label for="password" value="Password" /><x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" /><x-input-error :messages="$errors->get('password')" class="mt-2" /></div>
            <div><x-input-label for="password_confirmation" value="Confirm Password" /><x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" /></div>
        </div>
        <div class="border-t border-gray-200 pt-5 dark:border-gray-700"><h2 class="text-sm font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-200">Identity Details</h2><p class="mt-1 text-xs text-gray-500 dark:text-gray-400">NIK is required and stored in encrypted form.</p></div>
        <div><x-input-label for="nik" value="NIK (16 digits)" /><x-text-input id="nik" name="nik" type="text" inputmode="numeric" maxlength="16" pattern="[0-9]{16}" class="mt-1 block w-full" :value="old('nik')" required autocomplete="off" /><x-input-error :messages="$errors->get('nik')" class="mt-2" /></div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div><x-input-label for="birth_place" value="Place of Birth" /><x-text-input id="birth_place" name="birth_place" type="text" class="mt-1 block w-full" :value="old('birth_place')" required /><x-input-error :messages="$errors->get('birth_place')" class="mt-2" /></div>
            <div><x-input-label for="birth_date" value="Date of Birth" /><x-text-input id="birth_date" name="birth_date" type="date" max="{{ now()->toDateString() }}" class="mt-1 block w-full" :value="old('birth_date')" required /><x-input-error :messages="$errors->get('birth_date')" class="mt-2" /></div>
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div><x-input-label for="gender" value="Gender" /><select id="gender" name="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"><option value="">Select gender</option><option value="L" @selected(old('gender') === 'L')>Laki-laki</option><option value="P" @selected(old('gender') === 'P')>Perempuan</option></select><x-input-error :messages="$errors->get('gender')" class="mt-2" /></div>
            <div><x-input-label for="phone" value="Phone Number (optional)" /><x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone')" /><x-input-error :messages="$errors->get('phone')" class="mt-2" /></div>
        </div>
        <div><x-input-label for="address" value="Full Address" /><textarea id="address" name="address" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">{{ old('address') }}</textarea><x-input-error :messages="$errors->get('address')" class="mt-2" /></div>
        <div><x-input-label for="photo" value="Profile Photo (optional)" /><input id="photo" name="photo" type="file" accept=".jpg,.jpeg,.png,.webp" class="mt-1 block w-full text-sm text-gray-600 dark:text-gray-300" /><p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG, or WebP, maximum 2 MB.</p><x-input-error :messages="$errors->get('photo')" class="mt-2" /></div>
        <div><label for="terms" class="flex items-start gap-3 text-sm text-gray-600 dark:text-gray-300"><input id="terms" name="terms" type="checkbox" value="1" required @checked(old('terms')) class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm" /><span>I confirm these details are accurate and understand membership access requires admin approval.</span></label><x-input-error :messages="$errors->get('terms')" class="mt-2" /></div>
        <div class="flex items-center justify-between gap-4 pt-2"><a class="text-sm underline text-gray-600 dark:text-gray-400" href="{{ route('login') }}">Already registered?</a><x-primary-button>Submit Application</x-primary-button></div>
        <p class="text-center text-sm text-gray-500 dark:text-gray-400">Already applied? <a class="underline" href="{{ route('membership.track') }}">Track your application</a></p>
    </form>
</x-guest-layout>
