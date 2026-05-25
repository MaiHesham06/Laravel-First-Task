<x-layouts.app>
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Edit User Profile</h1>

        @if ($errors->any())
            <ul class="text-red-500 mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @if(session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('web.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-4">
                <label class="block mb-1">New Password <span class="text-gray-400 text-sm"></span></label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-6">
                <label class="block mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border rounded px-3 py-2" />
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Save Changes
                </button>
                <a href="{{ route('web.users.profile') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded hover:bg-gray-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>
