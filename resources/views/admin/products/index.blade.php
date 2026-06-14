<x-layouts.app>
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Products</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($products as $product)
                <a href="{{ route('web.products.show', $product) }}"
                    class="bg-white rounded-xl shadow overflow-hidden hover:shadow-md transition block">

                    {{-- Image --}}
                    @if($product->images->count())
                        <div class="w-full h-48 bg-gray-50 flex items-center justify-center p-2">
                            <img src="{{ Storage::url($product->images->first()->path) }}"
                                class="max-h-full max-w-full object-contain" />
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                            <span class="text-gray-300 text-sm">No image</span>
                        </div>
                    @endif

                    <div class="p-5">
                        <span class="text-xs text-gray-400 uppercase tracking-wide">
                            {{ $product->category->name }}
                        </span>

                        <h2 class="font-semibold text-lg mt-1">{{ $product->name }}</h2>

                        @if($product->description)
                            <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $product->description }}</p>
                        @endif

                        <p class="text-blue-600 font-bold mt-2">${{ $product->price }}</p>

                        {{-- Brand --}}
                        @if($product->brand)
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded mt-1">
                                {{ $product->brand->code }} — {{ $product->brand->name }}
                            </span>
                        @endif
                        
                        {{-- Variants --}}
                        @if($product->variants->count())
                            <div class="mt-2 space-y-1">
                                @foreach($product->variants->groupBy('type') as $type => $group)
                                    <div class="flex items-center gap-1 flex-wrap">
                                        <span class="text-xs text-gray-400 capitalize w-12 shrink-0">{{ $type }}:</span>
                                        @foreach($group as $variant)
                                            <span class="bg-indigo-50 text-indigo-700 text-xs px-2 py-0.5 rounded-full border border-indigo-200">
                                                {{ $variant->value }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @empty
                <p class="text-gray-400 col-span-3">No products available.</p>
            @endforelse
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</x-layouts.app>
