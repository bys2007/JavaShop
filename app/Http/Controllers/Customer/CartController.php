<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = CartItem::with(['variant.product.images'])
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);
        $itemCount = $cartItems->sum('quantity');

        return view('pages.cart.index', compact('cartItems', 'subtotal', 'itemCount'));
    }
}
