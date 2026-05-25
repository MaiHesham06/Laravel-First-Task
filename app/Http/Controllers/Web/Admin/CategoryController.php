<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function show(Category $category): View
    {
        $category->load('products');

        return view('admin.categories.show', compact('category'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }

    public function storeProduct(StoreProductRequest $request, Category $category): RedirectResponse
    {
        $category->products()->create($request->validated());

        return redirect()->route('admin.categories.show', $category)->with('success', 'Product added.');
    }

    public function destroyProduct(Category $category, Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.categories.show', $category)->with('success', 'Product deleted.');
    }
    public function editProduct(Category $category, Product $product): View
{
    return view('admin.products.edit', compact('category', 'product'));
}

public function updateProduct(UpdateProductRequest $request, Category $category, Product $product): RedirectResponse
{
    $product->update($request->validated());

    return redirect()->route('admin.categories.show', $category)->with('success', 'Product updated.');
}

}
