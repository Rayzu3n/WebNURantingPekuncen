<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[9px] font-extrabold uppercase tracking-[.17em] text-[#b75d3c]">Workspace organisasi</p>
            <h2 class="mt-1 font-editorial text-xl font-extrabold tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">{{ $banom->exists ? 'Ubah Banom' : 'Tambah Banom' }}</h2>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-6">
        <a href="{{ route('admin.banoms.index') }}" class="inline-flex min-h-10 items-center gap-2 text-sm font-bold text-[#1a5b41] hover:underline dark:text-[#a8ddb8]">← Kembali ke daftar Banom</a>

        @if ($errors->any())
            <div role="alert" class="border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900 dark:bg-rose-950/40 dark:text-rose-200">
                <p class="font-extrabold">Periksa kembali data yang diisi.</p>
                <ul class="mt-2 list-inside list-disc space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ $action }}" class="space-y-6">
            @csrf
            @if ($method === 'PUT') @method('PUT') @endif

            <section class="portal-surface space-y-5 p-5 sm:p-7">
                <div>
                    <p class="portal-kicker">Profil organisasi</p>
                    <h1 class="mt-2 font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5]">Identitas Banom</h1>
                    <p class="mt-2 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Masukkan data yang sudah dikonfirmasi. Informasi pengurus dan legalitas tidak dibuat otomatis.</p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div><label for="name">Nama organisasi</label><input class="portal-form-control mt-2" id="name" name="name" value="{{ old('name', $banom->name) }}" maxlength="160" required>@error('name')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><label for="category">Kategori</label><input class="portal-form-control mt-2" id="category" name="category" value="{{ old('category', $banom->category) }}" maxlength="160" required>@error('category')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><label for="title">Nama lengkap / keterangan</label><input class="portal-form-control mt-2" id="title" name="title" value="{{ old('title', $banom->title) }}" maxlength="255">@error('title')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><label for="motto">Motto atau tagline (opsional)</label><input class="portal-form-control mt-2" id="motto" name="motto" value="{{ old('motto', $banom->motto) }}" maxlength="255">@error('motto')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror</div>
                    <div class="sm:col-span-2"><label for="description">Deskripsi</label><textarea class="portal-form-control mt-2" id="description" name="description" rows="5" maxlength="5000" required>{{ old('description', $banom->description) }}</textarea>@error('description')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror</div>
                </div>
            </section>

            <section class="portal-surface space-y-5 p-5 sm:p-7">
                <div><p class="portal-kicker">Informasi tambahan</p><h2 class="mt-2 font-editorial text-xl font-extrabold text-[#192b23] dark:text-[#ebefe5]">Masa khidmat &amp; legalitas</h2></div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div><label for="term">Masa khidmat (opsional)</label><input class="portal-form-control mt-2" id="term" name="term" value="{{ old('term', $banom->term) }}" maxlength="120">@error('term')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><label for="coverage">Cakupan wilayah (opsional)</label><input class="portal-form-control mt-2" id="coverage" name="coverage" value="{{ old('coverage', $banom->coverage) }}" maxlength="255">@error('coverage')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><label for="legal_status">Nomor / keterangan SK (opsional)</label><input class="portal-form-control mt-2" id="legal_status" name="legal_status" value="{{ old('legal_status', $banom->legal_status) }}" maxlength="160">@error('legal_status')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><label for="sort_order">Urutan tampil</label><input class="portal-form-control mt-2" id="sort_order" name="sort_order" type="number" min="0" max="9999" value="{{ old('sort_order', $banom->sort_order) }}">@error('sort_order')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror</div>
                    <div class="sm:col-span-2"><label for="note">Catatan publik (opsional)</label><textarea class="portal-form-control mt-2" id="note" name="note" rows="3" maxlength="1000">{{ old('note', $banom->note) }}</textarea>@error('note')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror</div>
                </div>
                <label class="flex items-start gap-3 text-sm font-semibold text-[#405347] dark:text-[#c2cdc1]">
                    <input class="mt-1 h-4 w-4 rounded border-[#cfd6ca] text-[#1a5b41] focus:ring-[#1a5b41]" id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $banom->is_active))>
                    <span><span class="block text-[#192b23] dark:text-[#ebefe5]">Tampilkan di halaman publik</span><span class="mt-1 block text-xs font-normal leading-5 text-[#66746a] dark:text-[#a3b1a5]">Matikan untuk menyimpan data tanpa menampilkannya kepada pengunjung.</span></span>
                </label>
            </section>

            <section class="portal-surface space-y-5 p-5 sm:p-7" x-data="{ members: @js($members) }">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div><p class="portal-kicker">Kepengurusan</p><h2 class="mt-2 font-editorial text-xl font-extrabold text-[#192b23] dark:text-[#ebefe5]">Susunan pengurus</h2><p class="mt-1 text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Tambahkan jabatan dan nama sesuai susunan resmi. Bagian ini boleh dikosongkan jika datanya belum tersedia.</p></div>
                    <button type="button" @click="members.push({ position: '', name: '' })" class="portal-button shrink-0">+ Tambah pengurus</button>
                </div>
                <template x-for="(member, index) in members" :key="index">
                    <div class="grid gap-4 border-t border-[#dde0d6] pt-4 dark:border-[#364339] sm:grid-cols-[1fr_1fr_auto] sm:items-end">
                        <div><label :for="'member-position-' + index">Jabatan</label><input class="portal-form-control mt-2" type="text" :id="'member-position-' + index" :name="'members[' + index + '][position]'" x-model="member.position" maxlength="160" required></div>
                        <div><label :for="'member-name-' + index">Nama pengurus</label><input class="portal-form-control mt-2" type="text" :id="'member-name-' + index" :name="'members[' + index + '][name]'" x-model="member.name" maxlength="160" required></div>
                        <button type="button" @click="members.splice(index, 1)" class="inline-flex min-h-10 items-center justify-center px-3 text-sm font-bold text-rose-700 hover:bg-rose-50 dark:text-rose-300 dark:hover:bg-rose-950/30">Hapus baris</button>
                    </div>
                </template>
                <p x-show="members.length === 0" class="border border-dashed border-[#c6cec0] p-4 text-sm text-[#66746a] dark:border-[#465648] dark:text-[#a3b1a5]">Belum ada susunan pengurus. Gunakan tombol di atas untuk menambahkannya.</p>
            </section>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.banoms.index') }}" class="portal-button portal-button--secondary justify-center">Batal</a>
                <button type="submit" class="portal-button justify-center">{{ $banom->exists ? 'Simpan perubahan' : 'Simpan Banom' }}</button>
            </div>
        </form>
    </div>
</x-app-layout>
