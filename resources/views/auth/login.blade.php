<x-layouts.app>
    <div class="max-w-xl mx-auto mt-16 bg-white p-14 rounded shadow">
        <h1 class="text-3xl font-bold mb-6">Login</h1>

        @if ($errors->any())
            <p class="text-red-500 mb-4">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-6 text-xl">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded px-3 py-2" required />
            </div>

            <div class="mb-6 text-xl">
                <label class="block mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2" required />
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-xl text-white py-2 rounded hover:bg-blue-700">
                Login
            </button>
        </form>

        <p class="mt-6 text-center">
            No account?  
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
        </p>
    </div>
</x-layouts.app>
