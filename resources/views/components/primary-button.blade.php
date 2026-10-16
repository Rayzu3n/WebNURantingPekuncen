<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex min-h-11 items-center justify-center rounded-xl bg-[#1a5b41] px-5 py-2.5 text-xs font-extrabold uppercase tracking-[.08em] text-white transition hover:bg-[#134832] focus:outline-none focus:ring-2 focus:ring-[#31855b]/40 focus:ring-offset-2 dark:bg-[#80ca9d] dark:text-[#15271b] dark:hover:bg-[#a0dfb5] dark:focus:ring-offset-[#19221c]']) }}>
    {{ $slot }}
</button>
