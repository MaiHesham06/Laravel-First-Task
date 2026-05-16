<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-5xl font-bold mb-6">{{ config('app.name') }}</h1>
            <p class="text-gray-500 mb-10">Welcome! Please login or create an account.</p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="bg-gray-200 text-gray-800 px-6 py-3 rounded hover:bg-gray-300">
                    Register
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
