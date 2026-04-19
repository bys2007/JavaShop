@extends('layouts.app')
@section('title', 'Katalog Produk')
@section('content')
    <section class="py-8">
        <div class="container-main">
            {{-- Page Header --}}
            <div class="mb-8">
                <h1 class="font-display font-semibold text-h1 text-on-surface">Katalog Produk</h1>
                <p class="font-body text-body-lg text-tertiary mt-1">
                    @if(request('q'))
                        Hasil pencarian untuk "<strong>{{ request('q') }}</strong>" — {{ $products->total() }} produk ditemukan
                    @elseif(request('kategori'))
                        Menampilkan kategori: <strong>{{ request('kategori') }}</strong>
                    @else
                        Temukan kopi pilihan dari berbagai daerah Indonesia
                    @endif
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Sidebar Filters --}}
                <aside class="lg:w-64 shrink-0">
                    <div class="card p-6 space-y-6 lg:sticky lg:top-[88px]">
                        {{-- Categories --}}
                        <div>
                            <h3 class="font-body font-medium text-h4 text-on-surface mb-3">Kategori</h3>
                            <ul class="space-y-1.5">
                                <li>
                                    <a href="{{ route('catalog.index', request()->except('kategori')) }}"
                                       class="block py-1.5 px-3 rounded-lg text-sm transition-colors {{ !request('kategori') ? 'bg-primary text-white font-medium' : 'text-tertiary hover:bg-surface' }}">
                                        Semua Produk
                                    </a>
                                </li>
                                @foreach($categories as $cat)
                                    <li>
                                        <a href="{{ route('catalog.index', array_merge(request()->except('kategori'), ['kategori' => $cat->slug])) }}"
                                           class="flex items-center justify-between py-1.5 px-3 rounded-lg text-sm transition-colors {{ request('kategori') == $cat->slug ? 'bg-primary text-white font-medium' : 'text-tertiary hover:bg-surface' }}">
                                            <span>{{ $cat->name }}</span>
                                            <span class="text-xs opacity-70">{{ $cat->products_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Price Range --}}
                        <div>
                            <h3 class="font-body font-medium text-h4 text-on-surface mb-3">Rentang Harga</h3>
                            <form method="GET" action="{{ route('catalog.index') }}" class="space-y-3">
                                @foreach(request()->except(['min_price', 'max_price']) as $key => $val)
                                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                                @endforeach
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Minimum" class="form-input text-sm py-2">
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Maximum" class="form-input text-sm py-2">
                                <button type="submit" class="btn-primary btn-sm w-full">Terapkan</button>
                            </form>
                        </div>
                    </div>
                </aside>

                {{-- Product Grid --}}
                <div class="flex-1">
                    {{-- Sort Bar --}}
                    <div class="flex items-center justify-between mb-6 bg-surface rounded-card px-4 py-3">
                        <span class="text-sm text-tertiary">{{ $products->total() }} produk</span>
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-tertiary">Urutkan:</label>
                            <select onchange="window.location.href = this.value"
                                    class="form-input text-sm py-1.5 px-3 w-auto bg-base">
                                @php
                                    $sorts = ['terbaru' => 'Terbaru', 'terlaris' => 'Terlaris', 'termurah' => 'Termurah', 'termahal' => 'Termahal', 'rating' => 'Rating Tertinggi'];
                                @endphp
                                @foreach($sorts as $val => $label)
                                    <option value="{{ route('catalog.index', array_merge(request()->all(), ['sort' => $val])) }}"
                                            {{ request('sort', 'terbaru') == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if($products->isEmpty())
                        {{-- Empty State --}}
                        <div class="text-center py-20">
                            <div class="w-20 h-20 rounded-full bg-surface mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 256 256" stroke="currentColor"><path d="M229.66,218.34l-50.07-50.07a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.31ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z" fill="currentColor"/></svg>
                            </div>
                            <h3 class="font-display font-medium text-h3 text-on-surface">Produk tidak ditemukan</h3>
                            <p class="font-body text-sm text-tertiary mt-2 mb-6">Coba ubah kata kunci atau filter Anda</p>
                            <a href="{{ route('catalog.index') }}" class="btn-primary">Lihat Semua Produk</a>
                        </div>
                    @else
                        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                @include('components.product-card', ['product' => $product, 'showAddToCart' => true])
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if($products->hasPages())
                            <div class="mt-10 flex justify-center">
                                {{ $products->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

