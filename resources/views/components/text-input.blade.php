@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-xl border border-[#dde0d6] bg-[#fffef9] px-3.5 py-3 text-sm text-[#192b23] shadow-sm transition placeholder:text-[#88968a] focus:border-[#1a5b41] focus:ring-[#1a5b41]/20 disabled:cursor-not-allowed disabled:opacity-60 dark:border-[#364339] dark:bg-[#19221c] dark:text-[#ebefe5] dark:placeholder:text-[#768679] dark:focus:border-[#80ca9d]']) }}>
