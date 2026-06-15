<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analytics Dashboard') }}
        </h2>
    </x-slot>

    <div class="mt-2 py-10 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
        {{-- Overview Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Total Users Card --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center gap-5">
                <div class="p-4 bg-indigo-50 rounded-xl">
                    <i class="bi bi-people text-2xl text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Users</p>
                    <h3 class="text-3xl font-black text-gray-900">{{ $analytics['activeUsers'] }}</h3>
                </div>
            </div>

            {{-- Total Jobs Card --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center gap-5">
                <div class="p-4 bg-blue-50 rounded-xl">
                    <i class="bi bi-briefcase text-2xl text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Jobs</p>
                    <h3 class="text-3xl font-black text-gray-900">{{ $analytics['totalJobs'] }}</h3>
                </div>
            </div>

            {{-- Total Applications Card --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center gap-5">
                <div class="p-4 bg-green-50 rounded-xl">
                    <i class="bi bi-file-earmark-check text-2xl text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Applications</p>
                    <h3 class="text-3xl font-black text-gray-900">{{ $analytics['totalApplications'] }}</h3>
                </div>
            </div>
        </div>

        {{-- Two-Column Layout for Tables --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- Most Applied Jobs Section --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800">Most Applied Jobs</h3>
                    <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded-md font-bold">Top Trending</span>
                </div>
                <div class="p-0">
                    <ul class="divide-y divide-gray-100">
                        @foreach ($mostAppliedJobs as $job)
                            <li class="p-5 hover:bg-gray-50 transition flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center text-white font-bold">
                                        {{ substr($job->title, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $job->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $job->company->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-lg font-black text-gray-800">{{ $job->job_applications_count }}</span>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-tighter">Applications</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Conversion Rate Table Section --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800">Conversion Rate Analytics</h3>
                    <i class="bi bi-graph-up-arrow text-green-500"></i>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50/50">
                            <tr class="text-left">
                                <th class="px-6 py-4 uppercase font-black text-gray-400">Job Title</th>
                                <th class="px-6 py-4 uppercase font-black text-gray-400 text-center">Efficiency</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($conversionRates as $conversionRate)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-gray-800">{{ $conversionRate->title }}</p>
                                        <div class="flex items-center gap-4">
                                            <p class="text-xs text-gray-400">{{ $conversionRate->view_count }} views</p>
                                            <p class="text-xs text-gray-400">{{ $conversionRate->job_applications_count }} Applications</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col items-center">
                                            <span class="text-sm font-black text-indigo-600">{{ $conversionRate->conversionRate }}%</span>
                                            {{-- Mini progress bar --}}
                                            <div class="w-20 h-1.5 bg-gray-100 rounded-full mt-1 overflow-hidden">
                                                <div class="h-full bg-indigo-500" style="width: {{ $conversionRate->conversionRate }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
