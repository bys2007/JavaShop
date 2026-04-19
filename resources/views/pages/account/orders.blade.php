@extends('layouts.app')
@section('title', 'Riwayat Pesanan')
@section('content')
    <section class="py-8">
        <div class="container-main">
            <div class="grid lg:grid-cols-4 gap-8">
                @include('components.account-sidebar')

                <div class="lg:col-span-3">
                    <h1 class="font-display font-semibold text-h1 text-on-surface mb-6">Riwayat Pesanan</h1>

                    @forelse($orders as $order)
                        <div class="card p-5 mb-4">
                            {{-- Order Header --}}
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="font-body font-bold text-sm text-on-surface">{{ $order->order_number }}</span>
                                    <span class="text-caption text-tertiary ml-2">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="badge badge-status-{{ $order->order_status === 'completed' || $order->order_status === 'delivered' ? 'completed' : ($order->order_status === 'shipped' ? 'shipped' : ($order->order_status === 'cancelled' ? 'cancelled' : ($order->order_status === 'pending' ? 'pending' : 'processing'))) }}">
                                        {{ $order->status_label }}
                                    </span>
                                </div>
                            </div>

                            {{-- Items Preview --}}
                            <div class="space-y-3">
                                @foreach($order->items->take(2) as $item)
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $item->productVariant?->product?->primary_image_url ?? 'https://placehold.co/60x60/F0E8D8/6B4C35?text=Kopi' }}"
                                             alt="" class="w-14 h-14 rounded-lg object-cover bg-surface">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-on-surface truncate">{{ $item->product_name }}</p>
                                            <p class="text-xs text-tertiary">{{ $item->variant_info }} × {{ $item->quantity }}</p>
                                        </div>
                                        <span class="text-sm font-medium text-on-surface">{{ $item->formatted_subtotal }}</span>
                                    </div>
                                @endforeach
                                @if($order->items->count() > 2)
                                    <p class="text-xs text-tertiary">+{{ $order->items->count() - 2 }} produk lainnya</p>
                                @endif
                            </div>

                            {{-- Footer --}}
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-neutral">
                                <div>
                                    <span class="text-sm text-tertiary">Total:</span>
                                    <span class="font-display font-semibold text-lg text-primary ml-1">{{ $order->formatted_total }}</span>
                                </div>
                                <a href="{{ route('account.order-detail', $order->id) }}" class="btn-secondary btn-sm">
                                    Detail Pesanan
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div class="w-16 h-16 rounded-full bg-surface mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-7 h-7 text-primary" fill="currentColor" viewBox="0 0 256 256"><path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,16V96H40V56ZM40,200V112H216v88Z"/></svg>
                            </div>
                            <h3 class="font-display font-medium text-h3 text-on-surface">Belum ada pesanan</h3>
                            <p class="text-sm text-tertiary mt-2 mb-6">Mulai belanja dan nikmati kopi terbaik!</p>
                            <a href="{{ route('catalog.index') }}" class="btn-primary">Jelajahi Produk</a>
                        </div>
                    @endforelse

                    @if($orders->hasPages())
                        <div class="mt-6">{{ $orders->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
