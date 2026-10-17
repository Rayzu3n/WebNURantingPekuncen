<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[9px] font-extrabold uppercase tracking-[.17em] text-[#b75d3c]">Workspace redaksi</p>
            <h2 class="mt-1 font-editorial text-xl font-extrabold tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">Agenda kegiatan</h2>
        </div>
    </x-slot>

    <div class="space-y-7">
        <section class="flex flex-col justify-between gap-4 border-b border-[#dde0d6] pb-6 dark:border-[#364339] sm:flex-row sm:items-end">
            <div>
                <p class="portal-kicker">Kalender komunitas</p>
                <h1 class="mt-3 font-editorial text-3xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5] sm:text-4xl">Kelola kegiatan</h1>
                <p class="mt-2 max-w-xl text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Buat agenda baru dan simpan dokumentasi kegiatan dalam satu tempat.</p>
            </div>
            <a href="{{ route('admin.events.create') }}" class="portal-button">+ Tambah kegiatan</a>
        </section>

        @if (session('success'))
            <div role="status" class="border border-[#b8d9be] bg-[#e7eee5] px-4 py-3 text-sm font-semibold text-[#1a5b41] dark:border-[#365b42] dark:bg-[#1c3123] dark:text-[#a8ddb8]">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div role="alert" class="border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800 dark:border-rose-900 dark:bg-rose-950/40 dark:text-rose-200">{{ session('error') }}</div>
        @endif

        <div class="portal-table-wrap portal-table-wrap--events max-w-full" role="region" aria-label="Daftar kegiatan, geser horizontal untuk melihat semua kolom" tabindex="0">
            <table>
                <thead><tr><th>Kegiatan</th><th>Jadwal</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                <tbody class="divide-y divide-[#dde0d6] dark:divide-[#364339]">
                    @forelse ($events as $event)
                        <tr>
                            <td>
                                <div class="flex min-w-[220px] items-start gap-3">
                                    @if ($event->imageUrl())
                                        <img src="{{ $event->imageUrl() }}" alt="" class="h-14 w-20 shrink-0 object-cover">
                                    @else
                                        <div class="flex h-14 w-20 shrink-0 items-center justify-center bg-[#e4ede2] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]">NU</div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-bold text-[#192b23] dark:text-[#ebefe5]">{{ $event->title }}</p>
                                        <p class="mt-1 text-xs text-[#66746a] dark:text-[#a3b1a5]">{{ $event->category ?: 'Tanpa kategori' }}@if ($event->location) · {{ $event->location }}@endif</p>
                                    </div>
                                </div>
                            </td>
                            <td><time datetime="{{ $event->starts_at->toIso8601String() }}">{{ $event->starts_at->translatedFormat('d M Y, H:i') }}</time></td>
                            <td>
                                @php($statusClasses = ['published' => 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]', 'draft' => 'bg-[#f0efe7] text-[#66746a] dark:bg-[#263127] dark:text-[#bdc8bc]', 'archived' => 'bg-[#f3e6dd] text-[#a45134] dark:bg-[#412b22] dark:text-[#e7a68c]'])
                                <span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[.08em] {{ $statusClasses[$event->status] ?? $statusClasses['draft'] }}">{{ $event->status }}</span>
                            </td>
                            <td>
                                <div class="flex justify-end gap-3 text-xs font-extrabold">
                                    @if ($event->status === 'published')
                                        <a href="{{ route('events.show', $event->slug) }}" class="text-[#66746a] hover:text-[#1a5b41] dark:text-[#a3b1a5] dark:hover:text-[#a8ddb8]">Lihat</a>
                                    @endif
                                    <a href="{{ route('admin.events.edit', $event) }}" class="text-[#1a5b41] dark:text-[#a8ddb8]">Edit</a>
                                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-700 hover:text-rose-900 dark:text-rose-300">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-14 text-center">
                            <p class="font-editorial text-xl font-extrabold text-[#192b23] dark:text-[#ebefe5]">Belum ada agenda</p>
                            <p class="mt-2 text-sm text-[#66746a] dark:text-[#a3b1a5]">Mulai dengan menambahkan kegiatan pertama.</p>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $events->links() }}</div>
    </div>
</x-app-layout>
