<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistApiController extends Controller
{
    public function toggle(Request $request): JsonResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $userId = auth()->id();
        $productId = $request->product_id;

        $exists = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            Wishlist::where('user_id', $userId)
                ->where('product_id', $productId)
                ->delete();
            return response()->json(['wishlisted' => false, 'message' => 'Dihapus dari wishlist']);
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        return response()->json(['wishlisted' => true, 'message' => 'Ditambahkan ke wishlist']);
    }
}
