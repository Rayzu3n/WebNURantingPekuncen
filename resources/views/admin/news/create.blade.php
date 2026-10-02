<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                Create News
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Create a new article for the portal.
            </p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl">

        <div
            class="overflow-hidden rounded-2xl border
            border-gray-200 bg-white
            shadow-lg shadow-gray-300/40
            dark:border-gray-800 dark:bg-[#111827]
            dark:shadow-black/20">

            <!-- Form Header -->
            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800 sm:px-8">

                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
                    News Information
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Fill in the information below to create a news article.
                </p>

            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6 px-6 py-6 sm:px-8 sm:py-8">

                    <!-- Title -->
                    <div>
                        <x-input-label for="title" value="Title"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-300" />

                        <x-text-input id="title" class="mt-2 block w-full" type="text" name="title"
                            :value="old('title')" placeholder="Enter news title" required autofocus />

                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Slug -->
                    <div>
                        <x-input-label for="slug" value="Slug"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-300" />

                        <x-text-input id="slug" class="mt-2 block w-full" type="text" name="slug"
                            :value="old('slug')" placeholder="news-article-slug" required />

                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                            Use a unique URL-friendly slug.
                        </p>

                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>

                    <!-- Category + Status -->
                    <div class="grid gap-6 md:grid-cols-2">

                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" value="Category"
                                class="text-sm font-semibold text-gray-700 dark:text-gray-300" />

                            <select id="category_id" name="category_id"
                                class="mt-2 block w-full rounded-xl border-gray-300 bg-white
                                px-4 py-2.5 text-sm text-gray-900 shadow-sm
                                transition
                                focus:border-blue-500 focus:ring-blue-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                dark:focus:border-blue-400 dark:focus:ring-blue-400"
                                required>
                                <option value="">Select category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" value="Status"
                                class="text-sm font-semibold text-gray-700 dark:text-gray-300" />

                            <select id="status" name="status"
                                class="mt-2 block w-full rounded-xl border-gray-300 bg-white
                                px-4 py-2.5 text-sm text-gray-900 shadow-sm
                                transition
                                focus:border-blue-500 focus:ring-blue-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                dark:focus:border-blue-400 dark:focus:ring-blue-400"
                                required>
                                <option value="draft" @selected(old('status', 'draft') === 'draft')>
                                    Draft
                                </option>

                                <option value="published" @selected(old('status') === 'published')>
                                    Published
                                </option>

                                <option value="archived" @selected(old('status') === 'archived')>
                                    Archived
                                </option>
                            </select>

                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                    </div>

                    <!-- Excerpt -->
                    <div>
                        <x-input-label for="excerpt" value="Excerpt"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-300" />

                        <textarea id="excerpt" name="excerpt" rows="4" placeholder="Write a short summary of the article..."
                            class="mt-2 block w-full rounded-xl border-gray-300 bg-white
                            px-4 py-3 text-sm text-gray-900 shadow-sm
                            placeholder:text-gray-400
                            transition
                            focus:border-blue-500 focus:ring-blue-500
                            dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                            dark:placeholder:text-gray-500
                            dark:focus:border-blue-400 dark:focus:ring-blue-400">{{ old('excerpt') }}</textarea>

                        <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                    </div>

                    <!-- Content -->
                    <div>
                        <x-input-label for="content" value="Content"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-300" />

                        <textarea id="content" name="content" rows="16" placeholder="Write the full news content..."
                            class="mt-2 block w-full rounded-xl border-gray-300 bg-white
                            px-4 py-3 text-sm leading-7 text-gray-900 shadow-sm
                            placeholder:text-gray-400
                            transition
                            focus:border-blue-500 focus:ring-blue-500
                            dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                            dark:placeholder:text-gray-500
                            dark:focus:border-blue-400 dark:focus:ring-blue-400"
                            required>{{ old('content') }}</textarea>

                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <!-- Thumbnail -->
                    <div>
                        <x-input-label for="thumbnail" value="Thumbnail"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-300" />

                        <div
                            class="mt-2 rounded-xl border border-dashed
                            border-gray-300 bg-gray-50 p-5
                            dark:border-gray-700 dark:bg-gray-900/50">

                            <input id="thumbnail" type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm text-gray-600
                                file:mr-4 file:rounded-lg file:border-0
                                file:bg-blue-50 file:px-4 file:py-2
                                file:text-sm file:font-semibold file:text-blue-700
                                hover:file:bg-blue-100
                                dark:text-gray-400
                                dark:file:bg-blue-500/10 dark:file:text-blue-400
                                dark:hover:file:bg-blue-500/20">

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                JPG, JPEG, PNG, or WebP. Maximum 2 MB.
                            </p>

                        </div>

                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>

                </div>

                <!-- Form Footer -->
                <div
                    class="flex flex-col-reverse gap-3 border-t
                    border-gray-200 bg-gray-50/70 px-6 py-5
                    dark:border-gray-800 dark:bg-gray-900/40
                    sm:flex-row sm:items-center sm:justify-end sm:px-8">

                    <a href="{{ route('admin.news.index') }}"
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
                        Save News
                    </x-primary-button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
