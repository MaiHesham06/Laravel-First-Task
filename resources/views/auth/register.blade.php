<x-layouts.app>
    <div class="max-w-xl mx-auto mt-16 bg-white p-14 rounded shadow">
        <h1 class="text-3xl font-bold mb-6">Register</h1>

        @if ($errors->any())
            <ul class="text-red-500 mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-xl mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded px-3 py-2" required />
            </div>

            <div class="mb-4">
                <label class="block text-xl mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded px-3 py-2" required />
            </div>

            <div class="mb-4">
                <label class="block text-xl mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2" required />
            </div>

            <div class="mb-6">
                <label class="block text-xl mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border rounded px-3 py-2" required />
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-xl text-white py-2 rounded hover:bg-blue-700">
                Register
            </button>
        </form>

        <p class="mt-6 text-center">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
        </p>
    </div>
</x-layouts.app>
