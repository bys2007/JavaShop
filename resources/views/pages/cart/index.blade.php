@extends('layouts.app')
@section('title', 'Keranjang')
@section('content')
    <section class="py-8">
        <div class="container-main">
            <h1 class="font-display font-semibold text-h1 text-on-surface mb-8">Keranjang Belanja</h1>

            @if($cartItems->isEmpty())
                <div class="text-center py-20">
                    <div class="w-20 h-20 rounded-full bg-surface mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 256 256"><path d="M222.14,58.87A8,8,0,0,0,216,56H54.68L49.79,29.14A16,16,0,0,0,34.05,16H16a8,8,0,0,0,0,16H34.05l32.51,172a24,24,0,0,0,21.49,19.19,28,28,0,1,0,41.27-.19h29.44a28,28,0,1,0,17.34,0A24.07,24.07,0,0,0,188.1,192H82.49a8,8,0,0,1-7.88-6.51L71.49,168H196.1a16,16,0,0,0,15.74-13.14l25.4-114.4A8,8,0,0,0,222.14,58.87Z"/></svg>
                    </div>
                    <h3 class="font-display font-medium text-h3 text-on-surface">Keranjang masih kosong</h3>
                    <p class="font-body text-sm text-tertiary mt-2 mb-6">Yuk jelajahi koleksi kopi terbaik kami!</p>
                    <a href="{{ route('catalog.index') }}" class="btn-primary">Mulai Belanja</a>
                </div>
            @else
                <div class="grid lg:grid-cols-3 gap-8">
                    {{-- Cart Items --}}
                    <div class="lg:col-span-2 space-y-4" x-data="{
                        async updateQty(itemId, qty) {
                            const res = await fetchWithCsrf('/api/cart/update', { method: 'POST', body: JSON.stringify({ item_id: itemId, quantity: qty }) });
                            if (res.ok) location.reload();
                        },
                        async removeItem(itemId) {
                            const res = await fetchWithCsrf('/api/cart/remove', { method: 'POST', body: JSON.stringify({ item_id: itemId }) });
                            if (res.ok) location.reload();
                        }
                    }">
                        @foreach($cartItems as $item)
                            <div class="card p-5 flex gap-5 items-start" id="cart-item-{{ $item->id }}">
                                {{-- Product Image --}}
                                <a href="{{ route('catalog.show', $item->variant->product->slug) }}" class="shrink-0">
                                    <img src="{{ $item->variant->product->primary_image_url }}"
                                         alt="{{ $item->variant->product->name }}"
                                         class="w-20 h-20 rounded-card object-cover"
                                         onerror="this.src='https://placehold.co/80x80/F0E8D8/6B4C35?text=Kopi'">
                                </a>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('catalog.show', $item->variant->product->slug) }}" class="font-display font-medium text-base text-on-surface hover:text-primary transition-colors">
                                        {{ $item->variant->product->name }}
                                    </a>
                                    <p class="text-caption text-tertiary mt-0.5">{{ $item->variant->display_name }}</p>
                                    <p class="font-body font-bold text-sm text-primary mt-2">{{ $item->variant->formatted_price }}</p>
                                </div>

                                {{-- Quantity + Remove --}}
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center border border-neutral rounded-button">
                                        <button @click="updateQty({{ $item->id }}, {{ max(1, $item->quantity - 1) }})" class="w-8 h-8 flex items-center justify-center text-tertiary hover:text-on-surface text-sm">−</button>
                                        <span class="w-8 text-center text-sm font-medium">{{ $item->quantity }}</span>
                                        <button @click="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})" class="w-8 h-8 flex items-center justify-center text-tertiary hover:text-on-surface text-sm">+</button>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-body font-bold text-sm text-on-surface">{{ $item->formatted_subtotal }}</p>
                                    </div>
                                    <button @click="removeItem({{ $item->id }})" class="text-tertiary hover:text-error transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 256 256"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Order Summary --}}
                    <div class="lg:col-span-1">
                        <div class="card p-6 lg:sticky lg:top-[88px]">
                            <h3 class="font-display font-medium text-h3 text-on-surface mb-4">Ringkasan Belanja</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-tertiary">Subtotal ({{ $itemCount }} item)</span>
                                    <span class="font-medium text-on-surface">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-tertiary">Ongkos Kirim</span>
                                    <span class="text-tan">Dihitung saat checkout</span>
                                </div>
                                <div class="divider"></div>
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-on-surface">Total</span>
                                    <span class="font-display font-semibold text-2xl text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn-primary w-full mt-6 text-center">
                                Checkout
                            </a>
                            <a href="{{ route('catalog.index') }}" class="block text-center mt-3 text-sm text-tertiary hover:text-primary transition-colors">
                                Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
