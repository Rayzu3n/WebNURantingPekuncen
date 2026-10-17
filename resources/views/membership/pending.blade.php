<x-app-layout>
<x-slot name="header"><h2 class="text-xl font-semibold text-gray-900 dark:text-white">Membership Application</h2></x-slot>
<div class="mx-auto max-w-3xl space-y-6">
@if (session('registration_token') && session('registration_number'))
<div class="rounded-xl border border-amber-300 bg-amber-50 p-5 text-amber-950 dark:border-amber-700 dark:bg-amber-950/30 dark:text-amber-100">
<h3 class="font-semibold">Save your application tracking details</h3><p class="mt-2 text-sm">The access token is shown only once. Save it privately. Anyone with both values can view your application status.</p>
<p class="mt-4 text-sm"><strong>Registration number:</strong> <code>{{ session('registration_number') }}</code></p><p class="mt-3 text-sm font-semibold">Secret access token</p><code class="mt-1 block break-all rounded-lg bg-white/80 p-3 text-gray-900 dark:bg-black/30 dark:text-white">{{ session('registration_token') }}</code>
</div>@endif
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:p-8">
<p class="text-sm font-semibold uppercase tracking-wide text-indigo-600 dark:text-indigo-400">Current status</p><h1 class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">{{ str($application->status)->replace('_', ' ')->title() }}</h1>
<p class="mt-3 text-sm leading-6 text-gray-600 dark:text-gray-300">Your account is restricted while the application is reviewed. The member dashboard, profile, and digital card remain unavailable until approval.</p>
<dl class="mt-6 grid gap-4 border-t border-gray-200 pt-5 text-sm dark:border-gray-700 sm:grid-cols-2"><div><dt class="text-gray-500 dark:text-gray-400">Registration number</dt><dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $application->registration_number }}</dd></div><div><dt class="text-gray-500 dark:text-gray-400">Submitted</dt><dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $application->created_at->format('d M Y, H:i') }}</dd></div></dl>
@if ($application->status === 'needs_revision')
<div class="mt-5"><a href="{{ route('membership.revise') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Revise application</a></div>
@endif
@if ($application->admin_note)<div class="mt-5 rounded-lg bg-gray-50 p-4 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-200"><p class="font-semibold">Reviewer note</p><p class="mt-1 whitespace-pre-line">{{ $application->admin_note }}</p></div>@endif
<div class="mt-6 flex flex-wrap gap-3"><a href="{{ route('membership.track') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Track application</a><form method="POST" action="{{ route('logout') }}">@csrf<button class="text-sm underline text-gray-600 dark:text-gray-300">Log out</button></form></div>
</div></div></x-app-layout>