<div x-data="themeToggle()" x-init="init()">
    <button type="button" @click="toggle()" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-[#dde0d6] bg-[#fffef9] text-[#405347] transition hover:border-[#1a5b41] hover:text-[#1a5b41] dark:border-[#364339] dark:bg-[#19221c] dark:text-[#bdc8bc] dark:hover:border-[#80ca9d] dark:hover:text-[#a8ddb8]" :aria-label="dark ? 'Dark mode' : 'Light mode'" :title="dark ? 'Dark mode' : 'Light mode'">
        <svg x-cloak x-show="!dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-5 w-5"><circle cx="12" cy="12" r="4.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5v2m0 15v2M4.93 4.93l1.4 1.4m11.34 11.34 1.4 1.4M2.5 12h2m15 0h2M4.93 19.07l1.4-1.4M17.67 6.33l1.4-1.4"/></svg>
        <svg x-cloak x-show="dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.2 15.2A8.25 8.25 0 0 1 8.8 3.8a8.5 8.5 0 1 0 11.4 11.4Z"/></svg>
    </button>
</div>
