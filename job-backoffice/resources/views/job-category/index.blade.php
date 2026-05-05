<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Category') }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>


    <div class="overflow-x-auto p-6">
        {{-- (Add a new job category) Buttom --}}
        <div class="flex justify-end">
            <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all"
                href="{{ route('job-categories.create') }}">
                    <i class="bi bi-plus-circle"></i>
                    Add a new job category
            </a>
        </div>

        {{-- Job Category table --}}
        <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">


            <thead>
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Category Name</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">{{$category['name']}}</td>
                        <td>
                            <div class="flex space-x-4">
                                {{-- Edit button --}}
                                <a class="text-blue-500 hover:text-blue-700" href="{{ route('job-categories.edit', $category->id) }}"><i class="bi bi-pencil-square"></i>Edit</a>

                                {{-- Delete button --}}
                                <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700" type="submit">
                                        <i class="bi bi-trash3"></i>Arcive
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>

</x-app-layout>
