<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[9px] font-extrabold uppercase tracking-[.17em] text-[#b75d3c]">Workspace redaksi</p>
            <h2 class="mt-1 font-editorial text-xl font-extrabold tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">Kotak masuk kontak</h2>
        </div>
    </x-slot>

    <div class="space-y-7">
        <section class="flex flex-col justify-between gap-4 border-b border-[#dde0d6] pb-6 dark:border-[#364339] sm:flex-row sm:items-end">
            <div>
                <p class="portal-kicker">Komunikasi warga</p>
                <h1 class="mt-3 font-editorial text-3xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5] sm:text-4xl">Pesan masuk</h1>
                <p class="mt-2 max-w-xl text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Baca pesan dari halaman kontak dan perbarui status tindak lanjutnya.</p>
            </div>
            <div class="border border-[#dde0d6] px-4 py-3 dark:border-[#364339]">
                <p class="text-xs font-bold text-[#66746a] dark:text-[#a3b1a5]">Belum dibaca</p>
                <p class="mt-1 font-editorial text-3xl font-extrabold text-[#1a5b41] dark:text-[#a8ddb8]">{{ $unreadCount }}</p>
            </div>
        </section>

        @if (session('success'))
            <div role="status" class="border border-[#b8d9be] bg-[#e7eee5] px-4 py-3 text-sm font-semibold text-[#1a5b41] dark:border-[#365b42] dark:bg-[#1c3123] dark:text-[#a8ddb8]">{{ session('success') }}</div>
        @endif

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.messages.index') }}" class="rounded-full border px-4 py-2 text-xs font-extrabold {{ $currentStatus ? 'border-[#dde0d6] text-[#66746a] dark:border-[#364339] dark:text-[#a3b1a5]' : 'border-[#1a5b41] bg-[#e7eee5] text-[#1a5b41] dark:border-[#80ca9d] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' }}">Semua</a>
            @foreach (['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Ditindaklanjuti', 'archived' => 'Arsip'] as $value => $label)
                <a href="{{ route('admin.messages.index', ['status' => $value]) }}" class="rounded-full border px-4 py-2 text-xs font-extrabold {{ $currentStatus === $value ? 'border-[#1a5b41] bg-[#e7eee5] text-[#1a5b41] dark:border-[#80ca9d] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'border-[#dde0d6] text-[#66746a] hover:border-[#aab8a8] dark:border-[#364339] dark:text-[#a3b1a5]' }}">{{ $label }}</a>
            @endforeach
        </div>

        <div class="portal-table-wrap">
            <table>
                <thead><tr><th>Pengirim</th><th>Subjek</th><th>Diterima</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                <tbody class="divide-y divide-[#dde0d6] dark:divide-[#364339]">
                    @forelse ($messages as $message)
                        <tr class="{{ $message->status === 'new' ? 'bg-[#f7f8f1] dark:bg-[#1e2b21]' : '' }}">
                            <td>
                                <p class="font-bold text-[#192b23] dark:text-[#ebefe5]">{{ $message->name }}</p>
                                <p class="mt-1 text-xs text-[#66746a] dark:text-[#a3b1a5]">{{ $message->email }}</p>
                            </td>
                            <td><p class="max-w-sm font-semibold text-[#192b23] dark:text-[#ebefe5]">{{ $message->subject }}</p><p class="mt-1 line-clamp-2 max-w-sm text-xs leading-5 text-[#66746a] dark:text-[#a3b1a5]">{{ $message->message }}</p></td>
                            <td><time datetime="{{ $message->created_at->toIso8601String() }}">{{ $message->created_at->translatedFormat('d M Y, H:i') }}</time></td>
                            <td>
                                @php($statusLabels = ['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Ditindaklanjuti', 'archived' => 'Arsip'])
                                <span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[.08em] {{ $message->status === 'new' ? 'bg-[#f3e6dd] text-[#a45134] dark:bg-[#412b22] dark:text-[#e7a68c]' : 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' }}">{{ $statusLabels[$message->status] ?? $message->status }}</span>
                            </td>
                            <td><div class="flex justify-end"><a href="{{ route('admin.messages.show', $message) }}" class="text-xs font-extrabold text-[#1a5b41] hover:underline dark:text-[#a8ddb8]">Buka pesan <x-portal-icon name="mail" class="h-3.5 w-3.5" /></a></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-14 text-center">
                            <p class="font-editorial text-xl font-extrabold text-[#192b23] dark:text-[#ebefe5]">Belum ada pesan</p>
                            <p class="mt-2 text-sm text-[#66746a] dark:text-[#a3b1a5]">Pesan yang dikirim melalui halaman kontak akan muncul di sini.</p>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $messages->links() }}</div>
    </div>
</x-app-layout>
