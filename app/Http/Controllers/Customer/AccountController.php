<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function profile(): View
    {
        $user = auth()->user();
        $user->load('addresses');
        $orderCount = $user->orders()->count();
        $reviewCount = $user->reviews()->count();
        $totalSpent = $user->orders()->where('status', 'delivered')->sum('total');

        return view('pages.account.profile', compact('user', 'orderCount', 'reviewCount', 'totalSpent'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($request->only('name', 'phone'));

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function orders(): View
    {
        $orders = auth()->user()->orders()
            ->with(['items.variant.product.images'])
            ->latest()
            ->paginate(10);

        return view('pages.account.orders', compact('orders'));
    }

    public function orderDetail($orderId): View
    {
        $order = auth()->user()->orders()
            ->with(['items.variant.product.images', 'payment', 'address'])
            ->findOrFail($orderId);

        return view('pages.account.order-detail', compact('order'));
    }

    public function cancelOrder($orderId)
    {
        $order = auth()->user()->orders()->findOrFail($orderId);

        if (!in_array($order->status, ['pending_admin', 'pending_payment'])) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        $order->update(['status' => 'cancelled']);
        
        // Restore stock
        foreach ($order->items as $item) {
            $item->variant->increment('stock', $item->quantity);
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function wishlist(): View
    {
        $products = Wishlist::with(['product.category', 'product.variants', 'product.images'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12)
            ->through(fn ($w) => $w->product);

        return view('pages.account.wishlist', compact('products'));
    }

    public function reviews(): View
    {
        return view('pages.account.reviews');
    }

    public function notifications(): View
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('pages.account.notifications', compact('notifications'));
    }

    public function addresses(): View
    {
        $addresses = auth()->user()->addresses;
        return view('pages.account.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_default' => 'boolean',
        ]);

        if (empty(auth()->user()->addresses) || !empty($validated['is_default'])) {
            // First address or set as default explicitly -> untick others
            auth()->user()->addresses()->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        auth()->user()->addresses()->create($validated);

        return back()->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function destroyAddress(\App\Models\UserAddress $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }
        
        try {
            $address->delete();

            if ($address->is_default) {
                $anotherAddress = auth()->user()->addresses()->first();
                if ($anotherAddress) {
                    $anotherAddress->update(['is_default' => true]);
                }
            }
            
            return back()->with('success', 'Alamat berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) { // Integrity constraint violation
                return back()->with('error', 'Alamat ini tidak dapat dihapus karena telah digunakan pada riwayat pesanan Anda.');
            }
            return back()->with('error', 'Terjadi kesalahan saat menghapus alamat.');
        }
    }

    public function changePassword(): View
    {
        return view('pages.account.change-password');
    }

    public function storeReview(Request $request, Order $order)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:1000',
        ]);

        if ($order->user_id !== auth()->id() || $order->status !== 'delivered') {
            return back()->with('error', 'Pesanan tidak valid untuk diulas.');
        }

        $existing = \App\Models\Review::where('user_id', auth()->id())
            ->where('order_id', $order->id)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini pada pesanan tersebut.');
        }

        \App\Models\Review::create([
            'user_id'     => auth()->id(),
            'order_id'    => $order->id,
            'product_id'  => $request->product_id,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
            'is_approved' => true,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}
