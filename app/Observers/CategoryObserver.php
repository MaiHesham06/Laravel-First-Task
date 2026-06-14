<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

use App\Models\Category;

class CategoryObserver
{
    public function creating(Category $category): void
    {
        if (Auth::check()) {
            $category->created_by = Auth::user()->id;  
            $category->updated_by = Auth::user()->id;
        }
    }

    public function updating(Category $category): void
    {
        if (Auth::check()) {
            $category->updated_by = Auth::user()->id;
        }
    }
}
