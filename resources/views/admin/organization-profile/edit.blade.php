<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[9px] font-extrabold uppercase tracking-[.17em] text-[#b75d3c]">Workspace redaksi</p>
            <h2 class="mt-1 font-editorial text-xl font-extrabold tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">Profil organisasi</h2>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-7">
        <section class="flex flex-col justify-between gap-4 border-b border-[#dde0d6] pb-6 dark:border-[#364339] sm:flex-row sm:items-end">
            <div>
                <p class="portal-kicker">Identitas publik</p>
                <h1 class="mt-3 font-editorial text-3xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5] sm:text-4xl">Tentang Kami</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Kelola informasi resmi yang akan tampil di halaman publik. Isi hanya data organisasi yang sudah dikonfirmasi dan disetujui untuk dipublikasikan.</p>
            </div>
            <a href="{{ route('about') }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-11 items-center justify-center border border-[#dde0d6] px-4 text-sm font-bold text-[#1a5b41] hover:bg-[#f0efe7] dark:border-[#364339] dark:text-[#a8ddb8] dark:hover:bg-[#253127]">Pratinjau halaman ↗</a>
        </section>

        @if (session('success'))
            <div role="status" class="border border-[#b8d9be] bg-[#e7eee5] px-4 py-3 text-sm font-semibold text-[#1a5b41] dark:border-[#365b42] dark:bg-[#1c3123] dark:text-[#a8ddb8]">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.organization-profile.update') }}" class="space-y-8">
            @csrf
            @method('PATCH')

            <section class="border border-[#dde0d6] bg-[#fffef9] p-5 dark:border-[#364339] dark:bg-[#19221c] sm:p-8">
                <p class="portal-kicker">01 / Identitas</p>
                <div class="mt-5 grid gap-5">
                    <div>
                        <label for="name" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Nama organisasi</label>
                        <input id="name" name="name" value="{{ old('name', $profile->name) }}" maxlength="160" required class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm text-[#192b23] outline-none focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5]">
                        @error('name')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tagline" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Deskripsi singkat</label>
                        <input id="tagline" name="tagline" value="{{ old('tagline', $profile->tagline) }}" maxlength="255" class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm text-[#192b23] outline-none focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5]">
                        @error('tagline')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="history" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Sejarah singkat</label>
                        <textarea id="history" name="history" rows="6" maxlength="20000" class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm leading-7 text-[#192b23] outline-none focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5]">{{ old('history', $profile->history) }}</textarea>
                        @error('history')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="border border-[#dde0d6] bg-[#fffef9] p-5 dark:border-[#364339] dark:bg-[#19221c] sm:p-8">
                <p class="portal-kicker">02 / Arah organisasi</p>
                <div class="mt-5 grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="vision" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Visi</label>
                        <textarea id="vision" name="vision" rows="5" maxlength="5000" class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm leading-7 text-[#192b23] outline-none focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5]">{{ old('vision', $profile->vision) }}</textarea>
                        @error('vision')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="mission" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Misi</label>
                        <textarea id="mission" name="mission" rows="5" maxlength="10000" placeholder="Satu poin per baris" class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm leading-7 text-[#192b23] outline-none focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5]">{{ old('mission', $profile->mission) }}</textarea>
                        @error('mission')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="border border-[#dde0d6] bg-[#fffef9] p-5 dark:border-[#364339] dark:bg-[#19221c] sm:p-8">
                <p class="portal-kicker">03 / Orang dan program</p>
                <div class="mt-5 grid gap-5">
                    <div>
                        <label for="structure" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Struktur organisasi</label>
                        <textarea id="structure" name="structure" rows="6" maxlength="10000" placeholder="Satu jabatan atau bagian per baris. Cantumkan nama hanya setelah disetujui untuk dipublikasikan." class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm leading-7 text-[#192b23] outline-none focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5]">{{ old('structure', $profile->structure) }}</textarea>
                        @error('structure')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="programs" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Program dan kegiatan</label>
                        <textarea id="programs" name="programs" rows="5" maxlength="10000" placeholder="Satu program per baris. Hindari mengisi kegiatan yang belum disahkan." class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm leading-7 text-[#192b23] outline-none focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5]">{{ old('programs', $profile->programs) }}</textarea>
                        @error('programs')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="border border-[#dde0d6] bg-[#fffef9] p-5 dark:border-[#364339] dark:bg-[#19221c] sm:p-8">
                <p class="portal-kicker">04 / Kontak publik</p>
                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Alamat</label>
                        <textarea id="address" name="address" rows="2" maxlength="255" class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm text-[#192b23] outline-none focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5]">{{ old('address', $profile->address) }}</textarea>
                        @error('address')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    @foreach (['contact_email' => 'Email', 'contact_phone' => 'Telepon', 'website_url' => 'Website URL', 'facebook_url' => 'Facebook URL', 'instagram_url' => 'Instagram URL'] as $field => $label)
                        <div>
                            <label for="{{ $field }}" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">{{ $label }}</label>
                            <input id="{{ $field }}" name="{{ $field }}" type="{{ $field === 'contact_email' ? 'email' : ($field === 'contact_phone' ? 'tel' : 'url') }}" value="{{ old($field, $profile->{$field}) }}" maxlength="255" class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm text-[#192b23] outline-none focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5]">
                            @error($field)<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex min-h-12 items-center justify-center border border-[#dde0d6] px-5 text-sm font-bold text-[#526156] hover:bg-[#f0efe7] dark:border-[#364339] dark:text-[#c2cdc1] dark:hover:bg-[#253127]">Kembali</a>
                <button type="submit" class="inline-flex min-h-12 items-center justify-center bg-[#1a5b41] px-6 text-sm font-extrabold text-white hover:bg-[#134832] dark:bg-[#80ca9d] dark:text-[#17251b] dark:hover:bg-[#a0dfb5]">Simpan profil</button>
            </div>
        </form>
    </div>
</x-app-layout>
