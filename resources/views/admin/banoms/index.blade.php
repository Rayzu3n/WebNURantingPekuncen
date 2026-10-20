<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[9px] font-extrabold uppercase tracking-[.17em] text-[#b75d3c]">Workspace organisasi</p>
            <h2 class="mt-1 font-editorial text-xl font-extrabold tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">Manajemen Banom</h2>
        </div>
    </x-slot>

    <div class="space-y-7">
        <section class="flex flex-col justify-between gap-4 border-b border-[#dde0d6] pb-6 dark:border-[#364339] sm:flex-row sm:items-end">
            <div>
                <p class="portal-kicker">Direktori organisasi</p>
                <h1 class="mt-3 font-editorial text-3xl font-extrabold tracking-[-.06em] text-[#192b23] dark:text-[#ebefe5] sm:text-4xl">Kelola Banom</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-[#66746a] dark:text-[#a3b1a5]">Kelola profil badan otonom dan susunan pengurus. Pastikan data sesuai informasi resmi organisasi.</p>
            </div>
            <a href="{{ route('admin.banoms.create') }}" class="portal-button">+ Tambah Banom</a>
        </section>

        @if (session('success'))
            <div role="status" class="border border-[#b8d9be] bg-[#e7eee5] px-4 py-3 text-sm font-semibold text-[#1a5b41] dark:border-[#365b42] dark:bg-[#1c3123] dark:text-[#a8ddb8]">{{ session('success') }}</div>
        @endif

        <div class="portal-table-wrap max-w-full" role="region" aria-label="Daftar Banom, geser horizontal untuk melihat semua kolom" tabindex="0">
            <table>
                <thead><tr><th>Organisasi</th><th>Kategori</th><th>Pengurus</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                <tbody class="divide-y divide-[#dde0d6] dark:divide-[#364339]">
                    @forelse ($banoms as $banom)
                        <tr>
                            <td>
                                <div class="min-w-[200px]">
                                    <p class="font-bold text-[#192b23] dark:text-[#ebefe5]">{{ $banom->name }}</p>
                                    @if ($banom->title)
                                        <p class="mt-1 text-xs text-[#66746a] dark:text-[#a3b1a5]">{{ $banom->title }}</p>
                                    @endif
                                </div>
                            </td>
                            <td><span class="inline-flex rounded-md bg-[#f0efe7] px-2.5 py-1 text-xs font-semibold text-[#405347] dark:bg-[#263127] dark:text-[#c2cdc1]">{{ $banom->category }}</span></td>
                            <td>{{ $banom->members_count }} orang</td>
                            <td><span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[.08em] {{ $banom->is_active ? 'bg-[#e7eee5] text-[#1a5b41] dark:bg-[#2a3b2f] dark:text-[#a8ddb8]' : 'bg-[#f0efe7] text-[#66746a] dark:bg-[#263127] dark:text-[#bdc8bc]' }}">{{ $banom->is_active ? 'Tampil' : 'Disembunyikan' }}</span></td>
                            <td>
                                <div class="flex justify-end gap-3 text-xs font-extrabold">
                                    @if ($banom->is_active)
                                        <a href="{{ route('banoms.index') }}#{{ $banom->slug }}" class="text-[#66746a] hover:text-[#1a5b41] dark:text-[#a3b1a5] dark:hover:text-[#a8ddb8]">Lihat</a>
                                    @endif
                                    <a href="{{ route('admin.banoms.edit', $banom) }}" class="text-[#1a5b41] dark:text-[#a8ddb8]">Edit</a>
                                    <form method="POST" action="{{ route('admin.banoms.destroy', $banom) }}" onsubmit="return confirm('Hapus Banom ini beserta susunan pengurusnya?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-700 hover:text-rose-900 dark:text-rose-300">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-14 text-center">
                            <p class="font-editorial text-xl font-extrabold text-[#192b23] dark:text-[#ebefe5]">Belum ada data Banom</p>
                            <p class="mt-2 text-sm text-[#66746a] dark:text-[#a3b1a5]">Tambahkan data organisasi yang sudah diverifikasi.</p>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($banoms->hasPages())
            <div>{{ $banoms->links() }}</div>
        @endif
    </div>
</x-app-layout>
