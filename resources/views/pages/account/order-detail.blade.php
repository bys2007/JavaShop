@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('content')
    <section class="py-8">
        <div class="container-main">
            <div class="grid lg:grid-cols-4 gap-8">
                @include('components.account-sidebar')

                <div class="lg:col-span-3">
                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <a href="{{ route('account.orders') }}" class="text-sm text-tertiary hover:text-primary transition-colors">← Kembali ke Riwayat</a>
                            <h1 class="font-display font-semibold text-h1 text-on-surface mt-1">{{ $order->order_number }}</h1>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="badge badge-{{ $order->status_color }}">
                                {{ $order->status_label }}
                            </span>
                            @if(in_array($order->status, ['pending_admin', 'pending_payment']))
                                <form action="{{ route('account.order-cancel', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                    @csrf
                                    <button type="submit" class="text-xs text-error font-medium hover:underline px-3 py-1 border border-error/20 rounded-lg bg-error/5 transition-colors">Batalkan Pesanan</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        {{-- Shipping Info --}}
                        <div class="card p-5">
                            <h3 class="form-label mb-3">ALAMAT PENGIRIMAN</h3>
                            @if($order->address)
                                <p class="text-sm font-medium text-on-surface">{{ $order->address->recipient_name }}</p>
                                <p class="text-sm text-tertiary mt-1">{{ $order->address->phone }}</p>
                                <p class="text-sm text-tertiary mt-1">{{ $order->address->full_formatted }}</p>
                            @else
                                <p class="text-sm text-tertiary">Alamat tidak tersedia</p>
                            @endif
                        </div>

                        {{-- Payment Info --}}
                        <div class="card p-5">
                            <h3 class="form-label mb-3">PEMBAYARAN</h3>
                            @if($order->payment)
                                <p class="text-sm text-on-surface">{{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}</p>
                                @if($order->payment->bank_name)
                                    <p class="text-sm text-tertiary mt-1">{{ $order->payment->bank_name }}</p>
                                @endif
                                <p class="text-sm text-tertiary mt-1">Status: {{ $order->payment->status_label }}</p>
                            @else
                                <p class="text-sm text-tertiary">Belum ada pembayaran</p>
                            @endif
                            @if($order->tracking_number)
                                <p class="text-sm text-tertiary mt-2">Resi: <span class="font-mono text-on-surface">{{ $order->tracking_number }}</span></p>
                            @endif
                        </div>
                    </div>

                    {{-- Items --}}
                    <div class="card p-5 mb-6" x-data="{
                        reviewModal: false,
                        reviewProductId: null,
                        reviewProductName: null,
                        rating: 5,
                        comment: '',
                        openReview(id, name) {
                            this.reviewProductId = id;
                            this.reviewProductName = name;
                            this.rating = 5;
                            this.comment = '';
                            this.reviewModal = true;
                        }
                    }">
                        <h3 class="form-label mb-4">DAFTAR PRODUK</h3>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                @php
                                    $productId = $item->variant?->product_id;
                                    $hasReviewed = $productId ? \App\Models\Review::where('order_id', $order->id)->where('product_id', $productId)->exists() : false;
                                @endphp
                                <div class="flex flex-wrap sm:flex-nowrap items-center gap-4">
                                    @if($item->variant?->product)
                                        <a href="{{ route('catalog.show', $item->variant->product->slug) }}" class="block shrink-0 transition-transform hover:scale-105">
                                            <img src="{{ $item->variant->product->primary_image_url }}"
                                                 class="w-16 h-16 rounded-lg object-cover bg-surface">
                                        </a>
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('catalog.show', $item->variant->product->slug) }}" class="hover:text-primary transition-colors">
                                                <p class="text-sm font-medium text-on-surface hover:text-primary truncate">{{ $item->product_name }}</p>
                                            </a>
                                            <p class="text-xs text-tertiary">{{ $item->variant_info }} × {{ $item->quantity }}</p>
                                        </div>
                                    @else
                                        <img src="https://placehold.co/60x60/F0E8D8/6B4C35?text=Kopi"
                                             class="w-16 h-16 rounded-lg object-cover bg-surface shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-on-surface truncate">{{ $item->product_name }}</p>
                                            <p class="text-xs text-tertiary">{{ $item->variant_info }} × {{ $item->quantity }}</p>
                                        </div>
                                    @endif
                                    <div class="text-right w-full sm:w-auto mt-2 sm:mt-0 flex flex-row sm:flex-col justify-between sm:justify-end items-center sm:items-end">
                                        <span class="text-sm font-medium block">{{ $item->formatted_subtotal }}</span>
                                        
                                        @if($order->status === 'delivered' && $productId)
                                            @if(!$hasReviewed)
                                                <button @click="openReview({{ $productId }}, '{{ addslashes($item->product_name) }}')" type="button" class="mt-0 sm:mt-2 text-xs text-primary font-medium hover:underline border border-primary/20 px-3 py-1 rounded-full bg-primary/5 transition-colors">
                                                    Beri Ulasan
                                                </button>
                                            @else
                                                <span class="mt-0 sm:mt-2 text-xs text-success font-medium bg-success/10 px-2 py-0.5 rounded-full inline-block">✔️ Selesai Diulas</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="divider mt-4 mb-4"></div>

                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-tertiary">Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                            <div class="flex justify-between"><span class="text-tertiary">Ongkir ({{ $order->courier ?? '-' }})</span><span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
                            @if($order->discount > 0)
                                <div class="flex justify-between text-success"><span>Diskon</span><span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span></div>
                            @endif
                            <div class="divider"></div>
                            <div class="flex justify-between font-medium text-base">
                                <span>Total</span>
                                <span class="font-display font-semibold text-xl text-primary">{{ $order->formatted_total }}</span>
                            </div>
                        </div>
                        
                        {{-- Review Modal Component --}}
                        <div x-show="reviewModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                            <div @click.away="reviewModal = false" x-transition class="bg-base rounded-card max-w-md w-full p-6 shadow-modal border border-neutral mx-auto">
                                <h3 class="font-display font-semibold text-h3 text-on-surface mb-2">Beri Ulasan Produk</h3>
                                <p class="text-sm text-tertiary mb-6">Ceritakan pengalaman Anda terkait produk <span class="font-medium text-on-surface" x-text="reviewProductName"></span>.</p>
                                
                                <form action="{{ route('account.order-review.store', $order->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" :value="reviewProductId">
                                    
                                    <div class="mb-5">
                                        <label class="form-label mb-3 block text-center">Berapa bintang untuk produk ini?</label>
                                        <div class="flex justify-center gap-2">
                                            <template x-for="star in 5">
                                                <button type="button" @click="rating = star" class="transition-transform hover:scale-110 focus:outline-none">
                                                    <svg class="w-10 h-10" :class="star <= rating ? 'text-primary' : 'text-neutral'" fill="currentColor" viewBox="0 0 256 256"><path d="M234.5,114.38l-45.1,39.36,13.51,58.6a16,16,0,0,1-23.84,17.34l-51.11-31-51,31a16,16,0,0,1-23.84-17.34l13.49-58.54L21.49,114.38a16,16,0,0,1,9.11-28.06l59.46-5.15,23.21-55.36a15.95,15.95,0,0,1,29.44,0h0L166,81.17l59.44,5.15a16,16,0,0,1,9.11,28.06Z"/></svg>
                                                </button>
                                            </template>
                                        </div>
                                        <input type="hidden" name="rating" :value="rating">
                                    </div>

                                    <div class="mb-8">
                                        <label class="form-label mb-2 block">Tulis Ulasan (Opsional)</label>
                                        <textarea name="comment" x-model="comment" rows="4" class="form-input" placeholder="Bagaimana rasa kopinya? Apakah sesuai ekspektasi?"></textarea>
                                    </div>

                                    <div class="flex justify-end gap-3 mt-4">
                                        <button type="button" @click="reviewModal = false" class="btn-secondary px-6">Batal</button>
                                        <button type="submit" class="btn-primary px-6">Kirim Ulasan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                    {{-- Notes --}}
                    @if($order->notes)
                        <div class="card p-5">
                            <h3 class="form-label mb-2">CATATAN</h3>
                            <p class="text-sm text-tertiary">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
