<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>

    <div class="p-4 sm:p-6 mt-[-10px] min-h-screen">

        {{-- Back button (Only for Admin role) --}}
        @if (auth()->user()->role == 'admin')
            <div class="mb-4">
                <a href="{{ route('job-vacancies.index') }}"
                    class="bg-gray-200 rounded-lg text-black px-4 py-2 hover:bg-gray-300">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        @endif

        <div class="w-full mx-auto p-4 sm:p-6 bg-white rounded-xl shadow-sm border border-gray-200">

            {{-- Company Information Profile Grid --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-building text-indigo-600"></i> Company Profile
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                        <p class="text-[10px] text-indigo-500 uppercase font-black tracking-wider mb-1">Company Owner</p>
                        <p class="text-sm text-gray-900 font-bold flex items-center gap-2">
                            <i class="bi bi-person-circle text-indigo-400"></i> {{ $company->owner->name }}
                        </p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-black tracking-wider mb-1">Company Name</p>
                        <p class="text-sm text-gray-900 font-black">{{ $company->name }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-black tracking-wider mb-1">Industry</p>
                        <p class="text-sm text-gray-900 font-semibold">{{ $company->industry }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 sm:col-span-2">
                        <p class="text-[10px] text-gray-400 uppercase font-black tracking-wider mb-1">Headquarters Address</p>
                        <p class="text-sm text-gray-900 font-medium flex items-center gap-2">
                            <i class="bi bi-geo-alt text-red-400"></i> {{ $company->address }}
                        </p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-black tracking-wider mb-1">Website</p>
                        @if ($company->website)
                            <a href="{{ $company->website }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-sm font-bold inline-flex items-center gap-1.5 hover:underline">
                                <i class="bi bi-globe2"></i> Visit Site <i class="bi bi-box-arrow-up-right text-[10px]"></i>
                            </a>
                        @else
                            <span class="text-gray-400 italic text-xs">Not available</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Action buttons (Edit and Delete Controls) --}}
            <div class="flex items-center gap-2 justify-end mb-8">
                @if (auth()->user()->role == 'admin')
                    <a class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition shadow-sm text-sm font-medium"
                        href="{{ route('companies.edit', ['company' => $company->id, 'toList' => false ]) }}">
                        <i class="bi bi-pencil-square mr-2"></i> Edit
                    </a>

                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline" onsubmit="return confirm('Archive this company?')">
                        @csrf @method('DELETE')
                        <button class="inline-flex items-center px-4 py-2 bg-red-50 text-red-700 border border-red-100 rounded-lg hover:bg-red-100 transition shadow-sm text-sm font-medium" type="submit">
                            <i class="bi bi-trash3 mr-2"></i> Archive
                        </button>
                    </form>
                @else
                    <a class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition shadow-sm text-sm font-medium"
                        href="{{ route('my-company.edit') }}">
                        <i class="bi bi-pencil-square mr-2"></i> Edit Profile
                    </a>
                @endif
            </div>

            {{-- Navigation tabs switcher logic --}}
            @php
                $isJobsTab = request('tab') == 'jobs' || request('tab') == '';
                $isAppsTab = request('tab') == 'applications';
                $tabRoute = auth()->user()->role == 'admin' ? 'companies.show' : 'my-company.show';
            @endphp

            <div class="border-b border-gray-200 mb-4">
                <ul class="flex space-x-6 list-none p-0 m-0">
                    <li>
                        <a href="{{ route($tabRoute, ['company' => $company->id, 'tab' => 'jobs']) }}"
                            class="pb-3 px-1 inline-flex items-center gap-2 text-sm font-medium transition-all {{ $isJobsTab ? 'text-indigo-600 border-b-2 border-indigo-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                            <i class="bi bi-briefcase-fill"></i> Jobs ({{ $company->jobVacancies->count() }})
                        </a>
                    </li>
                    <li>
                        <a href="{{ route($tabRoute, ['company' => $company->id, 'tab' => 'applications']) }}"
                            class="pb-3 px-1 inline-flex items-center gap-2 text-sm font-medium transition-all {{ $isAppsTab ? 'text-indigo-600 border-b-2 border-indigo-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                            <i class="bi bi-file-earmark-person-fill"></i> Applications ({{ $company->jobApplications->count() }})
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Jobs Tab Content Container --}}
            <div id="jobs" class="{{ $isJobsTab ? 'block' : 'hidden' }} bg-white rounded-xl border border-gray-200 overflow-hidden w-full mt-4">
                <div class="overflow-x-auto min-w-full inline-block align-middle">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Title</th>
                                <th class="hidden sm:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Type</th>
                                <th class="hidden md:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Location</th>
                                <th class="px-4 sm:px-6 py-4 text-right text-gray-500 font-bold text-xs uppercase tracking-wider pr-6 sm:pr-10">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse( $company->jobVacancies as $jobVacancy )
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 sm:px-6 py-4 max-w-[180px] sm:max-w-none break-words">
                                        <div class="font-semibold text-sm text-gray-800">{{ $jobVacancy->title }}</div>
                                        {{-- Mobile Details --}}
                                        <div class="flex flex-col gap-0.5 mt-1 sm:hidden text-xs text-gray-500">
                                            <span class="font-medium text-indigo-600">{{ $jobVacancy->type }}</span>
                                            <span><i class="bi bi-geo-alt text-[10px]"></i> {{ $jobVacancy->location }}</span>
                                        </div>
                                    </td>
                                    <td class="hidden sm:table-cell px-6 py-4 text-sm text-gray-600">
                                        <span class="px-2.5 py-0.5 text-[11px] font-semibold bg-blue-50 text-blue-700 rounded-full border border-blue-100">{{ $jobVacancy->type }}</span>
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-500">{{ $jobVacancy->location }}</td>
                                    <td class="px-4 sm:px-6 py-4 pr-4 sm:pr-6 text-right whitespace-nowrap">
                                        <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}" class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition inline-flex items-center gap-1 text-sm font-medium">
                                            <i class="bi bi-eye text-base"></i> <span class="hidden sm:inline">View</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <i class="bi bi-briefcase text-4xl text-gray-300 block mb-3"></i>
                                        <span class="font-medium">No Jobs found for this company.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Applications Tab Content Container --}}
            <div id="applications" class="{{ $isAppsTab ? 'block' : 'hidden' }} bg-white rounded-xl border border-gray-200 overflow-hidden w-full mt-4">
                <div class="overflow-x-auto min-w-full inline-block align-middle">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Applicant Name</th>
                                <th class="hidden md:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Job Title</th>
                                <th class="hidden sm:table-cell px-6 py-4 text-center text-gray-500 font-bold text-xs uppercase tracking-wider">Status</th>
                                <th class="px-4 sm:px-6 py-4 text-right text-gray-500 font-bold text-xs uppercase tracking-wider pr-6 sm:pr-10">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse( $company->jobApplications as $jobApplication )
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 sm:px-6 py-4 max-w-[180px] sm:max-w-none break-words">
                                        <div class="font-semibold text-sm text-gray-800">{{ $jobApplication->user->name ?? 'None' }}</div>
                                        <div class="flex flex-col gap-0.5 mt-1 md:hidden text-xs text-gray-500">
                                            <span class="font-medium text-gray-600">{{ $jobApplication->jobVacancy->title ?? 'None' }}</span>
                                            <span class="sm:hidden mt-0.5">
                                                @php
                                                    $mobStatus = match($jobApplication->status) {
                                                        'accepted' => 'bg-green-50 text-green-700 border-green-100',
                                                        'rejected' => 'bg-red-50 text-red-700 border-red-100',
                                                        default => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                                    };
                                                @endphp
                                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full border {{ $mobStatus }}">{{ $jobApplication->status }}</span>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-500">{{ $jobApplication->jobVacancy->title ?? 'None' }}</td>
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
                                    <td class="px-4 sm:px-6 py-4 pr-4 sm:pr-6 text-right whitespace-nowrap">
                                        <a href="{{ route('job-applications.show', $jobApplication->id) }}" class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition inline-flex items-center gap-1 text-sm font-medium">
                                            <i class="bi bi-eye text-base"></i> <span class="hidden sm:inline">View</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <i class="bi bi-file-earmark-x text-4xl text-gray-300 block mb-3"></i>
                                        <span class="font-medium">No applications found for this company.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
