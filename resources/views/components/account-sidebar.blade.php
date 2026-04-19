{{-- Account Sidebar Component --}}
@php
    $menuItems = [
        ['route' => 'account.profile', 'label' => 'Profil Saya', 'icon' => 'M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24ZM74.08,197.5a64,64,0,0,1,107.84,0,87.83,87.83,0,0,1-107.84,0ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120Zm97.76,66.41a79.66,79.66,0,0,0-36.06-28.75,48,48,0,1,0-59.4,0,79.66,79.66,0,0,0-36.06,28.75,88,88,0,1,1,131.52,0Z'],
        ['route' => 'account.orders', 'label' => 'Riwayat Pesanan', 'icon' => 'M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40ZM40,56H216V96H40Zm0,144V112H216v88Z'],
        ['route' => 'account.wishlist', 'label' => 'Wishlist', 'icon' => 'M178,40c-20.65,0-38.73,8.88-50,23.89C116.73,48.88,98.65,40,78,40a62.07,62.07,0,0,0-62,62c0,70,103.79,126.66,108.21,129a8,8,0,0,0,7.58,0C136.21,228.66,240,172,240,102A62.07,62.07,0,0,0,178,40Z'],
        ['route' => 'account.addresses', 'label' => 'Alamat', 'icon' => 'M128,16a88.1,88.1,0,0,0-88,88c0,75.3,80,132.17,83.41,134.55a8,8,0,0,0,9.18,0C136,236.17,216,179.3,216,104A88.1,88.1,0,0,0,128,16Zm0,56a32,32,0,1,1-32,32A32,32,0,0,1,128,72Z'],
        ['route' => 'account.notifications', 'label' => 'Notifikasi', 'icon' => 'M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06Z'],
        ['route' => 'account.change-password', 'label' => 'Ubah Kata Sandi', 'icon' => 'M208,80H176V56a48,48,0,0,0-96,0V80H48A16,16,0,0,0,32,96V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V96A16,16,0,0,0,208,80ZM96,56a32,32,0,0,1,64,0V80H96Z'],
    ];
@endphp

<aside class="lg:col-span-1">
    <div class="card p-4 lg:sticky lg:top-[88px]">
        {{-- User Info --}}
        <div class="flex items-center gap-3 p-3 mb-3">
            <img src="{{ auth()->user()->avatar_url }}" alt="" class="w-12 h-12 rounded-full object-cover border-2 border-neutral">
            <div class="min-w-0">
                <p class="font-display font-medium text-sm text-on-surface truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-tertiary truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <div class="divider mb-2"></div>

        {{-- Menu --}}
        <nav class="space-y-0.5">
            @foreach($menuItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors {{ request()->routeIs($item['route']) ? 'bg-primary/10 text-primary font-medium' : 'text-tertiary hover:bg-surface hover:text-on-surface' }}">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 256 256"><path d="{{ $item['icon'] }}"/></svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="divider my-2"></div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-error hover:bg-error/5 transition-colors w-full">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 256 256"><path d="M112,216a8,8,0,0,1-8,8H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h56a8,8,0,0,1,0,16H48V208h56A8,8,0,0,1,112,216Zm109.66-93.66-40-40a8,8,0,0,0-11.32,11.32L196.69,120H104a8,8,0,0,0,0,16h92.69l-26.35,26.34a8,8,0,0,0,11.32,11.32l40-40A8,8,0,0,0,221.66,122.34Z"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>
