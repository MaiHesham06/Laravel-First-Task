<x-layouts.app>
    <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
            </div>
            <span class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg shadow">
                {{ $categories->total() }} {{ Str::plural('category', $categories->total()) }}
            </span>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow p-6 sticky top-6">
                    <h2 class="font-semibold text-gray-700 mb-4">Add New Category</h2>
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Name</label>
                            <input type="text" name="name" placeholder="e.g. Electronics"
                                class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Description <span class="text-gray-400">(optional)</span></label>
                            <textarea name="description" placeholder="Brief description..."
                                class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300" rows="3"></textarea>
                        </div>
                        <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                            Add Category
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow divide-y">
                    @forelse($categories as $category)
                        <div class="flex items-center justify-between px-6 py-5 hover:bg-gray-50 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-lg shrink-0">
                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.categories.show', $category) }}"
                                        class="font-medium text-gray-800 hover:text-blue-600">
                                        {{ $category->name }}
                                    </a>
                                    @if($category->description)
                                        <p class="text-sm text-gray-400 mt-0.5">{{ $category->description }}</p>
                                    @endif
                                    <span class="inline-block mt-1 text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full">
                                        {{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}
                                    </span>
                                    <div class="flex gap-3 mt-1">
                                        <p class="text-xs text-gray-400">
                                            Added by <span class="text-gray-600 font-medium">{{ $category->creator?->name ?? 'Unknown' }}</span>
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            Updated by <span class="text-gray-600 font-medium">{{ $category->updater?->name ?? 'Unknown' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.categories.show', $category) }}"
                                    class="text-sm text-gray-500 hover:text-blue-600 px-3 py-1.5 rounded-lg border hover:border-blue-300 transition">
                                    View
                                </a>
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="text-sm text-gray-500 hover:text-blue-600 px-3 py-1.5 rounded-lg border hover:border-blue-300 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-sm text-red-500 hover:text-red-700 px-3 py-1.5 rounded-lg border border-transparent hover:border-red-200 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-16 text-center">
                            <p class="text-gray-400 text-sm">No categories yet.</p>
                            <p class="text-gray-300 text-xs mt-1">Add your first category using the form.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">{{ $categories->links() }}</div>
            </div>

        </div>
    </div>
</x-layouts.app>
