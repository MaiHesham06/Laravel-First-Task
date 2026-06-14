<x-layouts.app>
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow">

        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}"
                class="text-blue-600 hover:underline text-sm">
                ← Back to Categories
            </a>
            <h1 class="text-2xl font-bold mt-2">Edit Category</h1>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300" />
            </div>

            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-1">Description <span class="text-gray-400">(optional)</span></label>
                <textarea name="description" rows="3"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                    Save Changes
                </button>
                <a href="{{ route('admin.categories.index') }}"
                    class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>
