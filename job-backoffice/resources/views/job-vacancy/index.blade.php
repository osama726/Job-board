<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancy') }} {{ request()->input('archived') ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>


    <div class="overflow-x-auto p-6">

        <div class="flex justify-end space-x-2">
            @if (request()->input('archived') == true)
                {{-- Active jobVacancy button --}}
                <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-black hover:bg-gray-800 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all"
                    href="{{ route('job-vacancies.index') }}">
                    <i class="bi bi-folder2-open"></i>
                    Active job vacancy
                </a>
            @else
                {{-- Archived jobVacancy button --}}
                <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-black hover:bg-gray-800 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all"
                    href="{{ route('job-vacancies.index', ['archived' => true]) }}">
                    <i class="bi bi-file-earmark-zip"></i>
                    Archived job vacancy
                </a>
            @endif

            {{-- (Add a new jobVacancy) Buttom --}}
            <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all"
                href="{{ route('job-vacancies.create') }}">
                    <i class="bi bi-plus-circle"></i>
                    Add a new job vacancy
            </a>
        </div>

        {{-- Job jobVacancy table --}}
        <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Title</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Company</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Location</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Type</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Salary</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobVacancies as $jobVacancy)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">
                            @if (request()->input('archived') == true)
                                {{$jobVacancy->title}}
                            @else
                                <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}" class="text-blue-500 hover:text-blue-700 font-bold">
                                    {{$jobVacancy->title}}
                                </a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{$jobVacancy->company->name}}</td>
                        <td class="px-6 py-4 text-gray-800">{{$jobVacancy->location}}</td>
                        <td class="px-6 py-4 text-gray-800">{{$jobVacancy->type}}</td>
                        <td class="px-6 py-4 text-gray-800">$ {{ number_format($jobVacancy->salary, 2) }}</td>
                        <td>
                            {{-- Action buttons (Destroy and Restore) --}}
                            @if (request()->input('archived') == true)
                                <div class="flex space-x-4">
                                    {{-- Restore button --}}
                                    <form action="{{ route('job-vacancies.restore', $jobVacancy->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button class="text-blue-500 hover:text-blue-700" type="submit">
                                            <i class="bi bi-arrow-counterclockwise"></i>Restore
                                        </button>
                                    </form>

                                    {{-- Destroy button --}}
                                    <form action="{{ route('job-vacancies.force-delete', $jobVacancy->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700" type="submit">
                                            <i class="bi bi-x-circle"></i>Destroy
                                        </button>
                                    </form>
                                </div>
                            @else
                            {{-- Action buttons (Edit and Delete) --}}
                                <div class="flex space-x-4">
                                    {{-- Edit button --}}
                                    <a class="text-blue-500 hover:text-blue-700"
                                    href="{{ route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'toList' => true ]) }}">
                                        <i class="bi bi-pencil-square"></i>Edit
                                    </a>

                                    {{-- Delete button --}}
                                    <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700" type="submit">
                                            <i class="bi bi-trash3"></i>Arcive
                                        </button>
                                    </form>
                                </div>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No job vacancies found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $jobVacancies->links() }}
        </div>
    </div>

</x-app-layout>
