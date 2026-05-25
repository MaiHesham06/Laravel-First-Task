<x-layouts.app>
    <div class="max-w-5xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('web.categories.index') }}" class="text-blue-600 hover:underline text-sm">
                ← Back to Categories
            </a>
            <h1 class="text-2xl font-bold mt-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-gray-500 mt-1">{{ $category->description }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($category->products as $product)
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="font-semibold">{{ $product->name }}</h2>
                    @if($product->description)
                        <p class="text-gray-500 text-sm mt-1">{{ $product->description }}</p>
                    @endif
                    <p class="text-blue-600 font-bold mt-3">${{ $product->price }}</p>
                </div>
            @empty
                <p class="text-gray-400 col-span-3">No products in this category.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
