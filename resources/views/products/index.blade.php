<x-layouts.app>
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Products</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($products as $product)
                <div class="bg-white rounded-xl shadow p-6">
                    <span class="text-xs text-gray-400 uppercase tracking-wide">
                        {{ $product->category->name }}
                    </span>
                    <h2 class="font-semibold text-lg mt-1">{{ $product->name }}</h2>
                    @if($product->description)
                        <p class="text-gray-500 text-sm mt-1">{{ $product->description }}</p>
                    @endif
                    <p class="text-blue-600 font-bold mt-3">${{ $product->price }}</p>
                </div>
            @empty
                <p class="text-gray-400 col-span-3">No products available.</p>
            @endforelse
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</x-layouts.app>
