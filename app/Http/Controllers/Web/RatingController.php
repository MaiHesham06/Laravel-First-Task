<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreRatingRequest;
use App\Models\ProductRating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class RatingController extends Controller
{
    public function store(StoreRatingRequest $request, Product $product): RedirectResponse
    {
        abort_if(auth()->user()->isAdmin(), 403, 'Admins cannot rate products.');
        ProductRating::updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id'    => Auth::user()->id,
            ],
            [
                'rating' => $request->validated('rating'),
                'review' => $request->validated('review'),
            ]
        );

        return back()->with('success', 'Your rating has been saved.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        ProductRating::where('product_id', $product->id)
            ->where('user_id', Auth::user()->id)
            ->delete();

        return back()->with('success', 'Your rating has been removed.');
    }
}
