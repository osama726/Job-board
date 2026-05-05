<nav class="w-[250px] h-screen bg-white border-r border-gray-200">
    {{-- Logo --}}
    <div class="flex items-center px-6 py-3">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 no-underline">
            <x-application-logo class="h-6 w-auto fill-current" />
            <span class="text-lg font-semibold text-gray-800" >Khoutwa</span>
        </a>
    </div>

    {{-- Navigation Links --}}
    <ul class="flex flex-col space-y-2 px-4 py-6">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>

        <x-nav-link :href="route('Companies.index')" :active="request()->routeIs('Companies.index')">
            {{ __('Companies') }}
        </x-nav-link>

        <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.index')">
            {{ __('Job Applications') }}
        </x-nav-link>
        <x-nav-link :href="route('job-categories.index')" :active="request()->routeIs('job-categories.index')">
            {{ __('Vob Categories') }}
        </x-nav-link>
        <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.index')">
            {{ __('Job Vacancies') }}
        </x-nav-link>
        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
            {{ __('Users') }}
        </x-nav-link>

        <hr>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <x-nav-link :href="route('logout')" :active="false" class="text-red-500" onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Logout') }}
            </x-nav-link>
        </form>

    </ul>
</nav>
