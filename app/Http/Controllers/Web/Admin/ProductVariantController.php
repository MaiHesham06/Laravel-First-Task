<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVariantRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;

class ProductVariantController extends Controller
{
    public function store(StoreVariantRequest $request , Product $product): RedirectResponse
    {
        $product->variants()->create($request->validated());

        return back()->with('success', 'Variant added.');
    }

    public function destroy(Product $product, ProductVariant $variant): RedirectResponse
    {
        $variant->delete();

        return back()->with('success', 'Variant removed.');
    }
}
