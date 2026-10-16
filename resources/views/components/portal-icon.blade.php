@props([
    'name',
    'class' => 'h-4 w-4',
])

<svg
    aria-hidden="true"
    focusable="false"
    class="{{ $class }} shrink-0"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.8"
    stroke-linecap="round"
    stroke-linejoin="round"
>
    @switch($name)
        @case('house')
            <path d="m3 10 9-7 9 7" />
            <path d="M5 9v12h14V9" />
            <path d="M9 21v-7h6v7" />
            @break
        @case('log-out')
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            <path d="m16 17 5-5-5-5" />
            <path d="M21 12H9" />
            @break
        @case('log-in')
            <path d="M15 21h4a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-4" />
            <path d="m10 17-5-5 5-5" />
            <path d="M5 12h12" />
            @break
        @case('dashboard')
            <rect x="3" y="3" width="8" height="8" rx="1.5" />
            <rect x="13" y="3" width="8" height="5" rx="1.5" />
            <rect x="13" y="10" width="8" height="11" rx="1.5" />
            <rect x="3" y="13" width="8" height="8" rx="1.5" />
            @break
        @case('newspaper')
            <path d="M4 5h16v15H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z" />
            <path d="M8 9h8M8 13h8M8 17h5" />
            <path d="M5 5V3h15v2" />
            @break
        @case('book-open')
            <path d="M12 7v14" />
            <path d="M3 18V5a1 1 0 0 1 1-1h3a5 5 0 0 1 5 5v12a5 5 0 0 0-5-3H4a1 1 0 0 1-1-1Z" />
            <path d="M21 18V5a1 1 0 0 0-1-1h-3a5 5 0 0 0-5 5v12a5 5 0 0 1 5-3h3a1 1 0 0 0 1-1Z" />
            @break
        @case('calendar')
            <rect x="3" y="5" width="18" height="16" rx="2" />
            <path d="M16 3v4M8 3v4M3 10h18" />
            <path d="m8 15 2 2 4-4" />
            @break
        @case('users')
            <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
            <circle cx="10" cy="7" r="4" />
            <path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
            @break
        @case('tags')
            <path d="M20.6 13.4 13.4 20.6a2 2 0 0 1-2.8 0L3 13V3h10l7.6 7.6a2 2 0 0 1 0 2.8Z" />
            <circle cx="7.5" cy="7.5" r="1" />
            @break
        @case('inbox')
            <path d="M4 4h16l2 11v4a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-4L4 4Z" />
            <path d="M2 15h6l2 3h4l2-3h6" />
            @break
        @case('mail')
            <rect x="3" y="5" width="18" height="14" rx="2" />
            <path d="m3 7 9 6 9-6" />
            @break
        @case('external-link')
            <path d="M13 5h6v6" />
            <path d="m19 5-9 9" />
            <path d="M19 13v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h5" />
            @break
        @case('arrow-left')
            <path d="m12 19-7-7 7-7" />
            <path d="M5 12h14" />
            @break
        @case('pen-line')
            <path d="M12 20h9" />
            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z" />
            @break
        @case('eye')
            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
            <circle cx="12" cy="12" r="3" />
            @break
        @case('building')
            <rect x="4" y="3" width="16" height="18" rx="1.5" />
            <path d="M9 7h2M9 11h2M9 15h2M15 7h.01M15 11h.01M15 15h.01M10 21v-3h4v3" />
            @break
        @case('user-round')
            <circle cx="12" cy="8" r="4" />
            <path d="M5 21v-2a7 7 0 0 1 14 0v2" />
            @break
        @case('id-card')
            <rect x="3" y="5" width="18" height="14" rx="2" />
            <circle cx="8.5" cy="11" r="2" />
            <path d="M5.5 16a3 3 0 0 1 6 0M14 10h4M14 14h4" />
            @break
        @case('send')
            <path d="m22 2-7 20-4-9-9-4Z" />
            <path d="M22 2 11 13" />
            @break
        @case('archive')
            <rect x="3" y="4" width="18" height="4" rx="1" />
            <path d="M5 8v12h14V8M10 12h4" />
            @break
        @case('plus')
            <path d="M12 5v14M5 12h14" />
            @break
        @case('chevron-right')
            <path d="m9 18 6-6-6-6" />
            @break
        @default
            <circle cx="12" cy="12" r="8" />
    @endswitch
</svg>
