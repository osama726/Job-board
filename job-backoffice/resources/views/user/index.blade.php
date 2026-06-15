<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }} {{ request()->input('archived') ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>

    <div class="p-4 sm:p-6 bg-gray-50 min-h-screen">

        {{-- Top Bar: Title & Active Status --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Users</h1>
                <p class="text-sm text-gray-500">Manage system users, roles, and account statuses</p>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                @if (request()->input('archived') == true)
                    <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition shadow-sm text-sm font-medium"
                        href="{{ route('users.index') }}">
                        <i class="bi bi-eye"></i> View Active
                    </a>
                @else
                    <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition shadow-sm text-sm font-medium"
                        href="{{ route('users.index', ['archived' => true]) }}">
                        <i class="bi bi-archive"></i> Show Archived
                    </a>
                @endif
            </div>
        </div>

        {{-- Users table container --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden w-full">
            <div class="overflow-x-auto min-w-full inline-block align-middle">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Name</th>
                            <th class="hidden md:table-cell px-6 py-4 text-left text-gray-500 font-bold text-xs uppercase tracking-wider">Email</th>
                            <th class="px-4 sm:px-6 py-4 text-center text-gray-500 font-bold text-xs uppercase tracking-wider">Role</th>
                            <th class="px-4 sm:px-6 py-4 text-center text-gray-500 font-bold text-xs uppercase tracking-wider pr-6 sm:pr-10">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">

                                {{-- Name & Mobile Meta (Email) --}}
                                <td class="px-4 sm:px-6 py-4 max-w-[160px] sm:max-w-none break-words">
                                    <div class="font-semibold text-sm text-gray-800">
                                        {{ $user->name }}
                                    </div>
                                    <div class="mt-0.5 md:hidden text-xs text-gray-500">
                                        {{ $user->email }}
                                    </div>
                                </td>

                                {{-- Email (Hidden on mobile) --}}
                                <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>

                                {{-- Role --}}
                                <td class="px-4 sm:px-6 py-4 text-center ">
                                    @php
                                        $roleClasses = match($user->role) {
                                            'admin' => 'bg-purple-50 text-purple-700 border-purple-100',
                                            'company-owner' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                            default => 'bg-blue-50 text-blue-700 border-blue-100',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 w-full inline-block text-[11px] font-semibold uppercase tracking-wider rounded-full border {{ $roleClasses }}">
                                        {{ $user->role == 'company-owner' ? 'Owner' : ($user->role == 'job-seeker' ? 'Job seeker' : $user->role) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 sm:px-6 py-4 pr-4 sm:pr-6 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1 sm:gap-2">
                                        @if (request()->input('archived') == true)
                                            <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline">
                                                @csrf @method('PUT')
                                                <button class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Restore" type="submit">
                                                    <i class="bi bi-arrow-counterclockwise text-sm"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('users.force-delete', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete this user?')">
                                                @csrf @method('DELETE')
                                                <button class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Destroy" type="submit">
                                                    <i class="bi bi-x-circle text-sm"></i>
                                                </button>
                                            </form>
                                        @else
                                            @if ($user->role !== 'admin')
                                                <a class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition inline-flex" title="Edit"
                                                    href="{{ route('users.edit', $user->id) }}">
                                                    <i class="bi bi-pencil-square text-sm"></i>
                                                </a>

                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Archive" type="submit">
                                                        <i class="bi bi-trash3 text-sm"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-400 italic bg-gray-50 px-2 py-1 rounded-md border border-gray-100">
                                                    <i class="bi bi-shield-lock mr-1"></i> Protected
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <i class="bi bi-people text-4xl text-gray-300 block mb-3"></i>
                                    <span class="font-medium">No users found.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
