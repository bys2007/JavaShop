@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
<div class="bg-base min-h-screen">
    <!-- {{-- Greeting Header --}}
    <div class="bg-surface border-b border-surface">
        <div class="container-main py-6">
            <h1 class="font-display font-semibold text-2xl text-on-surface">Selamat Datang, {{ auth()->user()->name }} 👋</h1>
            <p class="font-body text-tertiary mt-1">Temukan kopi terbaik pilihan JavaShop hari ini.</p>
        </div>
    </div> -->
    {{-- Full Width Banners Slider --}}
    @if($banners->isNotEmpty())
        <section x-data="{ 
                     activeSlide: 0, 
                     slidesCount: {{ $banners->count() }}, 
                     autoSlideInterval: null,
                     startAutoSlide() {
                         if (this.slidesCount > 1) {
                             this.autoSlideInterval = setInterval(() => {
                                 this.activeSlide = (this.activeSlide + 1) % this.slidesCount;
                             }, 4500);
                         }
                     },
                     stopAutoSlide() {
                         clearInterval(this.autoSlideInterval);
                     }
                 }" 
                 x-init="startAutoSlide()"
                 @mouseenter="stopAutoSlide()"
                 @mouseleave="startAutoSlide()"
                 class="relative w-full overflow-hidden bg-neutral/20 group">
            
            <div class="flex transition-transform duration-700 ease-in-out"
                 :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
                @foreach($banners as $banner)
                    <div class="w-full shrink-0 relative aspect-[16/5]">
                        @if($banner->link_url)
                            <a href="{{ $banner->link_url }}" class="block w-full h-full">
                        @endif
                        <img src="{{ asset('storage/' . $banner->image_url) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        @if($banner->link_url)
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Slider Controls --}}
            @if($banners->count() > 1)
                <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-10">
                    <template x-for="i in slidesCount">
                        <button @click="activeSlide = i - 1" 
                                class="h-2.5 rounded-full transition-all duration-300"
                                :class="activeSlide === i - 1 ? 'bg-primary w-8' : 'bg-white/60 hover:bg-white w-2.5'"></button>
                    </template>
                </div>
                {{-- Arrow Controls --}}
                <button @click="activeSlide = activeSlide === 0 ? slidesCount - 1 : activeSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/30 hover:bg-black/60 text-white rounded-full hidden sm:flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all backdrop-blur-sm z-10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="activeSlide = (activeSlide + 1) % slidesCount" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/30 hover:bg-black/60 text-white rounded-full hidden sm:flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all backdrop-blur-sm z-10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            @endif
        </section>
    @endif

    <div class="container-main py-10 space-y-16">


        {{-- Kategori Pilihan --}}
        <section>
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display font-semibold text-2xl text-on-surface">Kategori Pilihan</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($categories->take(6) as $category)
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="group block text-center bg-surface p-4 rounded-xl shadow-sm hover:shadow-md border border-neutral transition-all">
                        <h3 class="font-body font-medium text-sm text-on-surface group-hover:text-primary transition-colors">{{ $category->name }}</h3>
                        <p class="text-xs text-tertiary">{{ $category->products_count }} Produk</p>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Produk Terlaris (Featured) --}}
        @if($featuredProducts->isNotEmpty())
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-display font-semibold text-2xl text-on-surface">Pilihan Terbaik Buatmu</h2>
                    <a href="{{ route('catalog.index') }}" class="text-sm font-medium text-primary hover:underline">Lihat Semua</a>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featuredProducts as $product)
                        @include('components.product-card', ['product' => $product, 'showAddToCart' => true])
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Terbaru --}}
        @if($latestProducts->isNotEmpty())
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-display font-semibold text-2xl text-on-surface">Biji Kopi Baru Tiba</h2>
                    <a href="{{ route('catalog.index', ['sort' => 'newest']) }}" class="text-sm font-medium text-primary hover:underline">Jelajahi Spesial</a>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($latestProducts as $product)
                        @include('components.product-card', ['product' => $product, 'showAddToCart' => true])
                    @endforeach
                </div>
            </section>
        @endif

    </div>
</div>
@endsection
