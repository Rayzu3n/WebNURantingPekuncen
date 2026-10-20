<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Review Application</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $application->registration_number }}</p>
            </div>
            <a href="{{ route('admin.membership-applications.index') }}" class="text-sm underline text-indigo-600 dark:text-indigo-400">Back to applications</a>
        </div>
    </x-slot>

    <div class="mx-auto grid max-w-6xl gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <section class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-wrap items-center gap-3">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Applicant details</h3>
                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                    {{ str($application->status)->replace('_', ' ')->title() }}
                </span>
            </div>

            <dl class="mt-5 grid gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-gray-500 dark:text-gray-400">Name</dt><dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $application->user->name }}</dd></div>
                <div><dt class="text-gray-500 dark:text-gray-400">Email</dt><dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $application->user->email }}</dd></div>
                <div><dt class="text-gray-500 dark:text-gray-400">NIK</dt><dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $application->nik }}</dd></div>
                <div><dt class="text-gray-500 dark:text-gray-400">Phone</dt><dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $application->phone ?: 'Not provided' }}</dd></div>
                <div><dt class="text-gray-500 dark:text-gray-400">Place of birth</dt><dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $application->birth_place }}</dd></div>
                <div><dt class="text-gray-500 dark:text-gray-400">Date of birth</dt><dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $application->birth_date->format('d M Y') }}</dd></div>
                <div><dt class="text-gray-500 dark:text-gray-400">Gender</dt><dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $application->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-gray-500 dark:text-gray-400">Address</dt><dd class="mt-1 whitespace-pre-line font-medium text-gray-900 dark:text-white">{{ $application->address }}</dd></div>
            </dl>

            @if ($application->photo)
                <div class="mt-6">
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">Profile photo</p>
                    <img src="{{ route('admin.membership-applications.photo', $application) }}" alt="Applicant profile" class="max-h-72 rounded-xl border border-gray-200 object-cover dark:border-gray-700">
                </div>
            @endif

            @if ($application->admin_note)
                <div class="mt-6 rounded-lg bg-gray-50 p-4 text-sm dark:bg-gray-800">
                    <p class="font-semibold">Previous review note</p>
                    <p class="mt-1 whitespace-pre-line">{{ $application->admin_note }}</p>
                </div>
            @endif
        </section>

        <section class="h-fit rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Decision</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Approval creates the member record and activates the account. A revision request keeps the account restricted. Rejection suspends member features.</p>

            @if (in_array($application->status, ['pending_review', 'needs_revision'], true))
                <form method="POST" action="{{ route('admin.membership-applications.decide', $application) }}" class="mt-5 space-y-4">
                    @csrf

                    @if ($errors->any())
                        <div role="alert" class="rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800 dark:border-red-900 dark:bg-red-950/30 dark:text-red-200">
                            Please correct the decision form below before saving.
                        </div>
                    @endif

                    <div>
                        <x-input-label for="decision" value="Decision" />
                        <select id="decision" name="decision" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">Choose an action</option>
                            <option value="approve" @selected(old('decision') === 'approve')>Approve application</option>
                            <option value="needs_revision" @selected(old('decision') === 'needs_revision')>Request revision</option>
                            <option value="reject" @selected(old('decision') === 'reject')>Reject application</option>
                        </select>
                        <x-input-error :messages="$errors->get('decision')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="admin_note" value="Note for applicant" />
                        <textarea id="admin_note" name="admin_note" rows="5" aria-describedby="admin-note-help" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">{{ old('admin_note') }}</textarea>
                        <p id="admin-note-help" class="mt-1 text-xs text-gray-500 dark:text-gray-400">Required when requesting a revision. Explain exactly what the applicant needs to correct. Optional for approval or rejection.</p>
                        <x-input-error :messages="$errors->get('admin_note')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">Save Decision</button>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const decision = document.getElementById('decision');
                        const note = document.getElementById('admin_note');

                        if (!decision || !note) return;

                        const syncNoteRequirement = () => {
                            note.required = decision.value === 'needs_revision';
                        };

                        decision.addEventListener('change', syncNoteRequirement);
                        syncNoteRequirement();
                    });
                </script>
            @else
                <p class="mt-4 rounded-lg bg-gray-50 p-4 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                    This application has been decided: {{ str($application->status)->replace('_', ' ')->title() }}.
                </p>
            @endif
        </section>
    </div>
</x-app-layout>
