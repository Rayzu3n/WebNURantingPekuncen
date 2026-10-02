<div
    x-data="themeToggle()"
    x-init="init()"
>
    <button
        type="button"
        @click="toggle()"
        class="inline-flex items-center justify-center
               w-10 h-10 rounded-full
               border-0
               bg-transparent
               text-gray-700
               hover:bg-gray-100
               dark:text-gray-300
               dark:hover:bg-gray-800
               transition-colors duration-200"
        :aria-label="dark ? 'Dark mode' : 'Light mode'"
        :title="dark ? 'Dark mode' : 'Light mode'"
    >

        <!-- Light Mode -->
        <svg
            x-cloak
            x-show="!dark"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-5 h-5"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 3v2.25M12 18.75V21M4.22 4.22l1.59 1.59M18.19 18.19l1.59 1.59M3 12h2.25M18.75 12H21M4.22 19.78l1.59-1.59M18.19 5.81l1.59-1.59"
            />

            <circle
                cx="12"
                cy="12"
                r="4.5"
            />
        </svg>

        <!-- Dark Mode -->
        <svg
            x-cloak
            x-show="dark"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-5 h-5"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21.752 15.002A9 9 0 1 1 8.998 2.248A7.5 7.5 0 0 0 21.752 15.002Z"
            />
        </svg>

    </button>
</div>