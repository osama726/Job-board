<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($company->name) }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>

    <div class="overflow-x-auto p-6">

        {{-- Back button --}}
        <a href="{{ route('companies.index') }}"
            class="bg-gray-200 rounded-lg text-black px-4 py-2 hover:bg-gray-300">
            <i class="bi bi-arrow-left"></i> Back
        </a>

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow mt-4">
            {{-- Company Information --}}
            <div>
                <h3 class="text-lg font-bold">Company Information</h3>
                <p><strong>Company owner:</strong> {{ $company->owner->name }}</p>
                <p><strong>Company Name:</strong> {{ $company->name }}</p>
                <p><strong>Industry:</strong> {{ $company->industry }}</p>
                <p><strong>Address:</strong> {{ $company->address }}</p>
                <p><strong>Website:</strong>
                    @if ($company['website'])
                        <a class="text-blue-500 hover:text-blue-700"
                            target="_blank"
                            href="{{$company->website}}">
                                <i class="bi bi-link-45deg"></i>Link
                        </a>
                    @else
                        undefined
                    @endif
                </p>
            </div>

            {{-- Action buttons (Edit and Delete) --}}
            <div class="flex items-center gap-3 justify-end">
                {{-- Edit button --}}
                <a class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors duration-200 text-sm font-medium"
                href="{{ route('companies.edit', ['company' => $company->id, 'toList' => false ]) }}">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>

                {{-- Delete button --}}
                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700  rounded-lg hover:bg-red-100 transition-colors duration-200 text-sm font-medium"
                    type="submit">
                        <i class="bi bi-trash3"></i> Archive
                    </button>
                </form>
            </div>

            {{-- Navigation tabs --}}
            <div class="mb-6">
                <ul class="flex space-x-5">
                    <li>
                        <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'jobs']) }}"
                            class="px-4 py-2 hover:text-gray-400 {{ request('tab') == 'jobs' || request('tab') == '' ? 'bg-gray-100 text-gray-700 border-b-2 border-blue-400  rounded-md' : '' }}">
                            Jobs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'applications']) }}"
                            class="px-4 py-2 hover:text-gray-400 {{ request('tab') == 'applications' ? 'bg-gray-100 text-gray-700 border-b-2 border-blue-400  rounded-md' : '' }}">
                            Applications
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Jobs Tab --}}
            <div id="jobs" class="{{ request('tab') == 'jobs' || request('tab') == ''? 'block' : 'hidden' }}">
                <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-gray-50">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-800 rounded-tl-lg">Title</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-800">Type</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-800">Location</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-800 rounded-tr-lg">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( $company->jobVacancies as $jobVacancy )
                            <tr>
                                <td class="px-4 py-2">{{ $jobVacancy->title }}</td>
                                <td class="px-4 py-2">{{ $jobVacancy->type }}</td>
                                <td class="px-4 py-2">{{ $jobVacancy->location }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}"
                                        class="text-blue-500 hover:text-blue-700">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center text-gray-500">No Jobs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Applications Tab --}}
            <div id="applications" class="{{ request('tab') == 'applications' ? 'block' : 'hidden' }}">
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
                        @forelse( $company->jobApplications as $jobApplication )
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
