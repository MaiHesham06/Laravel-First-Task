<x-layouts.app>
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Manage Users</h1>
        </div>

        @if (session('success'))
            <p class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</p>
        @endif

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="text-left px-4 py-2">ID</th>
                        <th class="text-left px-4 py-2">Name</th>
                        <th class="text-left px-4 py-2">Email</th>
                        <th class="text-left px-4 py-2">Role</th>
                        <th class="text-left px-4 py-2">Status</th>
                        <th class="text-left px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-t {{ $user->trashed() ? 'bg-red-50' : '' }}">
                            <td class="px-4 py-2">{{ $user->id }}</td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-sm {{ $user->isAdmin() ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @if ($user->trashed())
                                    <span class="text-red-500 text-sm">Deleted</span>
                                @else
                                    <span class="text-green-500 text-sm">Active</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex items-center gap-3">
                                    @if ($user->trashed())
                                        <form method="POST" action="{{ route('admin.users.restore', $user->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:underline text-sm">Restore</button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.users.show', $user) }}" class="text-gray-600 hover:underline text-sm">View</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Delete this user?')"
                                                class="text-red-600 hover:underline text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-layouts.app>
