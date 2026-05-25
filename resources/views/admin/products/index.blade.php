<x-layouts.app>
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Products</h1>

        <div class="bg-white rounded-xl shadow divide-y">
            @forelse($products as $product)
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <p class="font-medium">{{ $product->name }}</p>
                        <p class="text-sm text-gray-400">
                            {{ $product->category->name }}
                            @if($product->description)
                                · {{ $product->description }}
                            @endif
                        </p>
                        <div class="flex gap-4 mt-1">
                            <p class="text-xs text-gray-400">
                                Added by
                                <span class="text-gray-600 font-medium">
                                    {{ $product->creator?->name ?? 'Unknown' }}
                                </span>
                            </p>
                            <p class="text-xs text-gray-400">
                                Last updated by
                                <span class="text-gray-600 font-medium">
                                    {{ $product->updater?->name ?? 'Unknown' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <span class="text-blue-600 font-semibold">${{ $product->price }}</span>
                        <a href="{{ route('admin.categories.show', $product->category) }}"
                            class="text-sm text-gray-500 hover:underline">
                            View in category
                        </a>
                    </div>
                </div>
            @empty
                <p class="px-6 py-4 text-gray-400">No products yet.</p>
            @endforelse
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</x-layouts.app>
