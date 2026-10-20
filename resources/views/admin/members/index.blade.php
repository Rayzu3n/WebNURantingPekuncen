<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Direktori Anggota</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Informasi keanggotaan minimum dengan tetap menjaga privasi anggota.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="flex flex-col gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/70 p-5 dark:border-emerald-900 dark:bg-emerald-950/20 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-200" aria-hidden="true">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3 5 6v5c0 4.5 2.8 7.8 7 10 4.2-2.2 7-5.5 7-10V6l-7-3Z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                </span>
                <div>
                    <h1 class="font-semibold text-emerald-950 dark:text-emerald-100">Privasi anggota dilindungi</h1>
                    <p class="mt-1 max-w-2xl text-sm leading-6 text-emerald-900/80 dark:text-emerald-100/75">Halaman ini hanya menampilkan nama, nomor anggota, dan status keanggotaan. Data pribadi dan pengeditan profil tidak tersedia dari panel admin.</p>
                </div>
            </div>
            <span class="inline-flex w-fit shrink-0 items-center rounded-full border border-emerald-300 bg-white/70 px-3 py-1.5 text-xs font-semibold text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-200">
                {{ $members->total() }} anggota
            </span>
        </section>

        @if (session('success'))
            <div role="status" class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-[#111827]">
            @if ($members->count())
                <div class="overflow-x-auto" role="region" aria-label="Daftar anggota" tabindex="0">
                    <table class="w-full min-w-[540px] text-left">
                        <thead class="border-b border-gray-200 bg-gray-50/80 dark:border-gray-800 dark:bg-gray-900/60">
                            <tr>
                                <th scope="col" class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Nomor anggota</th>
                                <th scope="col" class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Nama anggota</th>
                                <th scope="col" class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($members as $member)
                                <tr class="transition-colors hover:bg-gray-50/70 dark:hover:bg-gray-900/40">
                                    <td class="px-5 py-4">
                                        <code class="rounded-lg bg-gray-100 px-2.5 py-1.5 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-200">{{ $member->member_number }}</code>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $member->user?->name ?? 'Anggota tidak tersedia' }}</span>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if ($member->status === 'active')
                                            <span class="inline-flex items-center gap-2 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700 dark:bg-green-500/10 dark:text-green-300">
                                                <span class="h-1.5 w-1.5 rounded-full bg-green-500" aria-hidden="true"></span>Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                                <span class="h-1.5 w-1.5 rounded-full bg-gray-500" aria-hidden="true"></span>Tidak aktif
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($members->hasPages())
                    <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800">
                        {{ $members->links() }}
                    </div>
                @endif
            @else
                <div class="px-6 py-14 text-center sm:px-10">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-300" aria-hidden="true">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="10" cy="7" r="4"/>
                            <path d="M20 8v6m3-3h-6"/>
                        </svg>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-gray-900 dark:text-white">Belum ada anggota terdaftar</h3>
                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-500 dark:text-gray-400">Anggota yang disetujui akan muncul di sini. Data pribadi tetap dibatasi untuk menjaga privasi.</p>
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
