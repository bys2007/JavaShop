@extends('layouts.app')
@section('title', $product->name)
@section('content')
    <section class="py-8">
        <div class="container-main">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-tertiary mb-6">
                <a href="{{ route('landing') }}" class="hover:text-primary transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('catalog.index') }}" class="hover:text-primary transition-colors">Produk</a>
                <span>/</span>
                <a href="{{ route('catalog.index', ['kategori' => $product->category->slug]) }}" class="hover:text-primary transition-colors">{{ $product->category->name }}</a>
                <span>/</span>
                <span class="text-on-surface font-medium">{{ $product->name }}</span>
            </nav>

            <div class="grid lg:grid-cols-2 gap-10">
                {{-- Image Gallery --}}
                <div x-data="{ activeImage: '{{ $product->primary_image_url }}' }">
                    {{-- Main Image --}}
                    <div class="relative rounded-modal overflow-hidden bg-surface mb-4">
                        <img :src="activeImage"
                             alt="{{ $product->name }}"
                             class="w-full aspect-square object-cover"
                             onerror="this.src='https://placehold.co/600x600/F0E8D8/6B4C35?text={{ urlencode($product->name) }}'">
                        @if(!$product->isInStock())
                            <div class="absolute inset-0 bg-on-surface/40 flex items-center justify-center">
                                <span class="badge-error text-lg px-6 py-2">HABIS</span>
                            </div>
                        @endif
                    </div>
                    {{-- Thumbnails --}}
                    @if($product->images->count() > 1)
                        <div class="flex gap-3">
                            @foreach($product->images as $img)
                                <button @click="activeImage = '{{ $img->image_url }}'"
                                        :class="activeImage === '{{ $img->image_url }}' ? 'border-primary' : 'border-transparent'"
                                        class="w-20 h-20 rounded-card overflow-hidden border-2 transition-colors">
                                    <img src="{{ $img->image_url }}" alt="" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Product Info --}}
                <div>
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="font-body text-sm text-tertiary">{{ $product->category->name }}</span>
                            <h1 class="font-display font-semibold text-h1 text-on-surface mt-1">{{ $product->name }}</h1>
                        </div>
                        @auth
                            @php
                                $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                                    ->where('product_id', $product->id)->exists();
                            @endphp
                            <button x-data="{ wishlisted: {{ $isWishlisted ? 'true' : 'false' }} }"
                                    @click="wishlisted = !wishlisted; fetchWithCsrf('/api/wishlist/toggle', { method: 'POST', body: JSON.stringify({ product_id: {{ $product->id }} }) })"
                                    :class="wishlisted ? 'text-primary border-primary' : 'text-tertiary border-neutral'"
                                    class="w-10 h-10 rounded-full border-2 flex items-center justify-center transition-all hover:scale-110">
                                <svg class="w-5 h-5" viewBox="0 0 256 256" :fill="wishlisted ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="16">
                                    <path d="M178,40c-20.65,0-38.73,8.88-50,23.89C116.73,48.88,98.65,40,78,40a62.07,62.07,0,0,0-62,62c0,70,103.79,126.66,108.21,129a8,8,0,0,0,7.58,0C136.21,228.66,240,172,240,102A62.07,62.07,0,0,0,178,40Z"/>
                                </svg>
                            </button>
                        @endauth
                    </div>

                    {{-- Rating --}}
                    @if($product->review_count > 0)
                        <div class="flex items-center gap-2 mt-3">
                            <div class="flex gap-0.5">
                                @for($s = 1; $s <= 5; $s++)
                                    <svg class="w-4 h-4 {{ $s <= round($product->average_rating) ? 'text-primary' : 'text-neutral' }}" fill="currentColor" viewBox="0 0 256 256"><path d="M234.5,114.38l-45.1,39.36,13.51,58.6a16,16,0,0,1-23.84,17.34l-51.11-31-51,31a16,16,0,0,1-23.84-17.34l13.49-58.54L21.49,114.38a16,16,0,0,1,9.11-28.06l59.46-5.15,23.21-55.36a15.95,15.95,0,0,1,29.44,0h0L166,81.17l59.44,5.15a16,16,0,0,1,9.11,28.06Z"/></svg>
                                @endfor
                            </div>
                            <span class="text-sm text-tertiary">{{ number_format($product->average_rating, 1) }} ({{ $product->review_count }} ulasan)</span>
                        </div>
                    @endif

                    {{-- Price & Variant Selection --}}
                    <div class="mt-6 mb-6" x-data="{
                        selectedSize: '{{ $product->variants->first()?->size }}',
                        selectedGrind: '{{ $product->variants->first()?->grind_type }}',
                        variants: {{ $product->variants->toJson() }},
                        quantity: 1,
                        isAdding: false,
                        showSuccessModal: false,
                        get currentVariant() {
                            return this.variants.find(v => v.size === this.selectedSize && v.grind_type === this.selectedGrind) || this.variants[0];
                        },
                        get price() {
                            return this.currentVariant ? new Intl.NumberFormat('id-ID').format(this.currentVariant.price) : '0';
                        },
                        get inStock() {
                            return this.currentVariant ? this.currentVariant.stock > 0 : false;
                        },
                        get stockText() {
                            if (!this.currentVariant) return '';
                            return this.currentVariant.stock > 10 ? 'Stok tersedia' : 'Sisa ' + this.currentVariant.stock + ' unit';
                        }
                    }">
                        <div class="text-3xl font-display font-semibold text-primary">
                            Rp <span x-text="price"></span>
                        </div>
                        <p class="text-sm mt-1" :class="inStock ? 'text-success' : 'text-error'" x-text="inStock ? stockText : 'Stok habis'"></p>

                        {{-- Size Selection --}}
                        <div class="mt-6">
                            <label class="form-label">Ukuran</label>
                            <div class="flex gap-3 mt-1">
                                @foreach($product->variants->unique('size') as $var)
                                    <button @click="selectedSize = '{{ $var->size }}'"
                                            :class="selectedSize === '{{ $var->size }}' ? 'bg-primary text-white border-primary' : 'bg-base text-on-surface border-neutral hover:border-primary/50'"
                                            class="px-5 py-2.5 rounded-button border-[1.5px] text-sm font-medium transition-all">
                                        {{ $var->size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Grind Type --}}
                        <div class="mt-5">
                            <label class="form-label">Tingkat Gilingan</label>
                            <div class="flex flex-wrap gap-3 mt-1">
                                @foreach($product->variants->unique('grind_type') as $var)
                                    <button @click="selectedGrind = '{{ $var->grind_type }}'"
                                            :class="selectedGrind === '{{ $var->grind_type }}' ? 'bg-primary text-white border-primary' : 'bg-base text-on-surface border-neutral hover:border-primary/50'"
                                            class="px-4 py-2 rounded-button border-[1.5px] text-sm font-medium transition-all">
                                        {{ $var->grind_type }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Quantity & Add to Cart --}}
                        <div class="mt-8 flex items-center gap-4">
                            <div class="flex items-center border-[1.5px] border-neutral rounded-button">
                                <button @click="quantity = Math.max(1, quantity - 1)" class="w-10 h-10 flex items-center justify-center text-tertiary hover:text-on-surface">−</button>
                                <span x-text="quantity" class="w-10 text-center font-medium"></span>
                                <button @click="quantity = Math.min(currentVariant?.stock || 99, quantity + 1)" class="w-10 h-10 flex items-center justify-center text-tertiary hover:text-on-surface">+</button>
                            </div>
                            <button @click="
                                if (!inStock || isAdding) return;
                                isAdding = true;
                                fetchWithCsrf('/api/cart/add', {
                                    method: 'POST',
                                    body: JSON.stringify({ product_variant_id: currentVariant.id, quantity: quantity })
                                }).then(r => r.json()).then(d => {
                                    $store.cart.count = d.cart_count || ($store.cart.count + quantity);
                                    isAdding = false;
                                    showSuccessModal = true;
                                }).catch(() => isAdding = false);
                            "
                            :disabled="!inStock || isAdding"
                            class="btn-primary flex-1"
                            :class="(!inStock || isAdding) && 'opacity-50 cursor-not-allowed'">
                                <template x-if="isAdding">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                <template x-if="!isAdding">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 256 256"><path d="M222.14,58.87A8,8,0,0,0,216,56H54.68L49.79,29.14A16,16,0,0,0,34.05,16H16a8,8,0,0,0,0,16H34.05l32.51,172a24,24,0,0,0,21.49,19.19,28,28,0,1,0,41.27-.19h29.44a28,28,0,1,0,17.34,0A24.07,24.07,0,0,0,188.1,192H82.49a8,8,0,0,1-7.88-6.51L71.49,168H196.1a16,16,0,0,0,15.74-13.14l25.4-114.4A8,8,0,0,0,222.14,58.87Z"/></svg>
                                </template>
                                <span x-text="isAdding ? 'Memproses...' : (inStock ? 'Tambah ke Keranjang' : 'Stok Habis')"></span>
                            </button>
                        </div>

                        {{-- Success Modal --}}
                        <div x-show="showSuccessModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="showSuccessModal = false" x-transition.opacity></div>

                                <div class="relative bg-surface rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-sm w-full p-6 text-center" x-transition.scale.90>
                                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-success/20 mb-5">
                                        <svg class="h-8 w-8 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <h3 class="font-display font-bold text-xl text-on-surface mb-2" id="modal-title">Berhasil!</h3>
                                    <p class="text-sm text-tertiary mb-6">Produk berhasil ditambahkan ke keranjang belanja Anda.</p>
                                    <div class="flex flex-col gap-3">
                                        <button type="button" @click="showSuccessModal = false" class="btn bg-surface text-on-surface border-2 border-neutral hover:border-primary/50 w-full py-2.5">
                                            Lanjut Belanja
                                        </button>
                                        <a href="{{ route('cart.index') }}" class="btn-primary w-full py-2.5">
                                            Lihat Keranjang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="divider my-6"></div>

                    {{-- Info Tabs --}}
                    <div x-data="{ tab: 'deskripsi' }">
                        <div class="flex border-b border-neutral gap-6 mb-6">
                            <button @click="tab = 'deskripsi'" :class="tab === 'deskripsi' ? 'border-primary text-primary' : 'border-transparent text-tertiary hover:text-on-surface'" class="pb-3 text-sm font-medium border-b-2 transition-colors">Deskripsi</button>
                            <button @click="tab = 'ulasan'" :class="tab === 'ulasan' ? 'border-primary text-primary' : 'border-transparent text-tertiary hover:text-on-surface'" class="pb-3 text-sm font-medium border-b-2 transition-colors">Ulasan ({{ $product->review_count }})</button>
                        </div>

                        {{-- Description --}}
                        <div x-show="tab === 'deskripsi'">
                            <div class="font-body text-body-lg text-tertiary leading-relaxed whitespace-pre-line">{{ $product->description }}</div>
                        </div>

                        {{-- Reviews --}}
                        <div x-show="tab === 'ulasan'" x-cloak>
                            @forelse($product->reviews->where('is_approved', true) as $review)
                                <div class="bg-surface rounded-card p-5 mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-primary/20 flex items-center justify-center">
                                                <span class="font-bold text-xs text-primary">{{ mb_strtoupper(mb_substr($review->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium">{{ $review->user->name }}</p>
                                                <p class="text-xs text-tertiary">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-0.5">
                                            @for($s = 1; $s <= 5; $s++)
                                                <svg class="w-3.5 h-3.5 {{ $s <= $review->rating ? 'text-primary' : 'text-neutral' }}" fill="currentColor" viewBox="0 0 256 256"><path d="M234.5,114.38l-45.1,39.36,13.51,58.6a16,16,0,0,1-23.84,17.34l-51.11-31-51,31a16,16,0,0,1-23.84-17.34l13.49-58.54L21.49,114.38a16,16,0,0,1,9.11-28.06l59.46-5.15,23.21-55.36a15.95,15.95,0,0,1,29.44,0h0L166,81.17l59.44,5.15a16,16,0,0,1,9.11,28.06Z"/></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-sm text-on-surface leading-relaxed">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @empty
                                <p class="text-center text-sm text-tertiary py-8">Belum ada ulasan untuk produk ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @if($relatedProducts->isNotEmpty())
                <div class="mt-20">
                    <h2 class="section-heading mb-8">Produk Serupa</h2>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $rp)
                            @include('components.product-card', ['product' => $rp])
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
