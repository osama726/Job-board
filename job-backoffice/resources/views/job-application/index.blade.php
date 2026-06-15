<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Application') }} {{ request()->input('archived') ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>

    <div class="p-4 sm:p-6 bg-gray-50 min-h-screen">

        {{-- Top Bar: Title & Active Status --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Job Applications</h1>
                <p class="text-sm text-gray-500">Track and manage incoming candidate applications</p>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                @if (request()->input('archived') == true)
                    <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition shadow-sm text-sm font-medium"
                        href="{{ route('job-applications.index') }}">
                        <i class="bi bi-eye"></i> View Active
                    </a>
                @else
                    <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition shadow-sm text-sm font-medium"
                        href="{{ route('job-applications.index', ['archived' => true]) }}">
                        <i class="bi bi-archive"></i> Show Archived
                    </a>
                @endif
            </div>
        </div>

        {{-- Job Application table container --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden w-full">
            <div class="overflow-x-auto min-w-full inline-block align-middle">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Applicant Name</th>
                            <th class="hidden md:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Position</th>
                            @if (auth()->user()->role == 'admin')
                                <th class="hidden lg:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Company</th>
                            @endif
                            <th class="px-4 sm:px-6 py-4 text-center text-gray-500 font-bold text-xs uppercase tracking-wider">Status</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider pr-6 sm:pr-10">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($jobApplications as $jobApplication)
                            <tr class="hover:bg-gray-50 transition-colors">

                                {{-- Applicant Name & Mobile Meta Data --}}
                                <td class="px-4 sm:px-6 py-4 max-w-[160px] sm:max-w-none break-words">
                                    <div class="font-semibold text-sm">
                                        @if (request()->input('archived') == true)
                                            <span class="text-gray-700">{{ $jobApplication->user->name }}</span>
                                        @else
                                            <a href="{{ route('job-applications.show', $jobApplication->id) }}" class="text-indigo-600 hover:text-indigo-800 hover:underline">
                                                {{ $jobApplication->user->name }}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-0.5 mt-1 md:hidden text-xs text-gray-500">
                                        <span class="font-medium text-gray-600"><i class="bi bi-briefcase text-[10px]"></i> {{ $jobApplication->jobVacancy->title }}</span>
                                        @if (auth()->user()->role == 'admin')
                                            <span class="text-gray-400"><i class="bi bi-building text-[10px]"></i> {{ $jobApplication->company->name }}</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Position (Hidden on mobile) --}}
                                <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">{{ $jobApplication->jobVacancy->title }}</td>

                                {{-- Company for Admin (Hidden on mobile and tablet) --}}
                                @if (auth()->user()->role == 'admin')
                                    <td class="hidden lg:table-cell px-6 py-4 text-sm text-gray-500">{{ $jobApplication->company->name }}</td>
                                @endif

                                {{-- Status --}}
                                <td class="px-4 sm:px-6 py-4 text-center whitespace-nowrap">
                                    @php
                                        $statusClasses = match($jobApplication->status) {
                                            'accepted' => 'bg-green-50 text-green-700 border-green-100',
                                            'rejected' => 'bg-red-50 text-red-700 border-red-100',
                                            default => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 w-20 inline-block text-[11px] font-bold uppercase tracking-wider rounded-full border {{ $statusClasses }}">
                                        {{ $jobApplication->status }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 sm:px-6 py-4 pr-4 sm:pr-6 whitespace-nowrap">
                                    <div class="flex items-center justify-start gap-1 sm:gap-2">
                                        @if (request()->input('archived') == true)
                                            <form action="{{ route('job-applications.restore', $jobApplication->id) }}" method="POST" class="inline">
                                                @csrf @method('PUT')
                                                <button class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Restore" type="submit">
                                                    <i class="bi bi-arrow-counterclockwise text-sm"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('job-applications.force-delete', $jobApplication->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete this application?')">
                                                @csrf @method('DELETE')
                                                <button class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Destroy" type="submit">
                                                    <i class="bi bi-x-circle text-sm"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition inline-flex" title="Edit"
                                                href="{{ route('job-applications.edit', ['job_application' => $jobApplication->id, 'toList' => true ]) }}">
                                                <i class="bi bi-pencil-square text-sm"></i>
                                            </a>

                                            <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST" class="inline">
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
                                <td colspan="{{ auth()->user()->role == 'admin' ? 5 : 4 }}" class="px-6 py-12 text-center text-gray-500">
                                    <i class="bi bi-file-earmark-x text-4xl text-gray-300 block mb-3"></i>
                                    <span class="font-medium">No job applications found.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $jobApplications->links() }}
        </div>
    </div>
</x-app-layout>
