<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View
    {
        return view('pages.checkout.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'courier_company' => 'required|string',
            'courier_type' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        $user = auth()->user();
        $cartItems = CartItem::with('variant.product')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        $address = $user->addresses()->findOrFail($request->address_id);

        // Calculate totals
        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);
        $shippingCost = $request->shipping_cost;
        $discount = 0;
        $voucherId = null;

        // Apply voucher if provided
        if ($request->filled('voucher_code')) {
            $voucher = Voucher::where('code', strtoupper($request->voucher_code))->first();
            if ($voucher) {
                $validation = $voucher->isValid($subtotal);
                if ($validation['valid']) {
                    $discount = $voucher->calculateDiscount($subtotal);
                    $voucherId = $voucher->id;
                    $voucher->increment('used_count');
                }
            }
        }

        $total = $subtotal + $shippingCost - $discount;

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'voucher_id' => $voucherId,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'discount' => $discount,
            'total' => $total,
            'courier' => $request->courier_company,
            'courier_service' => $request->courier_type,
            'notes' => $request->notes,
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'variant_id' => $item->variant_id,
                'product_name' => $item->variant->product->name,
                'variant_info' => $item->variant->display_name,
                'price' => $item->variant->price,
                'quantity' => $item->quantity,
                'subtotal' => $item->subtotal,
            ]);

            // Decrement stock
            $item->variant->decrement('stock', $item->quantity);
        }

        // Record voucher usage
        if ($voucherId) {
            VoucherUsage::create([
                'voucher_id' => $voucherId,
                'user_id' => $user->id,
                'order_id' => $order->id,
                'used_at' => now(),
            ]);
        }

        // Clear cart
        CartItem::where('user_id', $user->id)->delete();

        return redirect()->route('checkout.payment', $order->order_number);
    }

    public function payment(Order $order): View
    {
        // Ensure this logic applies only to the user's own orders
        abort_if($order->user_id !== auth()->id(), 403);

        $snapToken = null;
        if ($order->payment_method === 'midtrans' && $order->status === 'pending_payment') {
            // Reuse cached token to avoid Midtrans duplicate order_id error
            if ($order->snap_token) {
                $snapToken = $order->snap_token;
            } else {
                try {
                    $midtrans  = new MidtransService();
                    $snapToken = $midtrans->getSnapToken($order);
                    $order->update(['snap_token' => $snapToken]);
                } catch (\Exception $e) {
                    return view('pages.checkout.payment', compact('order', 'snapToken'))
                        ->with('error', 'Gagal menghubungi Midtrans: ' . $e->getMessage());
                }
            }
        }

        return view('pages.checkout.payment', compact('order', 'snapToken'));
    }

    public function updateMethod(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $request->validate(['method' => 'required|in:midtrans,cod']);

        if ($request->method === 'cod') {
            $order->update([
                'payment_method' => 'cod',
                'status'         => 'pending_admin',
                'snap_token'     => null,
            ]);
            return redirect()->route('order.success')->with('order_number', $order->order_number);
        }

        // Midtrans: reset snap_token so a fresh one is generated on payment page
        $order->update(['payment_method' => 'midtrans', 'status' => 'pending_payment', 'snap_token' => null]);
        return redirect()->route('checkout.payment', $order->order_number);
    }
}
