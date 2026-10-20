<x-guest-layout>
    <div class="space-y-2">
        <p class="text-xs font-bold uppercase tracking-[.16em] text-[#b75d3c]">Akses anggota</p>
        <h1 class="font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5]">Masuk ke akun</h1>
        <p class="text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Gunakan email dan kata sandi yang terdaftar untuk melanjutkan.</p>
    </div>

    <div class="mt-5">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if ($errors->any())
            <div role="alert" aria-live="polite" class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-900 dark:bg-red-950/30 dark:text-red-200">
                <p class="font-semibold">Belum berhasil masuk</p>
                <p class="mt-1 leading-5">Periksa kembali email dan kata sandi, atau ikuti petunjuk pada kolom yang ditandai.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="email" value="Alamat email" />
                <x-text-input
                    id="email"
                    class="mt-2 block min-h-12 w-full rounded-xl"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    inputmode="email"
                    aria-describedby="email-help"
                    :aria-invalid="$errors->has('email')"
                />
                <p id="email-help" class="mt-1.5 text-xs leading-5 text-[#7a887d] dark:text-[#98a69a]">Gunakan alamat email yang dipakai saat mendaftar.</p>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <div class="flex items-center justify-between gap-3">
                    <x-input-label for="password" value="Kata sandi" />
                    @if (Route::has('password.request'))
                        <a class="rounded text-xs font-semibold text-[#1a5b41] underline decoration-[#a9c4ac] underline-offset-4 hover:text-[#134832] focus:outline-none focus:ring-2 focus:ring-[#1a5b41] dark:text-[#a8ddb8] dark:hover:text-white" href="{{ route('password.request') }}">Lupa kata sandi?</a>
                    @endif
                </div>
                <x-text-input
                    id="password"
                    class="mt-2 block min-h-12 w-full rounded-xl"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    :aria-invalid="$errors->has('password')"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <label for="remember" class="flex min-h-11 cursor-pointer items-center gap-3 text-sm text-[#66746a] dark:text-[#a3b1a5]">
                <input id="remember" type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-[#cbd8ca] text-[#1a5b41] focus:ring-[#1a5b41] dark:border-[#405646] dark:bg-[#213127]">
                <span>Ingat saya di perangkat ini</span>
            </label>

            <button type="submit" class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#1a5b41] px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#134832] focus:outline-none focus:ring-2 focus:ring-[#1a5b41] focus:ring-offset-2 active:translate-y-px dark:bg-[#80ca9d] dark:text-[#17251b] dark:hover:bg-[#a0dfb5] dark:focus:ring-offset-[#19221c]">
                Masuk ke akun
                <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
        </form>

        <div class="my-6 flex items-center gap-3" aria-hidden="true">
            <span class="h-px flex-1 bg-[#e1e5db] dark:bg-[#364339]"></span>
            <span class="text-[10px] font-bold uppercase tracking-[.15em] text-[#88968a]">Belum punya akun?</span>
            <span class="h-px flex-1 bg-[#e1e5db] dark:bg-[#364339]"></span>
        </div>

        <a href="{{ route('register') }}" class="inline-flex min-h-12 w-full items-center justify-center rounded-xl border border-[#cbd8ca] bg-transparent px-5 py-3 text-sm font-bold text-[#1a5b41] transition hover:border-[#1a5b41] hover:bg-[#f1f5ed] focus:outline-none focus:ring-2 focus:ring-[#1a5b41] focus:ring-offset-2 dark:border-[#405646] dark:text-[#a8ddb8] dark:hover:border-[#80ca9d] dark:hover:bg-[#213127] dark:focus:ring-offset-[#19221c]">
            Buat akun anggota
        </a>

        <div class="mt-5 rounded-xl border border-[#e1e5db] bg-[#f7f8f2] p-4 dark:border-[#364339] dark:bg-[#202a22]">
            <p class="text-sm font-semibold text-[#35473a] dark:text-[#d5e1d4]">Sudah mengajukan pendaftaran?</p>
            <p class="mt-1 text-xs leading-5 text-[#66746a] dark:text-[#a3b1a5]">Periksa perkembangan aplikasi tanpa harus masuk ke akun.</p>
            <a href="{{ route('membership.track') }}" class="mt-3 inline-flex min-h-10 items-center gap-2 text-sm font-bold text-[#1a5b41] underline decoration-[#a9c4ac] underline-offset-4 hover:text-[#134832] focus:outline-none focus:ring-2 focus:ring-[#1a5b41] dark:text-[#a8ddb8] dark:hover:text-white">
                Lacak pendaftaran
                <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M8 7h9v9"/></svg>
            </a>
        </div>
    </div>
</x-guest-layout>
