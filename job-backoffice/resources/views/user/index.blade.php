<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }} {{ request()->input('archived') ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>

    <div class="overflow-x-auto p-6">

        <div class="flex justify-end space-x-2">
            @if (request()->input('archived') == true)
                {{-- Active users button --}}
                <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-black hover:bg-gray-800 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all"
                    href="{{ route('users.index') }}">
                    <i class="bi bi-folder2-open"></i>
                    Active users
                </a>
            @else
                {{-- Archived users button --}}
                <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-black hover:bg-gray-800 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all"
                    href="{{ route('users.index', ['archived' => true]) }}">
                    <i class="bi bi-file-earmark-zip"></i>
                    Archived users
                </a>
            @endif
        </div>

        {{-- users table --}}
        <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Name</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Email</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Role</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800 font-semibold">{{$user->name}}</td>
                        <td class="px-6 py-4 text-gray-800">{{$user->email}}</td>
                        <td class="px-6 py-4 text-gray-800">{{$user->role}}</td>
                        <td>
                            {{-- Action buttons (Destroy and Restore) --}}
                            @if (request()->input('archived') == true)
                                <div class="flex space-x-4">
                                    {{-- Restore button --}}
                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button class="text-blue-500 hover:text-blue-700" type="submit">
                                            <i class="bi bi-arrow-counterclockwise"></i>Restore
                                        </button>
                                    </form>

                                    {{-- Destroy button --}}
                                    <form action="{{ route('users.force-delete', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700" type="submit">
                                            <i class="bi bi-x-circle"></i>Destroy
                                        </button>
                                    </form>
                                </div>
                            @else
                            {{-- Action buttons (Edit and Delete) --}}
                                @if ($user->role !== 'admin')
                                    <div class="flex space-x-4">
                                        {{-- Edit button --}}
                                        <a class="text-blue-500 hover:text-blue-700"
                                        href="{{ route('users.edit', $user->id) }}">
                                            <i class="bi bi-pencil-square"></i>Edit
                                        </a>

                                        {{-- Delete button --}}
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-500 hover:text-red-700" type="submit">
                                                <i class="bi bi-trash3"></i>Arcive
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-500 italic">Can't modify admin</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>

</x-app-layout>
