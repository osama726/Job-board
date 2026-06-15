<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Applicant status') }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-8">
        <div>
            <p class="text-2xl font-bold text-gray-800">
                Here you can edit your Applicant status ({{ $jobApplication->name }})
            </p>
        </div>

        <form action="{{ route('job-applications.update', $jobApplication->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Hidden input for listTo query parameter --}}
            <input type="hidden" name="toList" value="{{ request()->query('toList') }}">

            {{-- jobApplication Details --}}
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold">Job Application Details</h3>

                <div class="mt-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="{{ $errors->has('status') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition">

                        <option value="pending" {{ old('status', $jobApplication->status)  === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ old('status', $jobApplication->status) === 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ old('status', $jobApplication->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>

                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Applicant name
                    </label>

                    <span>{{ $jobApplication->user->name }}</span>
                </div>

                <div class="mt-4">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Company
                    </label>

                    <span>{{ $jobApplication->company->name }}</span>
                </div>

                <div class="mt-4">
                    <label for="salary" class="block text-sm font-medium text-gray-700 mb-2">
                        Position
                    </label>

                    <span>{{ $jobApplication->jobVacancy->title }}</span>
                </div>

                <div class="mt-4">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Resume File
                    </label>

                    <a href="{{ $jobApplication->resume->fileUrl }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                        View Resume
                    </a>
                </div>

            </div>

            {{-- Action buttons --}}
            <div class="flex justify-end items-center gap-3">
                <a
                    href="{{ route('job-applications.index') }}"
                    class="text-sm text-gray-600 hover:text-gray-900 py-2 px-4"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition"
                >
                    <i class="bi bi-check-circle"></i>
                    Save Changes
                </button>
            </div>

        </form>

    </div>

</x-app-layout>
