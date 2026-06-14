<x-layouts.app>
    <div class="max-w-xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('admin.categories.show', $category) }}"
                class="text-blue-600 hover:underline text-sm"> 
                ← Back to {{ $category->name }}
            </a>
            <h1 class="text-2xl font-bold mt-2">Edit Product</h1>
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

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Edit product form --}}
        <div class="bg-white rounded shadow p-6 mb-4">
            <form method="POST" action="{{ route('admin.products.update', [$category, $product]) }}"
                enctype="multipart/form-data">
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

                <div class="mb-4">
                    <label class="block mb-1">Price</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
                        step="0.01" min="0" class="w-full border rounded px-3 py-2" />
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Brand</label>
                    <select name="brand_id" class="w-full border rounded px-3 py-2">
                        <option value="">— No brand —</option>
                        @foreach($brands as $brand) 
                            <option value="{{ $brand->id }}"
                                {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }} ({{ $brand->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block mb-1 text-sm text-gray-600">Add More Images</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="w-full text-sm text-gray-500" />
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — max 2MB each</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="ml-auto bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.categories.show', $category) }}"
                        class="bg-gray-200 text-gray-800 px-6 py-2 rounded hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        {{-- Variants --}}
        <div class="bg-white rounded shadow p-6 mb-4">
            <label class="block mb-3 font-medium text-gray-700">Variants</label>

            @if($product->variants->count())
                <div class="mb-4 space-y-2">
                    @foreach($product->variants->groupBy('type') as $type => $group)
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-semibold mb-1">{{ $type }}</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($group as $variant)
                                    <div class="flex items-center gap-1 bg-indigo-50 border border-indigo-200 rounded-full px-3 py-1">
                                        <span class="text-sm text-indigo-700">{{ $variant->value }}</span>
                                        @if($variant->price_adjustment != 0)
                                            <span class="text-xs text-indigo-400">
                                                ({{ $variant->price_adjustment > 0 ? '+' : '' }}${{ $variant->price_adjustment }})
                                            </span>
                                        @endif
                                        <form action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="ml-1 text-red-400 hover:text-red-600 text-xs leading-none"
                                                title="Remove">×</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 mb-4">No variants yet.</p>
            @endif

            {{-- Add new variant form --}}
            <form action="{{ route('admin.products.variants.store', $product) }}" method="POST">
                @csrf
                <p class="text-sm font-medium text-gray-600 mb-2">Add Variant</p>
                <div class="flex gap-2 flex-wrap">
                    <select name="type" class="border rounded px-3 py-2 text-sm">
                        <option value="color">Color</option>
                        <option value="size">Size</option>
                        <option value="material">Material</option>
                    </select>
                    <input type="text" name="value" placeholder="e.g. Red, XL, Cotton"
                        class="flex-1 border rounded px-3 py-2 text-sm" />
                    <input type="number" name="price_adjustment" placeholder="Price adj. (0)"
                        step="0.01" value="0"
                        class="w-32 border rounded px-3 py-2 text-sm" />
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                        Add
                    </button>
                </div>
            </form>
        </div>

        {{-- Gallery --}}
        @if($product->images->count())
            <div class="bg-white rounded shadow p-6 mb-4">
                <label class="block mb-3 font-medium text-gray-700">Gallery</label>
                <div class="flex gap-3 flex-wrap">
                    @foreach($product->images as $image)
                        <div class="flex flex-col items-center gap-1">
                            <img src="{{ Storage::url($image->path) }}"
                                class="w-20 h-20 object-contain bg-gray-50 rounded border" />
                            <form action="{{ route('admin.products.images.destroy', [$product, $image]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
