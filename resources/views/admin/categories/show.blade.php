<x-layouts.app>
    <div class="max-w-5xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline text-sm">
                ← Back to Categories
            </a>
            <h1 class="text-2xl font-bold mt-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-gray-500 mt-1">{{ $category->description }}</p>
            @endif
        </div>

        @if(session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <ul class="text-red-500 mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        {{-- Add product form --}}
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="font-semibold mb-4">Add Product</h2>
            <form action="{{ route('admin.products.store', $category) }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="name" placeholder="Product name"
                    class="flex-1 border rounded px-3 py-2" />
                <input type="text" name="description" placeholder="Description (optional)"
                    class="flex-1 border rounded px-3 py-2" />
                <input type="number" name="price" placeholder="Price" step="0.01" min="0"
                    class="w-32 border rounded px-3 py-2" />
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add</button>
            </form>
        </div>

        {{-- Product list --}}
        <div class="bg-white rounded-xl shadow divide-y">
            @forelse($category->products as $product)
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <p class="font-medium">{{ $product->name }}</p>
                        @if($product->description)
                            <p class="text-sm text-gray-400">{{ $product->description }}</p>
                        @endif
                        <p class="text-sm text-blue-600 font-semibold mt-1">${{ $product->price }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.products.edit', [$category, $product]) }}"
                            class="text-blue-500 text-sm hover:underline">Edit</a>

                        <form action="{{ route('admin.products.destroy', [$category, $product]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 text-sm hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="px-6 py-4 text-gray-400">No products yet.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
