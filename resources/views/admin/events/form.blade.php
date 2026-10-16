@if ($errors->any())
    <div role="alert" class="border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900 dark:bg-rose-950/40 dark:text-rose-200">
        <p class="font-extrabold">Periksa kembali data kegiatan.</p>
        <ul class="mt-2 list-inside list-disc space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
    <div class="space-y-6">
        <section class="portal-surface space-y-5 p-5 sm:p-7">
            <div>
                <label for="title">Judul kegiatan</label>
                <input class="portal-form-control mt-2" id="title" name="title" value="{{ old('title', $event->title) }}" maxlength="255" required>
                @error('title')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="slug">Slug URL</label>
                <input class="portal-form-control mt-2" id="slug" name="slug" value="{{ old('slug', $event->slug) }}" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" maxlength="255" required>
                <p class="mt-1 text-xs text-[#66746a] dark:text-[#a3b1a5]">Gunakan huruf kecil, angka, dan tanda hubung. Contoh: kerja-bakti-ranting</p>
                @error('slug')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="category">Kategori</label>
                    <input class="portal-form-control mt-2" id="category" name="category" value="{{ old('category', $event->category) }}" maxlength="80" placeholder="Pengajian, sosial, rapat...">
                    @error('category')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="location">Lokasi</label>
                    <input class="portal-form-control mt-2" id="location" name="location" value="{{ old('location', $event->location) }}" maxlength="255" placeholder="Tempat atau alamat kegiatan">
                    @error('location')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label for="excerpt">Ringkasan singkat</label>
                <textarea class="portal-form-control mt-2" id="excerpt" name="excerpt" rows="3" maxlength="500" placeholder="Ringkasan untuk kartu agenda">{{ old('excerpt', $event->excerpt) }}</textarea>
                @error('excerpt')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="description">Deskripsi kegiatan</label>
                <textarea class="portal-form-control mt-2" id="description" name="description" rows="10" required placeholder="Informasi, susunan acara, dan catatan kegiatan...">{{ old('description', $event->description) }}</textarea>
                @error('description')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror
            </div>
        </section>
    </div>

    <aside class="space-y-5">
        <section class="portal-surface space-y-5 p-5">
            <h2 class="font-editorial text-lg font-extrabold text-[#192b23] dark:text-[#ebefe5]">Waktu & publikasi</h2>
            <div>
                <label for="starts_at">Mulai</label>
                <input class="portal-form-control mt-2" id="starts_at" type="datetime-local" name="starts_at" value="{{ old('starts_at', $event->starts_at?->format('Y-m-d\TH:i')) }}" required>
                @error('starts_at')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="ends_at">Selesai (opsional)</label>
                <input class="portal-form-control mt-2" id="ends_at" type="datetime-local" name="ends_at" value="{{ old('ends_at', $event->ends_at?->format('Y-m-d\TH:i')) }}">
                @error('ends_at')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="status">Status</label>
                <select class="portal-form-control mt-2" id="status" name="status" required>
                    @foreach (['draft' => 'Draft', 'published' => 'Publikasikan', 'archived' => 'Arsip manual'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $event->status) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')<p class="mt-1 text-xs text-rose-700">{{ $message }}</p>@enderror
            </div>
        </section>
        <section class="portal-surface space-y-4 p-5">
            <div>
                <h2 class="font-editorial text-lg font-extrabold text-[#192b23] dark:text-[#ebefe5]">Gambar sampul</h2>
                <p class="mt-1 text-xs leading-5 text-[#66746a] dark:text-[#a3b1a5]">JPG, PNG, atau WebP. Maksimal 4 MB.</p>
            </div>
            @if ($event->imageUrl())
                <img src="{{ $event->imageUrl() }}" alt="Sampul kegiatan saat ini" class="aspect-[16/10] w-full object-cover">
            @endif
            <input class="block w-full text-xs" id="cover_image" type="file" name="cover_image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
            @error('cover_image')<p class="text-xs text-rose-700">{{ $message }}</p>@enderror
        </section>
        <div class="flex flex-col gap-3">
            <button class="portal-button w-full" type="submit">Simpan kegiatan</button>
            <a href="{{ route('admin.events.index') }}" class="portal-button-secondary w-full">Batal</a>
        </div>
    </aside>
</div>
