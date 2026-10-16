<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[9px] font-extrabold uppercase tracking-[.17em] text-[#b75d3c]">Workspace redaksi</p>
            <h2 class="mt-1 font-editorial text-xl font-extrabold tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">Detail pesan</h2>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl space-y-6">
        <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#1a5b41] hover:underline dark:text-[#a8ddb8]">← Kembali ke inbox</a>

        @if (session('success'))
            <div role="status" class="border border-[#b8d9be] bg-[#e7eee5] px-4 py-3 text-sm font-semibold text-[#1a5b41] dark:border-[#365b42] dark:bg-[#1c3123] dark:text-[#a8ddb8]">{{ session('success') }}</div>
        @endif

        <article class="border border-[#dde0d6] bg-[#fffef9] dark:border-[#364339] dark:bg-[#19221c]">
            <header class="border-b border-[#dde0d6] p-5 dark:border-[#364339] sm:p-8">
                <p class="portal-kicker">Pesan dari {{ $message->name }}</p>
                <h1 class="mt-3 break-words font-editorial text-2xl font-extrabold tracking-[-.05em] text-[#192b23] dark:text-[#ebefe5] sm:text-3xl">{{ $message->subject }}</h1>
                <div class="mt-5 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                    <div>
                        <p class="text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">{{ $message->name }}</p>
                        <a href="mailto:{{ $message->email }}" class="mt-1 block break-all text-sm text-[#1a5b41] hover:underline dark:text-[#a8ddb8]">{{ $message->email }}</a>
                    </div>
                    <time class="text-xs text-[#66746a] dark:text-[#a3b1a5]" datetime="{{ $message->created_at->toIso8601String() }}">Diterima {{ $message->created_at->translatedFormat('d F Y, H:i') }}</time>
                </div>
            </header>

            <div class="whitespace-pre-line break-words p-5 text-sm leading-8 text-[#33473a] dark:text-[#d0dbcf] sm:p-8">{{ $message->message }}</div>

            <footer class="border-t border-[#dde0d6] bg-[#f0efe7]/60 p-5 dark:border-[#364339] dark:bg-[#121915]/50 sm:p-8">
                <form method="POST" action="{{ route('admin.messages.update', $message) }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                    @csrf
                    @method('PATCH')
                    <div class="flex-1">
                        <label for="status" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Status tindak lanjut</label>
                        <select id="status" name="status" required class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm text-[#192b23] outline-none focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#19221c] dark:text-[#ebefe5]">
                            <option value="new" @selected(old('status', $message->status) === 'new')>Baru</option>
                            <option value="read" @selected(old('status', $message->status) === 'read')>Dibaca</option>
                            <option value="replied" @selected(old('status', $message->status) === 'replied')>Ditindaklanjuti</option>
                            <option value="archived" @selected(old('status', $message->status) === 'archived')>Arsip</option>
                        </select>
                        @error('status')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="inline-flex min-h-11 items-center justify-center bg-[#1a5b41] px-5 text-sm font-extrabold text-white hover:bg-[#134832] dark:bg-[#80ca9d] dark:text-[#17251b] dark:hover:bg-[#a0dfb5]">Simpan status</button>
                </form>

                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="mt-5 border-t border-[#dde0d6] pt-5 dark:border-[#364339]" onsubmit="return confirm('Hapus pesan ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-bold text-rose-700 hover:underline dark:text-rose-300">Hapus pesan</button>
                </form>
            </footer>
        </article>
    </div>
</x-app-layout>
