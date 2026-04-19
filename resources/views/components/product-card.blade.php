{{-- Product Card Component --}}
@props(['product', 'showAddToCart' => false])

<div class="product-card group" data-aos="fade-up">
    <a href="{{ route('catalog.show', $product->slug) }}" class="block">
        {{-- Image --}}
        <div class="product-image relative">
            <img src="{{ $product->primary_image_url }}"
                 alt="{{ $product->name }}"
                 class="w-full aspect-[4/5] object-cover"
                 loading="lazy"
                 onerror="this.src='https://placehold.co/400x500/F0E8D8/6B4C35?text={{ urlencode($product->name) }}'">

            {{-- Badges --}}
            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                @if($product->created_at->gt(now()->subDays(14)))
                    <span class="badge-gold text-[10px]">BARU</span>
                @endif
                @if(!$product->isInStock())
                    <span class="badge-error text-[10px]">HABIS</span>
                @endif
            </div>

            {{-- Wishlist Heart --}}
            @auth
                @php
                    $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                        ->where('product_id', $product->id)->exists();
                @endphp
                <button
                    x-data="{ wishlisted: {{ $isWishlisted ? 'true' : 'false' }} }"
                    @click.prevent.stop="
                        wishlisted = !wishlisted;
                        fetchWithCsrf('/api/wishlist/toggle', {
                            method: 'POST',
                            body: JSON.stringify({ product_id: {{ $product->id }} })
                        })
                    "
                    class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center transition-all duration-200 hover:scale-110"
                    :class="wishlisted ? 'text-primary' : 'text-tertiary'">
                    <svg class="w-4 h-4" viewBox="0 0 256 256" :fill="wishlisted ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="16">
                        <path d="M178,40c-20.65,0-38.73,8.88-50,23.89C116.73,48.88,98.65,40,78,40a62.07,62.07,0,0,0-62,62c0,70,103.79,126.66,108.21,129a8,8,0,0,0,7.58,0C136.21,228.66,240,172,240,102A62.07,62.07,0,0,0,178,40Z"/>
                    </svg>
                </button>
            @endauth

        </div>

        {{-- Info --}}
        <div class="p-4">
            <h3 class="font-display font-medium text-lg leading-tight text-on-surface mb-0.5">{{ $product->name }}</h3>
            <p class="text-caption text-tertiary mb-2">{{ $product->category->name }}</p>
            <div class="flex items-center justify-between">
                <span class="font-body font-bold text-base text-primary">{{ $product->formatted_price }}</span>
                @if($product->review_count > 0)
                    <div class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-primary" fill="currentColor" viewBox="0 0 256 256"><path d="M234.5,114.38l-45.1,39.36,13.51,58.6a16,16,0,0,1-23.84,17.34l-51.11-31-51,31a16,16,0,0,1-23.84-17.34l13.49-58.54L21.49,114.38a16,16,0,0,1,9.11-28.06l59.46-5.15,23.21-55.36a15.95,15.95,0,0,1,29.44,0h0L166,81.17l59.44,5.15a16,16,0,0,1,9.11,28.06Z"/></svg>
                        <span class="text-caption text-tertiary">{{ number_format($product->average_rating, 1) }} ({{ $product->review_count }})</span>
                    </div>
                @endif
            </div>
        </div>
    </a>
</div>
