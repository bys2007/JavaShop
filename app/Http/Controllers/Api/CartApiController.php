<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'integer|min:1|max:99',
        ]);

        $userId = auth()->id();
        $variantId = $request->product_variant_id;
        $qty = $request->input('quantity', 1);

        $item = CartItem::where('user_id', $userId)
            ->where('variant_id', $variantId)
            ->first();

        if ($item) {
            $item->increment('quantity', $qty);
        } else {
            CartItem::create([
                'user_id' => $userId,
                'variant_id' => $variantId,
                'quantity' => $qty,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ditambahkan ke keranjang!',
            'cart_count' => auth()->user()->cart_count,
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $item = CartItem::where('id', $request->item_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $item->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'subtotal' => $item->formatted_subtotal,
            'cart_count' => auth()->user()->cart_count,
        ]);
    }

    public function remove(Request $request): JsonResponse
    {
        $request->validate(['item_id' => 'required|exists:cart_items,id']);

        CartItem::where('id', $request->item_id)
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json([
            'success' => true,
            'cart_count' => auth()->user()->fresh()->cart_count,
        ]);
    }

    public function count(): JsonResponse
    {
        return response()->json(['count' => auth()->user()->cart_count]);
    }
}
