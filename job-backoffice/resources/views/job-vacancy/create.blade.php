<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Job vacancy') }}
        </h2>
    </x-slot>

        {{-- Success and error messages --}}
    <x-toast-notification/>
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-8">
        <div>
            <p class="text-2xl font-bold text-gray-800">
                Create a new Job vacancy for your platform.
            </p>
        </div>

        <form action="{{ route('job-vacancies.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Job vacancy Details --}}
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold">Job vacancy Details</h3>
                <p class="text-sm">Enter Job vacancy details</p>

                <div class="mt-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Title
                    </label>

                    <input
                        id="title"
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Enter Job vacancy title"
                        class="{{ $errors->has('title') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                    >

                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Location
                    </label>

                    <input
                        id="location"
                        type="text"
                        name="location"
                        value="{{ old('location') }}"
                        placeholder="Enter Job vacancy location"
                        class="{{ $errors->has('location') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                    >

                    @error('location')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="salary" class="block text-sm font-medium text-gray-700 mb-2">
                        Expected Salary (USD)
                    </label>

                    <input
                        id="salary"
                        type="number"
                        name="salary"
                        value="{{ old('salary') }}"
                        placeholder="Enter expected salary"
                        class="{{ $errors->has('salary') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                    >

                    @error('salary')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Type
                    </label>

                    <select
                        id="type"
                        name="type"
                        class="{{ $errors->has('type') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                    >
                        <option value="Full-Time" {{ old('type') == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                        <option value="Contract" {{ old('type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                        <option value="Remote" {{ old('type') == 'Remote' ? 'selected' : '' }}>Remote</option>
                        <option value="Hybrid" {{ old('type') == 'Hyprid' ? 'selected' : '' }}>Hyprid</option>
                    </select>

                    @error('type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Company select dropdown --}}
                <div class="mt-4">
                    <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Company
                    </label>

                    <select
                        id="company_id"
                        name="company_id"
                        class="{{ $errors->has('company_id') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                    >
                        @foreach ( $companies as $company )
                            <option value="{{$company->id}}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('company_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Company select dropdown --}}
                <div class="mt-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Job Category
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        class="{{ $errors->has('category_id') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                    >
                        @foreach ( $categories as $category )
                            <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Job Description --}}
                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Job Description
                    </label>

                    <textarea class="{{ $errors->has('description') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                        id="description"
                        name="description"
                        rows="3"
                        placeholder="Enter job description">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Action buttons --}}
            <div class="flex justify-end items-center gap-3">
                <a
                    href="{{ route('job-vacancies.index') }}"
                    class="text-sm text-gray-600 hover:text-gray-900 py-2 px-4"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition"
                >
                    <i class="bi bi-check-circle"></i>
                    Save Job vacancy
                </button>
            </div>

        </form>

    </div>

</x-app-layout>
