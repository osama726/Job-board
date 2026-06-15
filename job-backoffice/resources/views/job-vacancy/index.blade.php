<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancy') }} {{ request()->input('archived') ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>

    <div class="p-4 sm:p-6 bg-gray-50 min-h-screen">

        {{-- Top Bar: Title & Active Status --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Job Vacancies</h1>
                <p class="text-sm text-gray-500">Manage your active and archived job listings</p>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                @if (request()->input('archived'))
                    <a href="{{ route('job-vacancies.index') }}" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition shadow-sm text-sm font-medium">
                        <i class="bi bi-eye"></i> View Active
                    </a>
                @else
                    <a href="{{ route('job-vacancies.index', ['archived' => true]) }}" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition shadow-sm text-sm font-medium">
                        <i class="bi bi-archive"></i> Show Archived
                    </a>
                @endif

                <a href="{{ route('job-vacancies.create') }}" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm text-sm font-medium">
                    <i class="bi bi-plus-circle"></i> Post New Job
                </a>
            </div>
        </div>

        {{-- Job vacancy table container --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden w-full">
            <div class="overflow-x-auto min-w-full inline-block align-middle">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Title</th>
                            <th class="hidden md:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Company</th>
                            <th class="hidden lg:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Location</th>
                            <th class="hidden sm:table-cell px-3 py-4 text-center text-gray-500 font-bold text-xs uppercase tracking-wider">Type</th>
                            <th class="px-3 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Salary</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider pr-6 sm:pr-10">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($jobVacancies as $jobVacancy)
                            <tr class="hover:bg-gray-50 transition-colors">

                                {{-- Title & Mobile Meta Data --}}
                                <td class="px-4 sm:px-6 py-4 max-w-[170px] sm:max-w-none break-words">
                                    <div class="font-semibold text-sm">
                                        @if (request()->input('archived') == true)
                                            <span class="text-gray-700">{{ $jobVacancy->title }}</span>
                                        @else
                                            <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}" class="text-indigo-600 hover:text-indigo-800 hover:underline">
                                                {{ $jobVacancy->title }}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-0.5 mt-1 md:hidden text-xs text-gray-500">
                                        <span class="font-medium text-gray-600">{{ $jobVacancy->company->name }}</span>
                                        <span class="flex items-center gap-1"><i class="bi bi-geo-alt text-[10px]"></i> {{ $jobVacancy->location }}</span>
                                    </div>
                                </td>

                                {{-- Company (Hidden on mobile) --}}
                                <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">{{ $jobVacancy->company->name }}</td>

                                {{-- Location (Hidden on mobile and tablet) --}}
                                <td class="hidden lg:table-cell px-6 py-4 text-sm text-gray-500">
                                    <span class="flex items-center gap-1"><i class="bi bi-geo-alt"></i> {{ $jobVacancy->location }}</span>
                                </td>

                                {{-- Type --}}
                                <td class="hidden sm:table-cell px-3 py-4 whitespace-nowrap">
                                    <div class="px-2 py-1 w-15 text-center text-xs font-medium rounded-full bg-blue-50 text-blue-700">
                                        {{ $jobVacancy->type }}
                                    </div>
                                </td>

                                {{-- Salary --}}
                                <td class="px-3 sm:px-6 py-4 text-sm font-bold text-gray-900 whitespace-nowrap">
                                    <div>${{ number_format($jobVacancy->salary, 0) }}</div>
                                    {{-- marge type and salary in small screens --}}
                                    <div class="mt-1 sm:hidden">
                                        <span class="inline-block text-[13px] font-medium rounded-full text-blue-700">
                                            {{ $jobVacancy->type }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 sm:px-6 py-4 pr-4 sm:pr-6 whitespace-nowrap">
                                    <div class="gap-1 sm:gap-2">
                                        @if (request()->input('archived') == true)
                                            <form action="{{ route('job-vacancies.restore', $jobVacancy->id) }}" method="POST" class="inline">
                                                @csrf @method('PUT')
                                                <button class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Restore" type="submit">
                                                    <i class="bi bi-arrow-counterclockwise text-sm"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('job-vacancies.force-delete', $jobVacancy->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete this vacancy?')">
                                                @csrf @method('DELETE')
                                                <button class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Destroy" type="submit">
                                                    <i class="bi bi-x-circle text-sm"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition inline-flex" title="Edit"
                                                href="{{ route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'toList' => true ]) }}">
                                                <i class="bi bi-pencil-square text-sm"></i>
                                            </a>

                                            <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Archive" type="submit">
                                                    <i class="bi bi-trash3 text-sm"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <i class="bi bi-inbox text-4xl text-gray-300 block mb-3"></i>
                                    <span class="font-medium">No job vacancies found.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $jobVacancies->links() }}
        </div>
    </div>
</x-app-layout>
