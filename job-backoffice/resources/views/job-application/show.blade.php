<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobApplication->user->name }} | Applied to {{ $jobApplication->jobVacancy->title }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>

    <div class="p-6 bg-gray-50 min-h-screen">

        {{-- Back button --}}
        <div class="mb-4">
            <a href="{{ route('job-applications.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-50 transition shadow-sm text-sm">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div class="w-full mx-auto p-6 bg-white rounded-xl shadow-sm border border-gray-100">

            {{-- Job Application Main Information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-gray-100 pb-8 mb-6">
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-info-circle text-indigo-500"></i> Application Details
                    </h3>

                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 font-medium w-32">Applicant:</span>
                        <span class="text-gray-900 font-semibold">{{ $jobApplication->user->name }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 font-medium w-32">Company:</span>
                        <a href="{{ route('companies.show', $jobApplication->company->id ) }}"
                            class="text-indigo-600 hover:underline font-semibold flex items-center gap-1">
                            {{ $jobApplication->company->name }} <i class="bi bi-box-arrow-up-right text-xs"></i>
                        </a>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 font-medium w-32">Position:</span>
                        <span class="text-gray-900 flex items-center gap-1">
                            <i class="bi bi-briefcase text-gray-400"></i> {{ $jobApplication->jobVacancy->title }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4 md:pt-12">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 font-medium w-32">Status:</span>
                        @php
                            $statusClasses = match($jobApplication->status) {
                                'accepted' => 'bg-green-50 text-green-700 border-green-100',
                                'rejected' => 'bg-red-50 text-red-700 border-red-100',
                                'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                default => 'bg-gray-50 text-gray-700 border-gray-100',
                            };
                        @endphp
                        <span class="px-3 py-1 {{ $statusClasses }} border text-xs rounded-full font-bold uppercase tracking-wider">
                            {{ $jobApplication->status }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 font-medium w-32">Resume File:</span>
                        <a href="{{ $jobApplication->resume->fileUrl }}" target="_blank"
                            class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-bold underline">
                            <i class="bi bi-file-earmark-pdf"></i> View Original PDF
                        </a>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 justify-end mb-8">
                <a class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition shadow-sm text-sm font-medium"
                    href="{{ route('job-applications.edit', ['job_application' => $jobApplication->id, 'toList' => false ]) }}">
                    <i class="bi bi-pencil-square mr-2"></i> Edit Status
                </a>

                <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="inline-flex items-center px-4 py-2 bg-red-50 text-red-700 border border-red-100 rounded-lg hover:bg-red-100 transition shadow-sm text-sm font-medium">
                        <i class="bi bi-trash3 mr-2"></i> Archive
                    </button>
                </form>
            </div>

            {{-- Navigation Tabs --}}
            <div class="border-b border-gray-200 mb-6">
                <ul class="flex space-x-8">
                    <li>
                        <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'resume']) }}"
                            class="pb-4 px-1 inline-flex items-center gap-2 text-sm font-medium transition-all {{ request('tab') == 'resume' || request('tab') == '' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            <i class="bi bi-file-person"></i> Candidate Resume
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'AiFeedback']) }}"
                            class="pb-4 px-1 inline-flex items-center gap-2 text-sm font-medium transition-all {{ request('tab') == 'AiFeedback' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            <i class="bi bi-cpu"></i> AI Analysis
                        </a>
                    </li>
                </ul>
            </div>

            {{--Content Sections: --}}

            {{-- Resume Tab Content --}}
            <div id="resume" class="{{ request('tab') == 'resume' || request('tab') == '' ? 'block' : 'hidden' }}">
                @if(isset($jobApplication->resume))
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1 space-y-6">
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="bi bi-quote text-indigo-400"></i> Professional Summary
                                </h4>
                                <p class="text-sm text-gray-600 leading-relaxed italic">{{ $jobApplication->resume->summary }}</p>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="bi bi-brush text-indigo-400"></i> Core Skills
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $jobApplication->resume->skills) as $skill)
                                        <span class="px-3 py-1 bg-white border border-gray-200 text-xs font-medium rounded-full text-indigo-700 shadow-sm">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                                <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="bi bi-clock-history text-indigo-400"></i> Work Experience
                                </h4>
                                <p class="text-sm text-gray-600 whitespace-pre-line leading-loose">{{ $jobApplication->resume->experience }}</p>
                            </div>

                            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                                <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="bi bi-mortarboard-fill text-indigo-400"></i> Education & Certification
                                </h4>
                                <p class="text-sm text-gray-600 leading-relaxed">{{ $jobApplication->resume->education }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-16 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <i class="bi bi-file-earmark-x text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">No resume data synchronized for this applicant.</p>
                    </div>
                @endif
            </div>

            {{-- AI Feedback Tab Content --}}
            <div id="AiFeedback" class="{{ request('tab') == 'AiFeedback' ? 'block' : 'hidden' }}">
                @if(isset($jobApplication->aiGeneratedFeedback) || isset($jobApplication->aiGeneratedScore))
                    <div class="flex flex-col md:flex-row gap-8 items-stretch">
                        <div class="md:w-1/3 flex flex-col items-center justify-center p-8 bg-gradient-to-br from-indigo-50 to-white rounded-3xl border border-indigo-100 shadow-inner text-center">
                            <span class="text-xs font-black text-indigo-400 uppercase tracking-widest mb-2">Match Score</span>
                            <div class="relative">
                                <svg class="w-32 h-32 transform -rotate-90">
                                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" class="text-gray-100" />
                                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent"
                                        stroke-dasharray="364.4"
                                        stroke-dashoffset="{{ 364.4 - (364.4 * $jobApplication->aiGeneratedScore / 10) }}"
                                        class="text-indigo-600 transition-all duration-1000" />
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-3xl font-black text-indigo-700 leading-none">
                                        {{ $jobApplication->aiGeneratedScore }}
                                    </span>
                                    <span class="text-xs font-bold text-indigo-400 uppercase tracking-tighter">out of 10</span>
                                </div>
                            </div>
                        </div>

                        <div class="md:w-2/3 p-8 bg-white rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-center">
                            <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="bi bi-robot text-indigo-500"></i> AI Recommendation Feedback
                            </h4>
                            <p class="text-gray-600 leading-relaxed italic text-lg font-serif">
                                "{{ $jobApplication->aiGeneratedFeedback }}"
                            </p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-16 bg-gray-50 rounded-2xl">
                        <p class="text-gray-500">AI Analysis is pending or not available for this application.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
