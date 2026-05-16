<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($jobVacancy->title) }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>

    <div class="overflow-x-auto p-6">

        {{-- Back button --}}
        <a href="{{ route('job-vacancies.index') }}"
            class="bg-gray-200 rounded-lg text-black px-4 py-2 hover:bg-gray-300">
            <i class="bi bi-arrow-left"></i> Back
        </a>

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow mt-4">
            {{-- Job vacancy Information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 pb-6 mb-6">
                <div class="space-y-3">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Job Vacancy Information</h3>

                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 font-medium w-32">Title:</span>
                        <span class="text-gray-900">{{ $jobVacancy->title }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 font-medium w-32">Company:</span>
                        <span class="text-indigo-500 hover:text-indigo-700 font-semibold underline">
                            <a href="{{ route('companies.show', $jobVacancy->company->id ) }}">{{ $jobVacancy->company->name }}</a>
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 font-medium w-32">Location:</span>
                        <span class="text-gray-900"><i class="bi bi-geo-alt mr-1"></i>{{ $jobVacancy->location }}</span>
                    </div>
                </div>

                <div class="space-y-3 md:pt-11">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 font-medium w-32">Type:</span>
                        <span class="px-2 py-1 bg-green-50 text-green-700 text-xs rounded-full font-semibold">
                            {{ $jobVacancy->type }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 font-medium w-32">Salary:</span>
                        <span class="text-gray-900 font-bold text-lg">
                            <span class="text-sm font-normal text-gray-500">$</span>{{ number_format($jobVacancy->salary, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 mb-3">
                <h4 class="text-gray-800 font-bold mb-3 flex items-center gap-2">
                    <i class="bi bi-justify-left text-indigo-500"></i> Description
                </h4>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line text-sm md:text-base">
                    {{ $jobVacancy->description }}
                </p>
            </div>

            {{-- Action buttons (Edit and Delete) --}}
            <div class="flex items-center gap-3 justify-end">
                {{-- Edit button --}}
                <a class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition shadow-sm text-sm font-medium"
                href="{{ route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'toList' => false ]) }}">
                    <i class="bi bi-pencil-square mr-2"></i> Edit
                </a>

                {{-- Delete button --}}
                <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="inline-flex items-center px-4 py-2 bg-red-50 text-red-700 border border-red-100 rounded-lg hover:bg-red-100 transition shadow-sm text-sm font-medium"
                    type="submit">
                        <i class="bi bi-trash3 mr-2"></i> Archive
                    </button>
                </form>
            </div>

            {{-- Navigation tabs --}}
            <div class="border-b border-gray-200 mb-6">
                <ul class="flex space-x-8">
                    <li>
                        <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}"
                            class="pb-4 px-1 inline-flex items-center gap-2 text-sm font-medium transition-all text-indigo-600 border-b-2 border-indigo-600">
                            <i class="bi bi-menu-up"></i> Applications
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Applications Tab --}}
            <div id="applications">
                <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-gray-50">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-800 rounded-tl-lg">AplicantName</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-800">Job Title</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-800">Status</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-800 rounded-tr-lg">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( $jobVacancy->jobApplications as $jobApplication )
                            <tr>
                                <td class="px-4 py-2">{{ $jobApplication->user->name }}</td>
                                <td class="px-4 py-2">{{ $jobApplication->jobVacancy->title }}</td>
                                <td class="px-4 py-2">{{ $jobApplication->status }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('job-applications.show', $jobApplication->id) }}"
                                        class="text-blue-500 hover:text-blue-700 font-medium text-sm gap-1">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center text-gray-500">No applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</x-app-layout>
