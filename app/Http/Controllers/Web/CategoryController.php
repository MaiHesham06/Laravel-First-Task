<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category): View
    {
        $category->load(['products.images', 'products.variants', 'products.brand', 'products.ratings']);

        return view('categories.show', compact('category'));
    }
}
