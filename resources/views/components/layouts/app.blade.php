<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    @auth
    <nav class="bg-white shadow px-10 py-5 flex justify-between items-center">
        <div class="flex items-center gap-6">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="font-bold text-2xl">MyApp</a>
            @else
                <a href="{{ route('web.users.profile') }}" class="font-bold text-2xl">MyApp</a>
            @endif
        </div>
        <div class="flex items-center gap-5">
            <span class="text-base text-gray-500">{{ auth()->user()->name }}</span>
            <span class="text-sm px-3 py-1 rounded {{ auth()->user()->isAdmin() ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600' }}">
                {{ ucfirst(auth()->user()->role) }}
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-base text-red-500 hover:underline">Logout</button>
            </form>
        </div>
    </nav>
    @endauth

    <main class="p-8">
        {{ $slot }}
    </main>

</body>
</html>
