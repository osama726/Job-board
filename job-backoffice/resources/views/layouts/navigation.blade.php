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

        <x-nav-link :href="route('company.index')" :active="request()->routeIs('company.index')">
            {{ __('Companies') }}
        </x-nav-link>

        <x-nav-link :href="route('job-application.index')" :active="request()->routeIs('job-application.index')">
            {{ __('Job Applications') }}
        </x-nav-link>
        <x-nav-link :href="route('job-category.index')" :active="request()->routeIs('job-category.index')">
            {{ __('Vob Categories') }}
        </x-nav-link>
        <x-nav-link :href="route('job-vacancy.index')" :active="request()->routeIs('job-vacancy.index')">
            {{ __('Job Vacancies') }}
        </x-nav-link>
        <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
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
