<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[9px] font-extrabold uppercase tracking-[.17em] text-[#b75d3c]">Kalender komunitas</p>
            <h2 class="mt-1 font-editorial text-xl font-extrabold tracking-[-.045em] text-[#192b23] dark:text-[#ebefe5] sm:text-2xl">Tambah kegiatan</h2>
        </div>
    </x-slot>

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('admin.events.form')
    </form>
</x-app-layout>
