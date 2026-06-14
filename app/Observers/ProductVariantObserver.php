<?php

namespace App\Observers;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class ProductVariantObserver
{
    public function creating(ProductVariant $variant): void
    {
        if (Auth::check()) {
            $variant->created_by = Auth::user()->id;  
            $variant->updated_by = Auth::user()->id;
        }
    }

    public function updating(ProductVariant $variant): void
    {
        if (Auth::check()) {
           $variant->updated_by = Auth::user()->id;
        }
    }
}
