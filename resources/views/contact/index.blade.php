<x-public-layout title="Hubungi Portal NU Pekuncen">
    <main class="mx-auto w-full max-w-[1500px] px-4 py-10 sm:px-7 sm:py-14 lg:px-10 lg:py-18">
        <div class="grid gap-10 lg:grid-cols-[.85fr_1.15fr] lg:gap-16">
            <section class="max-w-xl">
                <p class="portal-kicker">Terhubung dengan kami</p>
                <h1 class="mt-4 font-editorial text-4xl font-extrabold leading-[1.02] tracking-[-.065em] text-[#192b23] dark:text-[#ebefe5] sm:text-5xl lg:text-6xl">Ada kabar, pertanyaan, atau saran?</h1>
                <p class="mt-6 text-base leading-8 text-[#66746a] dark:text-[#a3b1a5]">Kirim pesan kepada pengelola Portal NU Pekuncen. Pesan akan diterima oleh tim admin untuk ditindaklanjuti.</p>

                <div class="mt-9 border-t border-[#dde0d6] pt-5 dark:border-[#364339]">
                    <p class="text-[10px] font-extrabold uppercase tracking-[.15em] text-[#b75d3c]">Sebelum mengirim</p>
                    <p class="mt-2 text-sm leading-7 text-[#66746a] dark:text-[#a3b1a5]">Tuliskan topik secara jelas dan gunakan alamat email yang aktif agar pengelola dapat mengenali pesanmu.</p>
                </div>
            </section>

            <section class="border border-[#dde0d6] bg-[#fffef9] p-5 shadow-sm dark:border-[#364339] dark:bg-[#19221c] sm:p-8 lg:p-10">
                @if (session('success'))
                    <div role="status" class="mb-6 border border-[#b8d9be] bg-[#e7eee5] px-4 py-3 text-sm font-semibold text-[#1a5b41] dark:border-[#365b42] dark:bg-[#1c3123] dark:text-[#a8ddb8]">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                    @csrf

                    <div class="hidden" aria-hidden="true">
                        <label for="website">Website</label>
                        <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Nama</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" maxlength="120" required class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm text-[#192b23] outline-none transition focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5] dark:focus:border-[#80ca9d]">
                            @error('name')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" required class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm text-[#192b23] outline-none transition focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5] dark:focus:border-[#80ca9d]">
                            @error('email')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Subjek</label>
                        <input id="subject" name="subject" type="text" value="{{ old('subject') }}" maxlength="160" required class="mt-2 w-full border border-[#cfd6ca] bg-white px-4 py-3 text-sm text-[#192b23] outline-none transition focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5] dark:focus:border-[#80ca9d]">
                        @error('subject')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-bold text-[#192b23] dark:text-[#ebefe5]">Pesan</label>
                        <textarea id="message" name="message" rows="7" maxlength="5000" required class="mt-2 w-full resize-y border border-[#cfd6ca] bg-white px-4 py-3 text-sm leading-7 text-[#192b23] outline-none transition focus:border-[#1a5b41] focus:ring-2 focus:ring-[#1a5b41]/15 dark:border-[#465548] dark:bg-[#121915] dark:text-[#ebefe5] dark:focus:border-[#80ca9d]">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="inline-flex min-h-12 w-full items-center justify-center gap-2 bg-[#1a5b41] px-5 text-sm font-extrabold text-white transition hover:bg-[#134832] focus:outline-none focus:ring-2 focus:ring-[#1a5b41] focus:ring-offset-2 dark:bg-[#80ca9d] dark:text-[#17251b] dark:hover:bg-[#a0dfb5] sm:w-auto">Kirim pesan <span aria-hidden="true">↗</span></button>
                </form>
            </section>
        </div>
    </main>
</x-public-layout>
