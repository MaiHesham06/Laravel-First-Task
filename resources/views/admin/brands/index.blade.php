<x-layouts.app>
    <div class="max-w-4xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Brands</h1>
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

        {{-- Add Brand Form --}}
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="font-semibold mb-4">Add Brand</h2>
            <form action="{{ route('admin.brands.store') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="name" placeholder="Brand name"
                    value="{{ old('name') }}"
                    class="flex-1 border rounded px-3 py-2" />
                <input type="text" name="code" placeholder="Code (e.g. NIKE)"
                    value="{{ old('code') }}"
                    class="w-36 border rounded px-3 py-2 uppercase" />
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Add
                </button>
            </form>
        </div>

        {{-- Brands Table --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Code</th>
                        <th class="px-6 py-3 text-left">Products</th>
                        <th class="px-6 py-3 text-left">Added by</th>
                        <th class="px-6 py-3 text-left">Updated by</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($brands as $brand)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $brand->name }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs font-mono">
                                    {{ $brand->code }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $brand->products_count }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $brand->creator?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $brand->updater?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-4">
                                    <a href="{{ route('admin.brands.edit', $brand) }}"
                                        class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST"
                                        onsubmit="return confirm('Delete this brand?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-gray-400">No brands yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($brands->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
