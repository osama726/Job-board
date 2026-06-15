<nav :class="sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 w-[250px] bg-white border-r border-gray-200 flex flex-col justify-between z-50 transform lg:transform-none lg:static transition-transform duration-300 ease-in-out">

    <div>
        {{-- Logo & Close Button --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-50 h-16">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 no-underline">
                <x-application-logo class="h-6 w-auto fill-current text-indigo-600" />
                <span class="text-xl font-black text-gray-800 tracking-tight">Khoutwa</span>
            </a>

            {{-- Close Button for Mobile --}}
            <button @click="sidebarOpen = false" class="text-gray-400 hover:text-gray-600 lg:hidden focus:outline-none p-1 rounded-lg hover:bg-gray-50">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>

        {{-- Navigation Links --}}
        <ul class="flex flex-col space-y-1 px-3 py-6 list-none">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="bi bi-grid-1x2-fill mr-3 text-lg"></i> {{ __('Dashboard') }}
            </x-nav-link>

            @if (auth()->user()->role == 'admin')
                <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.index')">
                    <i class="bi bi-building mr-3 text-lg"></i> {{ __('Companies') }}
                </x-nav-link>
            @endif

            @if (auth()->user()->role == 'company-owner')
                <x-nav-link :href="route('my-company.show')" :active="request()->routeIs('my-company.show')">
                    <i class="bi bi-briefcase-fill mr-3 text-lg"></i> {{ __('My Company') }}
                </x-nav-link>
            @endif

            <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.index')">
                <i class="bi bi-file-earmark-person-fill mr-3 text-lg"></i> {{ __('Job Applications') }}
            </x-nav-link>

            <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.index')">
                <i class="bi bi-collection-fill mr-3 text-lg"></i> {{ __('Job Vacancies') }}
            </x-nav-link>

            @if (auth()->user()->role == 'admin')
                <x-nav-link :href="route('job-categories.index')" :active="request()->routeIs('job-categories.index')">
                    <i class="bi bi-tags-fill mr-3 text-lg"></i> {{ __('Job Categories') }}
                </x-nav-link>

                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    <i class="bi bi-people-fill mr-3 text-lg"></i> {{ __('Users') }}
                </x-nav-link>
            @endif
        </ul>
        {{-- Bottom Section: Profile & Logout --}}
        <div class="px-3 py-4 border-t border-gray-100">
            <ul class="flex flex-col space-y-1 list-none">
                <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="text-gray-700 hover:bg-gray-50">
                    <i class="bi bi-person-circle mr-3 text-lg"></i> {{ __('My Profile') }}
                </x-nav-link>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="flex items-center px-4 py-2 w-full text-sm font-medium text-red-600 hover:bg-red-50 rounded-md transition duration-150 ease-in-out text-left border-none bg-transparent cursor-pointer">
                        <i class="bi bi-box-arrow-left mr-3 text-lg"></i> {{ __('Logout') }}
                    </button>
                </form>
            </ul>
        </div>
    </div>

</nav>

<button @click="sidebarOpen = !sidebarOpen"
        class="absolute left-5 top-[63px] py-1 px-4 z-40 lg:hidden bg-indigo-600 text-white rounded-xl shadow-md hover:bg-indigo-700 focus:outline-none transition-all">
    <i class="bi bi-list text-xl"></i>
</button>
