<x-layouts.app>
    <div class="max-w-4xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('web.products.index') }}" class="text-blue-600 hover:underline text-sm">
                ← Back to Products
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Product detail card --}}
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-6">

                {{-- Images --}}
                <div class="md:w-1/2">
                    @if($product->images->count())
                        <div class="w-full h-64 bg-gray-50 flex items-center justify-center rounded-lg border p-3">
                            <img src="{{ Storage::url($product->images->first()->path) }}"
                                class="max-h-full max-w-full object-contain" />
                        </div>
                        @if($product->images->count() > 1)
                            <div class="flex gap-2 mt-3 flex-wrap">
                                @foreach($product->images->skip(1) as $image)
                                    <div class="w-14 h-14 bg-gray-50 border rounded flex items-center justify-center p-1">
                                        <img src="{{ Storage::url($image->path) }}"
                                            class="max-h-full max-w-full object-contain" />
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="w-full h-64 bg-gray-100 flex items-center justify-center rounded-lg">
                            <span class="text-gray-300">No image</span>
                        </div>
                    @endif
                </div>

                {{-- Details --}}
                <div class="md:w-1/2">
                    {{-- Category & Brand --}}
                    <div class="flex items-center gap-2 flex-wrap mb-2">
                        <span class="text-xs text-gray-400 uppercase tracking-wide">
                            {{ $product->category->name }}
                        </span>
                        @if($product->brand)
                            <span class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded">
                                {{ $product->brand->code }} — {{ $product->brand->name }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl font-bold">{{ $product->name }}</h1>

                    @if($product->description)
                        <p class="text-gray-500 mt-2">{{ $product->description }}</p>
                    @endif

                    <p class="text-blue-600 text-2xl font-bold mt-3">${{ $product->price }}</p>

                    {{-- Average rating --}}
                    @if($product->ratings->count())
                        @php $avg = $product->averageRating(); @endphp
                        <div class="flex items-center gap-1 mt-3">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= round($avg) ? 'text-yellow-400' : 'text-gray-300' }} text-xl">★</span>
                            @endfor
                            <span class="text-gray-600 ml-1 font-semibold">{{ $avg }}</span>
                            <span class="text-gray-400 text-sm">/ 5 &nbsp;·&nbsp; {{ $product->ratings->count() }} {{ Str::plural('rating', $product->ratings->count()) }}</span>
                        </div>
                    @else
                        <p class="text-gray-400 text-sm mt-3">No ratings yet</p>
                    @endif

                    {{-- Variants --}}
                    @if($product->variants->count())
                        <div class="mt-4 space-y-2">
                            @foreach($product->variants->groupBy('type') as $type => $group)
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm text-gray-500 capitalize w-16 shrink-0 font-medium">{{ $type }}:</span>
                                    @foreach($group as $variant)
                                        <span class="bg-indigo-50 text-indigo-700 text-sm px-3 py-1 rounded-full border border-indigo-200">
                                            {{ $variant->value }}
                                            @if($variant->price_adjustment != 0)
                                                <span class="text-indigo-400 text-xs">({{ $variant->price_adjustment > 0 ? '+' : '' }}${{ $variant->price_adjustment }})</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Rate the product --}}
        @if(!auth()->user()->isAdmin())
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                @php $userRating = $product->userRating(); @endphp

                <h2 class="font-semibold text-lg mb-4">
                    {{ $userRating ? 'Your Rating' : 'Rate this Product' }}
                </h2>

                {{-- Submit / update form --}}
                <form action="{{ route('web.products.rate', $product) }}" method="POST">
                    @csrf

                    {{-- Star selector --}}
                    <div class="flex gap-1 mb-3" id="star-selector">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}"
                                    id="star-input-{{ $i }}"
                                    class="hidden"
                                    {{ old('rating', $userRating?->rating) == $i ? 'checked' : '' }}
                                    required />
                                <span class="star text-3xl transition select-none"
                                    data-value="{{ $i }}">★</span>
                            </label>
                        @endfor
                    </div>

                    <textarea name="review" rows="3" placeholder="Write a review (optional)..."
                        class="w-full border rounded px-3 py-2 text-sm mb-3">{{ old('review', $userRating?->review) }}</textarea>

                    <button type="submit"
                        class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-5 py-2 rounded">
                        {{ $userRating ? 'Update Rating' : 'Submit Rating' }}
                    </button>
                </form>

                {{-- Remove form --}}
                @if($userRating)
                    <form action="{{ route('web.products.rate.destroy', $product) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm text-red-400 hover:underline">Remove my rating</button>
                    </form>
                @endif
            </div>
        @endif

        <script>
            (function () {
                const stars   = document.querySelectorAll('#star-selector .star');
                const inputs  = document.querySelectorAll('#star-selector input[type="radio"]');
                const selector = document.getElementById('star-selector');

                function paint(value) {
                    stars.forEach(s => {
                        const v = parseInt(s.dataset.value);
                        s.classList.toggle('text-yellow-400', v <= value);
                        s.classList.toggle('text-gray-300',   v >  value);
                    });
                }

                // Initialise from checked input (existing rating or old())
                const checked = document.querySelector('#star-selector input:checked');
                paint(checked ? parseInt(checked.value) : 0);

                // Hover preview
                stars.forEach(s => {
                    s.addEventListener('mouseenter', () => paint(parseInt(s.dataset.value)));
                });

                // On mouse leave restore to selected value
                selector.addEventListener('mouseleave', () => {
                    const c = document.querySelector('#star-selector input:checked');
                    paint(c ? parseInt(c.value) : 0);
                });

                // On click — check the hidden input and keep paint
                stars.forEach(s => {
                    s.addEventListener('click', () => {
                        const v = parseInt(s.dataset.value);
                        inputs.forEach(inp => { inp.checked = parseInt(inp.value) === v; });
                        paint(v);
                    });
                });
            })();
        </script>

        {{-- All reviews --}}
        @if($product->ratings->count())
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="font-semibold text-lg mb-4">
                    Reviews ({{ $product->ratings->count() }})
                </h2>
                <div class="divide-y">
                    @foreach($product->ratings as $rating)
                        <div class="py-4">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-sm">{{ $rating->user->name }}</span>
                                    <div class="flex gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm">★</span>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400">{{ $rating->created_at->diffForHumans() }}</span>
                            </div>
                            @if($rating->review)
                                <p class="text-gray-600 text-sm">{{ $rating->review }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-layouts.app>
