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
                <a href="{{ route('web.products.show', $product) }}"
                    class="bg-white rounded-xl shadow overflow-hidden hover:shadow-md transition block">

                    {{-- Product main image --}}
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
                        <h2 class="font-semibold">{{ $product->name }}</h2>
                        @if($product->description)
                            <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $product->description }}</p>
                        @endif
                        <p class="text-blue-600 font-bold mt-2">${{ $product->price }}</p>

                        {{-- Rating summary --}}
                        @if($product->ratings->count())
                            @php $avg = $product->averageRating(); @endphp
                            <div class="flex items-center gap-1 mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= round($avg) ? 'text-yellow-400' : 'text-gray-300' }} text-sm">★</span>
                                @endfor
                                <span class="text-xs text-gray-500 ml-1">{{ $avg }} ({{ $product->ratings->count() }})</span>
                            </div>
                        @else
                            <p class="text-xs text-gray-400 mt-2">No ratings yet</p>
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

                        {{-- Extra images --}}
                        @if($product->images->count() > 1)
                            <div class="flex gap-1 mt-3 flex-wrap">
                                @foreach($product->images->skip(1) as $image)
                                    <div class="w-10 h-10 bg-gray-50 border rounded flex items-center justify-center p-0.5">
                                        <img src="{{ Storage::url($image->path) }}"
                                            class="max-h-full max-w-full object-contain" />
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @empty
                <p class="text-gray-400 col-span-3">No products in this category.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
