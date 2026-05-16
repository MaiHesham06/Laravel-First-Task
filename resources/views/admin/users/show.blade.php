<x-layouts.app>
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">User Details</h1>

        <div class="mb-4">
            <p class="text-gray-500 text-sm">ID</p>
            <p class="font-medium">{{ $user->id }}</p>
        </div>

        <div class="mb-4">
            <p class="text-gray-500 text-sm">Name</p>
            <p class="font-medium">{{ $user->name }}</p>
        </div>

        <div class="mb-4">
            <p class="text-gray-500 text-sm">Email</p>
            <p class="font-medium">{{ $user->email }}</p>
        </div>

        <div class="mb-4">
            <p class="text-gray-500 text-sm">Role</p>
            <span class="inline-block px-2 py-1 rounded text-sm {{ $user->isAdmin() ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700' }}">
                {{ $user->role }}
            </span>
        </div>

        <div class="mb-4">
            <p class="text-gray-500 text-sm">Status</p>
            @if ($user->trashed())
                <span class="text-red-500 text-sm font-medium">Deleted</span>
            @else
                <span class="text-green-500 text-sm font-medium">Active</span>
            @endif
        </div>

        <div class="mb-6">
            <p class="text-gray-500 text-sm">Member Since</p>
            <p class="font-medium">{{ $user->created_at->format('d-m-Y') }}</p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">← Back to Users</a>
    </div>
</x-layouts.app>
