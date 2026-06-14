<?php

namespace App\Http\Controllers\Web\Admin;
use App\Models\Brand;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::withCount('products')
            ->with(['creator', 'updater'])
            ->orderBy('name')
            ->paginate(10);

        return view('admin.brands.index', compact('brands'));
    }

    public function store(StoreBrandRequest $request): RedirectResponse
    {
        Brand::create($request->validated());

        return redirect()->route('admin.brands.index')->with('success', 'Brand created.');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        $brand->update($request->validated());

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated.');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted.');
    }
}
