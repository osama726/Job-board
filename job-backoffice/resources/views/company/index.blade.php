<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company') }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>


    <div class="overflow-x-auto p-6">

        <div class="flex justify-end space-x-2">
            @if (request()->input('archived') == true)
                {{-- Active company button --}}
                <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-black hover:bg-gray-800 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all"
                    href="{{ route('companies.index') }}">
                    <i class="bi bi-folder2-open"></i>
                    Active company
                </a>
            @else
                {{-- Archived company button --}}
                <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-black hover:bg-gray-800 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all"
                    href="{{ route('companies.index', ['archived' => true]) }}">
                    <i class="bi bi-file-earmark-zip"></i>
                    Archived company
                </a>
            @endif

            {{-- (Add a new job category) Buttom --}}
            <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all"
                href="{{ route('companies.create') }}">
                    <i class="bi bi-plus-circle"></i>
                    Add a new Company
            </a>
        </div>

        {{-- Job Category table --}}
        <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Name</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Address</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Industry</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Website</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($companies as $company)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">
                            @if (request()->input('archived') == true)
                                {{$company->name}}
                            @else
                                <a href="{{ route('companies.show', $company->id) }}" class="text-blue-500 hover:text-blue-700 font-bold">
                                    {{$company->name}}
                                </a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{$company->address}}</td>
                        <td class="px-6 py-4 text-gray-800">{{$company->industry}}</td>
                        <td class="px-6 py-4 text-gray-800">
                            @if ($company['website'])
                                <a class="text-blue-500 hover:text-blue-700"
                                    target="_blank"
                                    href="{{$company->website}}">
                                        <i class="bi bi-link-45deg"></i>Link
                                </a>
                            @else
                                undefined
                            @endif
                        </td>
                        <td>
                            {{-- Action buttons (Destroy and Restore) --}}
                            @if (request()->input('archived') == true)
                                <div class="flex space-x-4">
                                    {{-- Restore button --}}
                                    <form action="{{ route('companies.restore', $company->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button class="text-blue-500 hover:text-blue-700" type="submit">
                                            <i class="bi bi-arrow-counterclockwise"></i>Restore
                                        </button>
                                    </form>

                                    {{-- Destroy button --}}
                                    <form action="{{ route('companies.force-delete', $company->id) }}" method="POST" class="inline-block">
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
                                    href="{{ route('companies.edit', ['company' => $company->id, 'toList' => true ]) }}">
                                        <i class="bi bi-pencil-square"></i>Edit
                                    </a>

                                    {{-- Delete button --}}
                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline-block">
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
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No job company found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $companies->links() }}
        </div>
    </div>

</x-app-layout>
