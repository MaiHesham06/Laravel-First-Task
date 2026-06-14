<?php

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\Auth;


class BrandObserver
{
    public function creating(Brand $brand): void
    {
        if (Auth::check()) {
            $brand->created_by = Auth::user()->id;  
            $brand->updated_by = Auth::user()->id;  
        }
    }

    public function updating(Brand $brand): void
    {
        if (Auth::check()) {
            $brand->updated_by = Auth::user()->id;  
        }
    }
    
}
