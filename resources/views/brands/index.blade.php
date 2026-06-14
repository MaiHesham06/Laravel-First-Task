<x-layouts.app>
    <div class="max-w-5xl mx-auto">

        <div class="mb-6">
            <h1 class="text-2xl font-bold">Brands</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($brands as $brand)
                <a href="{{ route('web.brands.show', $brand) }}"
                    class="bg-white rounded-xl shadow p-6 hover:shadow-md transition flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <h2 class="font-semibold text-lg">{{ $brand->name }}</h2>
                        <span class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded">
                            {{ $brand->code }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-400">{{ $brand->products_count }} product{{ $brand->products_count !== 1 ? 's' : '' }}</p>
                </a>
            @empty
                <p class="text-gray-400 col-span-3">No brands available.</p>
            @endforelse
        </div>

        @if($brands->hasPages())
            <div class="mt-6">
                {{ $brands->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
