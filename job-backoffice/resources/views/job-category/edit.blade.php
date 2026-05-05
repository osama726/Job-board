<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit your Category') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8">


        <div>
            <p class="text-2xl font-bold text-gray-800">
                Here you can edit in your Category ({{ $category->name }})
            </p>
        </div>
        {{-- Category form --}}
        <form action="{{ route('job-categories.update', $category->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Category Name
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    placeholder="Enter category name"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                >

                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action buttons --}}
            <div class="flex justify-end items-center gap-3">
                <a
                    href="{{ route('job-categories.index') }}"
                    class="text-sm text-gray-600 hover:text-gray-900 py-2 px-4"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition"
                >
                    <i class="bi bi-check-circle"></i>
                    Save Category
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
