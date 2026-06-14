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
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Add product form --}}
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="font-semibold mb-4">Add Product</h2>
            <form action="{{ route('admin.products.store', $category) }}" method="POST"
                enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="flex gap-3">
                    <input type="text" name="name" placeholder="Product name"
                        class="flex-1 border rounded px-3 py-2" />
                    <input type="text" name="description" placeholder="Description (optional)"
                        class="flex-1 border rounded px-3 py-2" />
                    <input type="number" name="price" placeholder="Price" step="0.01" min="0"
                        class="w-32 border rounded px-3 py-2" />
                    <select name="brand_id" class="w-40 border rounded px-3 py-2 text-sm text-gray-600">
                        <option value="">No brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>    
                </div>
                <div class="flex items-center gap-3">
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="text-sm text-gray-500" />
                    <button class="ml-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add</button>
                </div>
            </form>
        </div>

        {{-- Product list --}}
        <div class="bg-white rounded-xl shadow divide-y">
            @forelse($category->products as $product)
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-start gap-4">

                        {{-- First image thumbnail --}}
                        @if($product->images->count())
                            <img src="{{ Storage::url($product->images->first()->path) }}"
                                class="w-20 h-20 object-contain bg-gray-50 rounded border" />
                        @else
                            <div class="w-14 h-14 rounded-lg border bg-gray-100 flex items-center justify-center shrink-0">
                                <span class="text-gray-300 text-xs">No image</span>
                            </div>
                        @endif

                        <div>
                            <p class="font-medium">{{ $product->name }}</p>
                            @if($product->description)
                                <p class="text-sm text-gray-400">{{ $product->description }}</p>
                            @endif
                            <p class="text-sm text-blue-600 font-semibold mt-1">${{ $product->price }}</p>
                            @if($product->brand)
                                <span class="inline-block bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded mt-1">
                                    {{ $product->brand->code }} — {{ $product->brand->name }}
                                </span>
                            @endif
                            <div class="flex gap-3 mt-1">
                                <p class="text-xs text-gray-400">
                                    Added by <span class="text-gray-600 font-medium">{{ $product->creator?->name ?? 'Unknown' }}</span>
                                </p>
                                <p class="text-xs text-gray-400">
                                    Updated by <span class="text-gray-600 font-medium">{{ $product->updater?->name ?? 'Unknown' }}</span>
                                </p>
                            </div>

                            {{-- Variants --}}
                            @if($product->variants->count())
                                <div class="flex gap-1 mt-2 flex-wrap">
                                    @foreach($product->variants->groupBy('type') as $type => $group)
                                        @foreach($group as $variant)
                                            <span class="inline-flex items-center gap-1 bg-indigo-50 text-indigo-700 text-xs px-2 py-0.5 rounded-full border border-indigo-200">
                                                <span class="font-medium capitalize">{{ $type }}:</span> {{ $variant->value }}
                                                @if($variant->price_adjustment != 0)
                                                    <span class="text-indigo-400">({{ $variant->price_adjustment > 0 ? '+' : '' }}${{ $variant->price_adjustment }})</span>
                                                @endif
                                            </span>
                                        @endforeach
                                    @endforeach
                                </div>
                            @endif

                            {{-- All images --}}
                            @if($product->images->count())
                                <div class="flex gap-2 mt-2 flex-wrap">
                                    @foreach($product->images as $image)
                                        <div class="relative group">
                                            <img src="{{ Storage::url($image->path) }}"
                                                class="w-20 h-20 object-contain bg-gray-50 rounded border" />
                                            <form action="{{ route('admin.products.images.destroy', [$product, $image]) }}"
                                                method="POST"
                                                class="absolute -top-1 -right-1 hidden group-hover:block">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center leading-none">
                                                    ×
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-4 shrink-0">
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
