<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit user profile') }}
        </h2>
    </x-slot>

    {{-- Success and error messages --}}
    <x-toast-notification/>
    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8">
        <div>
            <p class="text-2xl font-bold text-gray-800">
                Here you can edit your user profile ({{ $user->name }})
            </p>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            {{-- user Details --}}
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold">User Details</h3>

                <div class="mt-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="{{ $errors->has('name') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition">

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>

                    <input
                        type="text"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="{{ $errors->has('email') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition">

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Change Password (Leave blank to keep current password)
                    </label>

                    <div class="relative" x-data="{ showPassword: false }">
                        <input id="password"
                            class="{{ $errors->has('password') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                            x-bind:type="showPassword ? 'text' : 'password'"
                            name="password"
                            autocomplete="current-password"
                            placeholder="Enter a password"
                        />

                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-3 text-gray-500">
                            <i x-show="!showPassword" class="bi bi-eye-slash-fill text-xl" ></i>

                            <i x-show="showPassword" class="bi bi-eye-fill text-xl" ></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Role
                    </label>

                    <input
                        type="text"
                        id="role"
                        name="role"
                        disabled
                        value="{{ $user->role }}"
                        class="bg-gray-50 w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>

            </div>

            {{-- Action buttons --}}
            <div class="flex justify-end items-center gap-3">
                <a
                    href="{{ route('users.index') }}"
                    class="text-sm text-gray-600 hover:text-gray-900 py-2 px-4"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition"
                >
                    <i class="bi bi-check-circle"></i>
                    Save Changes
                </button>
            </div>

        </form>

    </div>

</x-app-layout>
