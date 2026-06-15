<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>

    <div class="p-4 sm:p-6 mt-[-10px] min-h-screen">

        {{-- Back button --}}
        <div class="mb-4">
            <a href="{{ route('job-vacancies.index') }}"
                class="bg-gray-200 rounded-lg text-black px-4 py-2 hover:bg-gray-300">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="w-full mx-auto p-4 sm:p-6 bg-white rounded-xl shadow-sm border border-gray-200">

            {{-- Job vacancy Information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 pb-6 mb-6">
                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Job Vacancy Information</h3>

                    <div class="flex items-center gap-2 text-sm sm:text-base">
                        <span class="text-gray-400 font-medium w-24 sm:w-32">Title:</span>
                        <span class="text-gray-900 font-semibold">{{ $jobVacancy->title }}</span>
                    </div>

                    <div class="flex items-center gap-2 text-sm sm:text-base">
                        <span class="text-gray-400 font-medium w-24 sm:w-32">Company:</span>
                        <span class="text-indigo-600 hover:text-indigo-900 font-semibold hover:underline">
                            <a href="{{ route('companies.show', $jobVacancy->company->id) }}">{{ $jobVacancy->company->name }}</a>
                        </span>
                    </div>

                    <div class="flex items-center gap-2 text-sm sm:text-base">
                        <span class="text-gray-400 font-medium w-24 sm:w-32">Location:</span>
                        <span class="text-gray-700 flex items-center gap-1"><i class="bi bi-geo-alt text-gray-400"></i>{{ $jobVacancy->location }}</span>
                    </div>
                </div>

                <div class="space-y-3 md:pt-9">
                    <div class="flex items-center gap-2 text-sm sm:text-base">
                        <span class="text-gray-400 font-medium w-24 sm:w-32">Type:</span>
                        <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 text-xs rounded-full font-bold border border-blue-100">
                            {{ $jobVacancy->type }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2 text-sm sm:text-base">
                        <span class="text-gray-400 font-medium w-24 sm:w-32">Salary:</span>
                        <span class="text-gray-900 font-black text-lg">
                            <span class="text-sm font-normal text-gray-400 mr-0.5">$</span>{{ number_format($jobVacancy->salary, 0) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Description Section --}}
            <div class="bg-gray-50 rounded-xl p-4 sm:p-5 border border-gray-100 mb-6">
                <h4 class="text-gray-800 font-bold mb-3 flex items-center gap-2 text-sm sm:text-base">
                    <i class="bi bi-justify-left text-indigo-500"></i> Description
                </h4>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line text-sm">
                    {{ $jobVacancy->description }}
                </p>
            </div>

            {{-- Action buttons (Edit and Delete) --}}
            <div class="flex items-center gap-2 justify-end mb-8">
                <a class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition shadow-sm text-sm font-medium"
                    href="{{ route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'toList' => false ]) }}">
                    <i class="bi bi-pencil-square mr-2"></i> Edit
                </a>

                <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST" class="inline" onsubmit="return confirm('Archive this vacancy?')">
                    @csrf @method('DELETE')
                    <button class="inline-flex items-center px-4 py-2 bg-red-50 text-red-700 border border-red-100 rounded-lg hover:bg-red-100 transition shadow-sm text-sm font-medium" type="submit">
                        <i class="bi bi-trash3 mr-2"></i> Archive
                    </button>
                </form>
            </div>

            {{-- Navigation tabs --}}
            <div class="border-b border-gray-200 mb-4">
                <ul class="flex space-x-8 list-none p-0 m-0">
                    <li>
                        <span class="pb-3 px-1 inline-flex items-center gap-2 text-sm font-bold text-indigo-600 border-b-2 border-indigo-600">
                            <i class="bi bi-file-earmark-person-fill"></i> Applications ({{ $jobVacancy->jobApplications->count() }})
                        </span>
                    </li>
                </ul>
            </div>

            {{-- Applications Tab Table Container --}}
            <div id="applications" class="bg-white rounded-xl border border-gray-200 overflow-hidden w-full mt-4">
                <div class="overflow-x-auto min-w-full inline-block align-middle">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Applicant Name</th>
                                <th class="hidden md:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Job Title</th>
                                <th class="hidden sm:table-cell px-6 py-4 text-center text-gray-500 font-bold text-xs uppercase tracking-wider">Status</th>
                                <th class="px-4 sm:px-6 py-4 text-center text-gray-500 font-bold text-xs uppercase tracking-wider pr-6 sm:pr-10">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse( $jobVacancy->jobApplications as $jobApplication )
                                <tr class="hover:bg-gray-50 transition-colors">
                                    {{-- Name & Status on mobile --}}
                                    <td class="px-4 sm:px-6 py-4 max-w-[180px] sm:max-w-none break-words">
                                        <div class="font-semibold text-sm text-gray-800">
                                            {{ $jobApplication->user->name }}
                                        </div>
                                        <div class="mt-1 sm:hidden">
                                            @php
                                                $mobileStatusClasses = match($jobApplication->status) {
                                                    'accepted' => 'bg-green-50 text-green-700 border-green-100',
                                                    'rejected' => 'bg-red-50 text-red-700 border-red-100',
                                                    default => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                                };
                                            @endphp
                                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-full border {{ $mobileStatusClasses }}">
                                                {{ $jobApplication->status }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Job Title (Hidden on mobile) --}}
                                    <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-500">{{ $jobApplication->jobVacancy->title }}</td>

                                    {{-- Status Desktop Component --}}
                                    <td class="hidden sm:table-cell px-6 py-4 text-center whitespace-nowrap">
                                        @php
                                            $statusClasses = match($jobApplication->status) {
                                                'accepted' => 'bg-green-50 text-green-700 border-green-100',
                                                'rejected' => 'bg-red-50 text-red-700 border-red-100',
                                                default => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                            };
                                        @endphp
                                        <span class="px-2.5 py-0.5 inline-block text-[11px] font-bold uppercase tracking-wider rounded-full border {{ $statusClasses }}">
                                            {{ $jobApplication->status }}
                                        </span>
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-4 sm:px-6 py-4 pr-4 sm:pr-6 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-center">
                                            <a href="{{ route('job-applications.show', $jobApplication->id) }}"
                                                class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition inline-flex items-center gap-1 text-sm font-medium" title="View Application">
                                                <i class="bi bi-eye text-base"></i>
                                                <span class="hidden sm:inline">View</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <i class="bi bi-file-earmark-x text-4xl text-gray-300 block mb-3"></i>
                                        <span class="font-medium">No applications found for this vacancy.</span>
                                    </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
