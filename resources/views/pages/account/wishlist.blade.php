@extends('layouts.app')
@section('title', 'Wishlist')
@section('content')
    <section class="py-8">
        <div class="container-main">
            <div class="grid lg:grid-cols-4 gap-8">
                @include('components.account-sidebar')

                <div class="lg:col-span-3">
                    <h1 class="font-display font-semibold text-h1 text-on-surface mb-6">Wishlist Saya</h1>

                    @if($products->isEmpty())
                        <div class="text-center py-16">
                            <div class="w-16 h-16 rounded-full bg-surface mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-7 h-7 text-primary" fill="currentColor" viewBox="0 0 256 256"><path d="M178,40c-20.65,0-38.73,8.88-50,23.89C116.73,48.88,98.65,40,78,40a62.07,62.07,0,0,0-62,62c0,70,103.79,126.66,108.21,129a8,8,0,0,0,7.58,0C136.21,228.66,240,172,240,102A62.07,62.07,0,0,0,178,40Z"/></svg>
                            </div>
                            <h3 class="font-display font-medium text-h3 text-on-surface">Wishlist masih kosong</h3>
                            <p class="text-sm text-tertiary mt-2 mb-6">Simpan produk favorit Anda untuk nanti!</p>
                            <a href="{{ route('catalog.index') }}" class="btn-primary">Jelajahi Produk</a>
                        </div>
                    @else
                        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                @include('components.product-card', ['product' => $product, 'showAddToCart' => true])
                            @endforeach
                        </div>

                        @if($products->hasPages())
                            <div class="mt-8">{{ $products->links() }}</div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
