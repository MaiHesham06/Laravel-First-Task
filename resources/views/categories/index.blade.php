<x-layouts.app>
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Categories</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($categories as $category)
                <a href="{{ route('web.categories.show', $category) }}"
                    class="bg-white rounded-xl shadow p-6 hover:shadow-md transition">
                    <h2 class="font-semibold text-lg">{{ $category->name }}</h2>
                    <p class="text-gray-400 text-sm mt-1">{{ $category->products_count }} products</p>
                    @if($category->description)
                        <p class="text-gray-500 text-sm mt-2">{{ $category->description }}</p>
                    @endif
                </a>
            @empty
                <p class="text-gray-400">No categories available.</p>
            @endforelse
        </div>

        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
</x-layouts.app>
