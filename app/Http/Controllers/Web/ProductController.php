<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with(['category', 'brand', 'images', 'variants', 'ratings'])->paginate(10);

        return view('products.index', compact('products'));
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'brand', 'images', 'variants', 'ratings.user']);

        return view('products.show', compact('product'));
    }
}
