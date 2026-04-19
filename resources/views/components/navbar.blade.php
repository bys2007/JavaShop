{{-- JavaShop Navbar Component --}}
@php
    $isLanding = $isLanding ?? false;
    $cartCount = 0;
    if (auth()->check()) {
        $cartCount = auth()->user()->cartItems()->sum('quantity');
    }
    $wishlistCount = auth()->check() ? auth()->user()->wishlistProducts()->count() : 0;
@endphp

<nav x-data="{
        scrolled: false,
        mobileOpen: false,
        searchOpen: false,
        userMenu: false,
    }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 80 })"
    :class="{
        'bg-base/95 backdrop-blur-md shadow-navbar border-b border-neutral/50': scrolled || !{{ $isLanding ? 'true' : 'false' }},
        'bg-transparent': !scrolled && {{ $isLanding ? 'true' : 'false' }}
    }"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 h-[72px]"
    id="main-navbar">

    <div class="container-main h-full flex items-center justify-between">
        {{-- Logo --}}
        <a href="{{ route('landing') }}" class="flex items-center gap-2.5 shrink-0">
            <img src="{{ asset('storage/Icon.png') }}" alt="JavaShop Logo" class="w-8 h-8 object-contain">
            <div>
                <span class="font-display font-semibold text-[22px] leading-tight"
                      :class="scrolled || !{{ $isLanding ? 'true' : 'false' }} ? 'text-on-surface' : 'text-surface'">
                    JavaShop
                </span>
            </div>
        </a>

        {{-- Center Nav Links (Desktop) --}}
        <div class="hidden lg:flex items-center gap-8">
            @php
                $navLinks = [
                    ['label' => 'Beranda', 'href' => route('landing'), 'active' => request()->routeIs('landing') || request()->routeIs('home')],
                    ['label' => 'Produk', 'href' => route('catalog.index'), 'active' => request()->routeIs('catalog.*')],
                    ['label' => 'Tentang Kami', 'href' => '#tentang-kami', 'anchor' => 'tentang-kami', 'fallback' => '/#tentang-kami', 'active' => false],
                    ['label' => 'Kontak', 'href' => '#kontak', 'anchor' => 'kontak', 'fallback' => '/#kontak', 'active' => false],
                ];
            @endphp
            @foreach($navLinks as $link)
                @if(isset($link['anchor']))
                    <a href="{{ $link['fallback'] }}"
                       class="text-sm font-body transition-colors duration-200 {{ $link['active'] ? 'text-primary border-b-2 border-primary pb-1' : '' }}"
                       :class="scrolled || !{{ $isLanding ? 'true' : 'false' }} ? 'text-on-surface hover:text-primary' : 'text-surface/80 hover:text-surface'"
                       onclick="event.preventDefault(); var el=document.getElementById('{{ $link['anchor'] }}'); if(el){el.scrollIntoView({behavior:'smooth',block:'start'});}else{window.location.href='{{ $link['fallback'] }}';}">
                        {{ $link['label'] }}
                    </a>
                @else
                    <a href="{{ $link['href'] }}"
                       class="text-sm font-body transition-colors duration-200 {{ $link['active'] ? 'text-primary border-b-2 border-primary pb-1' : '' }}"
                       :class="scrolled || !{{ $isLanding ? 'true' : 'false' }} ? 'text-on-surface hover:text-primary' : 'text-surface/80 hover:text-surface'">
                        {{ $link['label'] }}
                    </a>
                @endif
            @endforeach
        </div>

        {{-- Right Icons --}}
        <div class="flex items-center gap-4">
            {{-- Search --}}
            <button @click="searchOpen = !searchOpen"
                    class="p-2 rounded-full transition-colors"
                    :class="scrolled || !{{ $isLanding ? 'true' : 'false' }} ? 'text-on-surface hover:text-primary' : 'text-surface hover:text-surface/80'">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 256 256"><path d="M229.66,218.34l-50.07-50.07a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.31ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z" fill="currentColor"/></svg>
            </button>

            {{-- Search Bar (inline expand) --}}
            <div x-show="searchOpen" x-transition x-cloak
                 class="absolute top-full left-0 right-0 bg-base shadow-card-hover border-b border-neutral p-4">
                <form action="{{ route('catalog.index') }}" method="GET" class="container-main">
                    <div class="relative max-w-2xl mx-auto">
                        <input type="text" name="q" placeholder="Cari produk kopi..."
                               class="form-input pl-12 py-3.5"
                               autofocus>
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-tan" fill="none" viewBox="0 0 256 256"><path d="M229.66,218.34l-50.07-50.07a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.31ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z" fill="currentColor"/></svg>
                    </div>
                </form>
            </div>

            {{-- Wishlist --}}
            <a href="{{ auth()->check() ? route('account.wishlist') : route('login', ['redirect' => '/akun/wishlist']) }}"
               class="relative p-2 rounded-full transition-colors hidden sm:block"
               :class="scrolled || !{{ $isLanding ? 'true' : 'false' }} ? 'text-on-surface hover:text-primary' : 'text-surface hover:text-surface/80'">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 256 256"><path d="M178,40c-20.65,0-38.73,8.88-50,23.89C116.73,48.88,98.65,40,78,40a62.07,62.07,0,0,0-62,62c0,70,103.79,126.66,108.21,129a8,8,0,0,0,7.58,0C136.21,228.66,240,172,240,102A62.07,62.07,0,0,0,178,40ZM128,214.8C109.74,204.16,32,155.69,32,102A46.06,46.06,0,0,1,78,56c19.45,0,35.78,10.36,42.6,27a8,8,0,0,0,14.8,0c6.82-16.67,23.15-27,42.6-27a46.06,46.06,0,0,1,46,46C224,155.61,146.24,204.15,128,214.8Z" fill="currentColor"/></svg>
                @if($wishlistCount > 0)
                    <span class="absolute -top-0.5 -right-0.5 bg-primary text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">{{ $wishlistCount }}</span>
                @endif
            </a>

            {{-- Cart --}}
            <a href="{{ route('cart.index') }}"
               class="relative p-2 rounded-full transition-colors"
               :class="scrolled || !{{ $isLanding ? 'true' : 'false' }} ? 'text-on-surface hover:text-primary' : 'text-surface hover:text-surface/80'">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 256 256"><path d="M222.14,58.87A8,8,0,0,0,216,56H54.68L49.79,29.14A16,16,0,0,0,34.05,16H16a8,8,0,0,0,0,16H34.05l32.51,172A24,24,0,0,0,88,232a28,28,0,1,0-22.48-11.37,24.2,24.2,0,0,0-3.67-6.32L58.17,192H188.1a16,16,0,0,0,15.74-13.14l25.4-114.4A8,8,0,0,0,222.14,58.87ZM98,204a12,12,0,1,1-12,12A12,12,0,0,1,98,204Zm92-16H61.07L51.79,72H209.21Zm-2-52a12,12,0,1,1,12-12A12,12,0,0,1,188,136Z" fill="currentColor"/></svg>
                <span x-text="$store.cart.count > 0 ? $store.cart.count : '{{ $cartCount }}'"
                      x-show="$store.cart.count > 0 || {{ $cartCount }} > 0"
                      class="absolute -top-0.5 -right-0.5 bg-primary text-white text-[10px] font-bold min-w-[16px] h-4 rounded-full flex items-center justify-center px-1"></span>
            </a>

            {{-- User / Auth --}}
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 p-1">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover border-2 border-neutral">
                    </button>
                    <div x-show="open" x-transition x-cloak
                         class="absolute right-0 top-full mt-2 w-52 bg-base rounded-card shadow-modal border border-neutral/50 py-2 z-50">
                        <div class="px-4 py-2 border-b border-neutral/50">
                            <p class="font-display font-semibold text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-caption text-tertiary">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('account.profile') }}" class="block px-4 py-2.5 text-sm text-on-surface hover:bg-surface transition-colors">Profil Saya</a>
                        <a href="{{ route('account.orders') }}" class="block px-4 py-2.5 text-sm text-on-surface hover:bg-surface transition-colors">Riwayat Pesanan</a>
                        @if(auth()->user()->isAdmin())
                            <a href="/admin" class="block px-4 py-2.5 text-sm text-primary hover:bg-surface transition-colors">Admin Panel</a>
                        @endif
                        <div class="border-t border-neutral/50 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-error hover:bg-surface transition-colors">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                   class="text-sm font-medium transition-colors hidden sm:block"
                   :class="scrolled || !{{ $isLanding ? 'true' : 'false' }} ? 'text-on-surface hover:text-primary' : 'text-surface hover:text-surface/80'">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="btn-primary btn-sm hidden sm:inline-flex">
                    Daftar
                </a>
            @endauth

            {{-- Mobile Hamburger --}}
            <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2"
                    :class="scrolled || !{{ $isLanding ? 'true' : 'false' }} ? 'text-on-surface' : 'text-surface'">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-transition x-cloak
         class="lg:hidden bg-base border-t border-neutral shadow-card-hover">
        <div class="container-main py-4 space-y-3">
            @foreach($navLinks as $link)
                @if(isset($link['anchor']))
                    <a href="{{ $link['fallback'] }}"
                       class="block py-2 text-sm {{ $link['active'] ? 'text-primary font-medium' : 'text-on-surface' }}"
                       onclick="event.preventDefault(); var mob=document.querySelector('[x-data]'); window.dispatchEvent(new CustomEvent('close-mobile-menu')); var el=document.getElementById('{{ $link['anchor'] }}'); if(el){setTimeout(function(){el.scrollIntoView({behavior:'smooth',block:'start'});},150);}else{window.location.href='{{ $link['fallback'] }}';}">
                        {{ $link['label'] }}
                    </a>
                @else
                    <a href="{{ $link['href'] }}" class="block py-2 text-sm {{ $link['active'] ? 'text-primary font-medium' : 'text-on-surface' }}">{{ $link['label'] }}</a>
                @endif
            @endforeach
            @guest
                <div class="pt-3 border-t border-neutral flex gap-3">
                    <a href="{{ route('login') }}" class="btn-secondary btn-sm flex-1">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary btn-sm flex-1">Daftar</a>
                </div>
            @endguest
        </div>
    </div>
</nav>

{{-- Spacer for fixed navbar --}}
@unless($isLanding ?? false)
    <div class="h-[72px]"></div>
@endunless
