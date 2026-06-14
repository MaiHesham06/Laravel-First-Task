<x-layouts.app>
    <div class="max-w-md mx-auto">

        <div class="mb-6">
            <a href="{{ route('admin.brands.index') }}" class="text-blue-600 hover:underline text-sm">
                ← Back to Brands
            </a>
            <h1 class="text-2xl font-bold mt-2">Edit Brand</h1>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow p-6">
            <form method="POST" action="{{ route('admin.brands.update', $brand) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $brand->name) }}"
                        class="w-full border rounded px-3 py-2" />
                </div>

                <div class="mb-6">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Code</label>
                    <input type="text" name="code" value="{{ old('code', $brand->code) }}"
                        class="w-full border rounded px-3 py-2 font-mono uppercase" />
                    <p class="text-xs text-gray-400 mt-1">Must be unique (e.g. APPLE)</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.brands.index') }}"
                        class="bg-gray-200 text-gray-800 px-6 py-2 rounded hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-layouts.app>
