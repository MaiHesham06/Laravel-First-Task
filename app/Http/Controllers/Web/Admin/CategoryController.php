<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')
            ->with(['creator', 'updater'])
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function show(Category $category): View
    {
        $category->load('products.creator','products.updater' , 'products.images' , 'products.brand', 'products.variants');
        $brands = Brand::orderBy('name')->get();

        return view('admin.categories.show', compact('category', 'brands'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }

    public function storeProduct(StoreProductRequest $request, Category $category): RedirectResponse
    {
        $product = $category->products()->create($request->validated());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path, 'order' => $index]);
            }
        }
        
        return redirect()->route('admin.categories.show', $category)->with('success', 'Product added.');
    }

    public function destroyProduct(Category $category, Product $product): RedirectResponse
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $product->delete();

        return redirect()->route('admin.categories.show', $category)->with('success', 'Product deleted.');
    }

    public function editProduct(Category $category, Product $product): View
    {
        $product->load('images', 'variants');
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.edit', compact('category', 'product' , 'brands'));
    }

    public function updateProduct(UpdateProductRequest $request, Category $category, Product $product): RedirectResponse
    {
        //$product->update($request->validated());
        $product->update($request->safe()->except(['images']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path, 'order' => $product->images()->count() + $index]);
            }
        }

        return redirect()->route('admin.categories.show', $category)->with('success', 'Product updated.');
    }

    public function destroyImage(Product $product, ProductImage $image): RedirectResponse
    {
        Storage::disk('public')->delete($image->path);

        $image->delete();

        return back()->with('success', 'Image deleted.');
    }
    
}


