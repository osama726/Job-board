@php
    if (auth()->user()->role == 'admin')
        $formAction = route('companies.update', $company->id);
    else if (auth()->user()->role == 'company-owner')
        $formAction = route('my-company.update');
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') }}
        </h2>
    </x-slot>

        {{-- Success and error messages --}}
    <x-toast-notification/>
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-8">
        <div>
            <p class="text-2xl font-bold text-gray-800">
                Here you can edit in your company ({{ $company->name }})
            </p>
        </div>

        <form action="{{ $formAction }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Hidden input for listTo query parameter --}}
            <input type="hidden" name="toList" value="{{ request()->query('toList') }}">

            {{-- Company Details --}}
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold">Company Details</h3>
                <p class="text-sm">Enter company details</p>

                <div class="mt-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Name
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $company->name) }}"
                        placeholder="Enter company name"
                        class="{{ $errors->has('name') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                    >

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Address
                    </label>

                    <input
                        id="address"
                        type="text"
                        name="address"
                        value="{{ old('address', $company->address) }}"
                        placeholder="Enter company address"
                        class="{{ $errors->has('address') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                    >

                    @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="industry" class="block text-sm font-medium text-gray-700 mb-2">
                        Industry
                    </label>

                    <select
                        id="industry"
                        name="industry"
                        class="{{ $errors->has('industry') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                    >
                        @foreach ($industries as $industry)
                            <option value="{{ $industry }}" {{ old('industry', $company->industry) == $industry ? 'selected' : '' }}>
                                {{ $industry }}
                            </option>
                        @endforeach
                    </select>

                    @error('industry')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                        Website (Optional)
                    </label>

                    <input
                        id="website"
                        type="url"
                        name="website"
                        value="{{ old('website', $company->website) }}"
                        placeholder="Enter the company website"
                        class="{{ $errors->has('website') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                    >

                    @error('website')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Company Owner --}}
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold">Company Owner</h3>
                <p class="text-sm mb-4">Enter company owner details</p>

                <div class="mt-4">
                    <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Owner Name
                    </label>

                    <input
                        id="owner_name"
                        type="text"
                        name="owner_name"
                        value="{{ old('owner_name', $company->owner->name) }}"
                        placeholder="Enter the owner name"
                        class="{{ $errors->has('owner_name') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                    >

                    @error('owner_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="owner_email" class="block text-sm font-medium text-gray-700 mb-2">
                        Owner Email
                    </label>

                    <input
                        id="owner_email"
                        type="text"
                        disabled
                        name="owner_email"
                        value="{{ old('owner_email', $company->owner->email) }}"
                        placeholder="Enter the owner email"
                        class="{{ $errors->has('owner_email') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition bg-gray-100"
                    >

                    @error('owner_email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="owner_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Change Password (Leave blank to keep current password)
                    </label>

                    <div class="relative" x-data="{ showPassword: false }">
                        <input id="owner_password"
                            class="{{ $errors->has('owner_password') ? 'outline-red-500 outline outline-1' : '' }} w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
                            x-bind:type="showPassword ? 'text' : 'password'"
                            name="owner_password"
                            autocomplete="current-password"
                            placeholder="Enter a password"
                        />

                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-3 text-gray-500">
                            <i x-show="!showPassword" class="bi bi-eye-slash-fill text-xl" ></i>

                            <i x-show="showPassword" class="bi bi-eye-fill text-xl" ></i>
                        </button>
                    </div>
                    @error('owner_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>


            {{-- Action buttons --}}
            <div class="flex justify-end items-center gap-3">
                @if (auth()->user()->role == 'admin')
                    <a
                        href="{{ route('companies.index') }}"
                        class="text-sm text-gray-600 hover:text-gray-900 py-2 px-4"
                    >
                        Cancel
                    </a>
                @else
                    <a
                        href="{{ route('my-company.show') }}"
                        class="text-sm text-gray-600 hover:text-gray-900 py-2 px-4"
                    >
                        Cancel
                    </a>
                @endif
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
