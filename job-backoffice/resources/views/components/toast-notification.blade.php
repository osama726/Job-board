<div class="overflow-x-auto p-6">
    <div class="absolute top-9 inset-x-0 z-50 max-w-2xl mx-auto">
        @if(session('success'))
            <div class="flex justify-center gap-3 text-green-700 bg-green-100 border border-green-400 px-4 py-3 rounded-2xl shadow-lg relative"
                x-data="{ show: true }"
                x-show="show"
                x-transition x-init="setTimeout(() => show = false, 4000)"
                role="alert"
            >
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="flex justify-center gap-3 text-red-700 bg-red-100 border border-red-400 px-4 py-3 rounded-2xl shadow-lg relative"
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 3000)"
                role="alert"
            >
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>
