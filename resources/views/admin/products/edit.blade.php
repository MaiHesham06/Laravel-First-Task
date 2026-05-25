<x-layouts.app>
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow">

        <div class="mb-6">
            <a href="{{ route('admin.categories.show', $category) }}"
                class="text-blue-600 hover:underline text-sm">
                ← Back to {{ $category->name }}
            </a>
            <h1 class="text-2xl font-bold mt-2">Edit Product</h1>
        </div>

        @if ($errors->any())
            <ul class="text-red-500 mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('admin.products.update', [$category, $product]) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                    class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-4">
                <label class="block mb-1">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block mb-1">Price</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                    step="0.01" min="0" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Save Changes
                </button>
                <a href="{{ route('admin.categories.show', $category) }}"
                    class="bg-gray-200 text-gray-800 px-6 py-2 rounded hover:bg-gray-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>