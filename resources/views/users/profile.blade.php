<x-layouts.app>
    <div class="max-w-5xl mx-auto">

        <div class="bg-white rounded-xl shadow p-8 mb-6 flex items-center gap-6">
            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-3xl font-bold text-blue-600 shrink-0">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                <p class="text-gray-500 mt-1">{{ $user->email }}</p>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-medium {{ $user->isAdmin() ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow divide-y">
            <div class="flex items-center justify-between px-8 py-5">
                <span class="text-gray-500 text-sm font-medium w-40">Full Name</span>
                <span class="text-gray-800 font-medium flex-1">{{ $user->name }}</span>
            </div>
            <div class="flex items-center justify-between px-8 py-5">
                <span class="text-gray-500 text-sm font-medium w-40">Email Address</span>
                <span class="text-gray-800 font-medium flex-1">{{ $user->email }}</span>
            </div>
            <div class="flex items-center justify-between px-8 py-5">
                <span class="text-gray-500 text-sm font-medium w-40">Role</span>
                <span class="flex-1">
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $user->isAdmin() ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </span>
            </div>
            <div class="flex items-center justify-between px-8 py-5">
                <span class="text-gray-500 text-sm font-medium w-40">Member Since</span>
                <span class="text-gray-800 font-medium flex-1">{{ $user->created_at->format('F j, Y') }}</span>
            </div>
        </div>

    </div>
</x-layouts.app>
