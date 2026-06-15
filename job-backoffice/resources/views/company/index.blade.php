<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company') }} {{ request()->input('archived') ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>

    <div class="p-4 sm:p-6 bg-gray-50 min-h-screen">

        {{-- Top Bar: Title & Active Status --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Companies</h1>
                <p class="text-sm text-gray-500">Manage registered companies and profiles</p>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                @if (request()->input('archived') == true)
                    <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition shadow-sm text-sm font-medium"
                        href="{{ route('companies.index') }}">
                        <i class="bi bi-eye"></i> View Active
                    </a>
                @else
                    <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition shadow-sm text-sm font-medium"
                        href="{{ route('companies.index', ['archived' => true]) }}">
                        <i class="bi bi-archive"></i> Show Archived
                    </a>
                @endif

                <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm text-sm font-medium"
                    href="{{ route('companies.create') }}">
                    <i class="bi bi-plus-circle"></i> Add Company
                </a>
            </div>
        </div>

        {{-- Company table container --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden w-full">
            <div class="overflow-x-auto min-w-full inline-block align-middle">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Name</th>
                            <th class="hidden md:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Address</th>
                            <th class="hidden lg:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Industry</th>
                            <th class="hidden sm:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Website</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider pr-6 sm:pr-10">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($companies as $company)
                            <tr class="hover:bg-gray-50 transition-colors">

                                {{-- Name & Mobile Meta Data --}}
                                <td class="px-4 sm:px-6 py-4 max-w-[160px] sm:max-w-none break-words">
                                    <div class="font-semibold text-sm">
                                        @if (request()->input('archived') == true)
                                            <span class="text-gray-700">{{ $company->name }}</span>
                                        @else
                                            <a href="{{ route('companies.show', $company->id) }}" class="text-indigo-600 hover:text-indigo-800 hover:underline">
                                                {{ $company->name }}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-0.5 mt-1 md:hidden text-xs text-gray-500">
                                        <span class="font-medium text-gray-600"><i class="bi bi-geo-alt text-[10px]"></i> {{ $company->address }}</span>
                                        <span class="lg:hidden text-gray-400">{{ $company->industry }}</span>
                                    </div>
                                </td>

                                {{-- Address (Hidden on mobile) --}}
                                <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600 whitespace-normal">{{ $company->address }}</td>

                                {{-- Industry (Hidden on mobile & tablet) --}}
                                <td class="hidden lg:table-cell px-6 py-4 text-sm text-gray-500">{{ $company->industry }}</td>

                                {{-- Website (Hidden on mobile) --}}
                                <td class="hidden sm:table-cell px-6 py-4 text-sm">
                                    @if ($company->website)
                                        <a class="text-indigo-600 hover:text-indigo-800 inline-flex items-center gap-1 font-medium hover:underline"
                                            target="_blank" href="{{ $company->website }}">
                                            <i class="bi bi-link-45deg"></i> Visit Site
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic text-xs">None</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 sm:px-6 py-4 pr-4 sm:pr-6 whitespace-nowrap">
                                    <div class="gap-1 sm:gap-2">
                                        {{-- Website Link (Hidden on mobile) --}}
                                        @if ($company->website)
                                            <a class="sm:hidden p-1.5 text-gray-500 hover:bg-gray-100 rounded-lg transition"
                                                target="_blank" href="{{ $company->website }}" title="Visit Website">
                                                <i class="bi bi-box-arrow-up-right text-sm"></i>
                                            </a>
                                        @endif

                                        @if (request()->input('archived') == true)
                                            <form action="{{ route('companies.restore', $company->id) }}" method="POST" class="inline">
                                                @csrf @method('PUT')
                                                <button class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Restore" type="submit">
                                                    <i class="bi bi-arrow-counterclockwise text-sm"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('companies.force-delete', $company->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete this company?')">
                                                @csrf @method('DELETE')
                                                <button class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Destroy" type="submit">
                                                    <i class="bi bi-x-circle text-sm"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition inline-flex" title="Edit"
                                                href="{{ route('companies.edit', ['company' => $company->id, 'toList' => true ]) }}">
                                                <i class="bi bi-pencil-square text-sm"></i>
                                            </a>

                                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline">
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
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="bi bi-building-x text-4xl text-gray-300 block mb-3"></i>
                                    <span class="font-medium">No companies found.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $companies->links() }}
        </div>
    </div>
</x-app-layout>
