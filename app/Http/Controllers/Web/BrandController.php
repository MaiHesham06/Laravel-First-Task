<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\View\View;


class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::withCount('products')->orderBy('name')->paginate(10);

        return view('brands.index', compact('brands'));
    }

    public function show(Brand $brand): View
    {
        $brand->load(['products.images', 'products.variants', 'products.category' , 'products.ratings']);

        return view('brands.show', compact('brand'));
    }
}
