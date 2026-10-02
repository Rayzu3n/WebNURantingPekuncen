<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                Edit News Category
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Update the selected news category.
            </p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-2xl">

        <div
            class="overflow-hidden rounded-2xl border
            border-gray-200 bg-white
            shadow-lg shadow-gray-300/40
            dark:border-gray-800 dark:bg-[#111827]
            dark:shadow-black/20">

            <!-- Header -->
            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800 sm:px-8">

                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Category Information
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Update the category name and URL slug.
                </p>

            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6 px-6 py-6 sm:px-8 sm:py-8">

                    <!-- Name -->
                    <div>

                        <x-input-label for="name" value="Name"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-300" />

                        <x-text-input id="name" class="mt-2 block w-full" type="text" name="name"
                            :value="old('name', $category->name)" placeholder="e.g. Kegiatan" required autofocus />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    </div>

                    <!-- Slug -->
                    <div>

                        <x-input-label for="slug" value="Slug"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-300" />

                        <x-text-input id="slug" class="mt-2 block w-full" type="text" name="slug"
                            :value="old('slug', $category->slug)" placeholder="kegiatan" required />

                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                            Use lowercase letters, numbers, and hyphens.
                        </p>

                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />

                    </div>

                </div>

                <!-- Footer -->
                <div
                    class="flex flex-col-reverse gap-3 border-t
                    border-gray-200 bg-gray-50/70 px-6 py-5
                    dark:border-gray-800 dark:bg-gray-900/40
                    sm:flex-row sm:items-center sm:justify-end sm:px-8">

                    <a href="{{ route('admin.categories.index') }}"
                        class="inline-flex items-center justify-center rounded-xl
                        border border-gray-300 bg-white px-4 py-2.5
                        text-sm font-semibold text-gray-700
                        transition-colors hover:bg-gray-50
                        dark:border-gray-700 dark:bg-gray-800
                        dark:text-gray-300 dark:hover:bg-gray-700">
                        Cancel
                    </a>

                    <x-primary-button
                        class="justify-center rounded-xl bg-blue-600
                        px-5 py-2.5 text-sm font-semibold
                        shadow-lg shadow-blue-200/40
                        hover:bg-blue-700
                        dark:bg-blue-500 dark:shadow-blue-950/20
                        dark:hover:bg-blue-600">
                        Update Category
                    </x-primary-button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
