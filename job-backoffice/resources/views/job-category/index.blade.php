<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Category') }} {{ request()->input('archived') ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>

    <div class="p-4 sm:p-6 bg-gray-50 min-h-screen">

        {{-- Top Bar: Title & Active Status --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Job Categories</h1>
                <p class="text-sm text-gray-500">Manage sectors and categories for job listings</p>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                @if (request()->input('archived') == true)
                    <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition shadow-sm text-sm font-medium"
                        href="{{ route('job-categories.index') }}">
                        <i class="bi bi-eye"></i> View Active
                    </a>
                @else
                    <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition shadow-sm text-sm font-medium"
                        href="{{ route('job-categories.index', ['archived' => true]) }}">
                        <i class="bi bi-archive"></i> Show Archived
                    </a>
                @endif

                <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm text-sm font-medium"
                    href="{{ route('job-categories.create') }}">
                    <i class="bi bi-plus-circle"></i> Add Category
                </a>
            </div>
        </div>

        {{-- Job Category table container --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden w-full">
            <div class="overflow-x-auto min-w-full inline-block align-middle">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Category Name</th>
                            <th class="px-4 sm:px-6 py-4 text-center text-gray-500 font-bold text-xs uppercase tracking-wider pr-6 sm:pr-10">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors">

                                {{-- Category Name --}}
                                <td class="px-4 sm:px-6 py-4 text-sm font-semibold text-gray-800 break-words">
                                    {{ $category->name }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 sm:px-6 py-4 pr-4 sm:pr-6 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1 sm:gap-2">
                                        @if (request()->input('archived') == true)
                                            <form action="{{ route('job-categories.restore', $category->id) }}" method="POST" class="inline">
                                                @csrf @method('PUT')
                                                <button class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Restore" type="submit">
                                                    <i class="bi bi-arrow-counterclockwise text-sm"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('job-categories.force-delete', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete this category?')">
                                                @csrf @method('DELETE')
                                                <button class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Destroy" type="submit">
                                                    <i class="bi bi-x-circle text-sm"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition inline-flex" title="Edit"
                                                href="{{ route('job-categories.edit', $category->id) }}">
                                                <i class="bi bi-pencil-square text-sm"></i>
                                            </a>

                                            <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST" class="inline">
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
                                <td colspan="2" class="px-6 py-12 text-center text-gray-500">
                                    <i class="bi bi-tags text-4xl text-gray-300 block mb-3"></i>
                                    <span class="font-medium">No job categories found.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
