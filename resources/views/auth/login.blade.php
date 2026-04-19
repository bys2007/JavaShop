@extends('layouts.auth')
@section('title', 'Masuk')
@section('content')
<div class="min-h-screen flex">
    {{-- LEFT: Photo Panel (55%) --}}
    <div class="hidden lg:flex relative w-[55%] bg-cover bg-center"
         style="background-image: url('https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=1400&fit=crop&q=80');">
        {{-- Dark Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#1C0A00]/80 via-[#1C0A00]/60 to-[#1C0A00]/80"></div>

        {{-- Logo --}}
        <a href="{{ route('landing') }}" class="absolute top-8 left-8 z-10 flex items-center gap-2">
            <img src="{{ asset('storage/Icon.png') }}" alt="JavaShop Logo" class="w-8 h-8 object-contain">
            <span class="font-['Cormorant_Garamond'] font-semibold text-2xl text-white">JavaShop</span>
        </a>

        {{-- Quote Overlay (bottom-left) --}}
        <div class="absolute bottom-12 left-10 right-10 z-10">
            <blockquote class="font-['Cormorant_Garamond'] text-3xl text-white/90 italic leading-snug">
                "Setiap cangkir kopi adalah sebuah perjalanan — dari tanah vulkanik Nusantara hingga ke hadapan Anda."
            </blockquote>
            <p class="mt-4 text-sm text-white/50 font-['DM_Sans']">— JavaShop, Artisan Coffee Roasters</p>
        </div>
    </div>

    {{-- RIGHT: Form Panel (45%) --}}
    <div class="w-full lg:w-[45%] bg-[var(--color-base)] flex items-center justify-center px-8 py-12">
        <div class="w-full max-w-[420px]">
            {{-- Mobile Logo --}}
            <div class="lg:hidden flex items-center gap-2 mb-10">
                <img src="{{ asset('storage/Icon.png') }}" alt="JavaShop Logo" class="w-8 h-8 object-contain">
                <span class="font-['Cormorant_Garamond'] font-semibold text-xl text-[var(--color-on-surface)]">JavaShop</span>
            </div>

            <h1 class="font-['Cormorant_Garamond'] font-semibold text-4xl text-[var(--color-on-surface)] mb-2">Selamat Datang</h1>
            <p class="text-sm text-[var(--color-tertiary)] font-['DM_Sans'] mb-8">Masuk ke akun Anda untuk melanjutkan</p>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-4 text-sm text-[var(--color-success)] bg-[var(--color-success)]/10 rounded-lg px-4 py-3 font-['DM_Sans']">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[10px] font-bold uppercase tracking-wider text-[var(--color-tertiary)] font-['DM_Sans'] mb-1.5">EMAIL</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="w-full px-4 py-3 bg-[var(--color-surface)] border border-[var(--color-neutral)] rounded-lg text-sm text-[var(--color-on-surface)] font-['DM_Sans'] placeholder:text-[var(--color-tertiary)]/50 focus:outline-none focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20 transition-all"
                           placeholder="nama@email.com">
                    @error('email')
                        <p class="text-[var(--color-error)] text-xs mt-1 font-['DM_Sans']">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-[10px] font-bold uppercase tracking-wider text-[var(--color-tertiary)] font-['DM_Sans'] mb-1.5">KATA SANDI</label>
                    <div class="relative" x-data="{ show: false }">
                        <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                               class="w-full px-4 py-3 pr-12 bg-[var(--color-surface)] border border-[var(--color-neutral)] rounded-lg text-sm text-[var(--color-on-surface)] font-['DM_Sans'] placeholder:text-[var(--color-tertiary)]/50 focus:outline-none focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20 transition-all"
                               placeholder="••••••••">
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--color-tertiary)] hover:text-[var(--color-on-surface)] transition-colors">
                            <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-[var(--color-error)] text-xs mt-1 font-['DM_Sans']">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember"
                               class="w-4 h-4 rounded border-[var(--color-neutral)] text-[var(--color-primary)] focus:ring-[var(--color-primary)] focus:ring-offset-0 transition-colors">
                        <span class="text-sm text-[var(--color-tertiary)] group-hover:text-[var(--color-on-surface)] font-['DM_Sans'] transition-colors">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-[var(--color-primary)] hover:text-[var(--color-primary-dim)] font-['DM_Sans'] font-medium transition-colors">
                        Lupa kata sandi?
                    </a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full py-3.5 bg-[var(--color-primary)] hover:bg-[var(--color-primary-dim)] text-white text-sm font-bold uppercase tracking-wider rounded-lg font-['DM_Sans'] transition-all duration-200 transform hover:translate-y-[-1px] active:translate-y-0">
                    Masuk
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 h-px bg-[var(--color-neutral)]"></div>
                <span class="text-xs text-[var(--color-tertiary)] font-['DM_Sans']">atau</span>
                <div class="flex-1 h-px bg-[var(--color-neutral)]"></div>
            </div>

            {{-- Google OAuth Placeholder --}}
            <button type="button" class="w-full py-3 border border-[var(--color-neutral)] rounded-lg flex items-center justify-center gap-3 text-sm text-[var(--color-on-surface)] font-['DM_Sans'] font-medium hover:bg-[var(--color-surface)] transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                Masuk dengan Google
            </button>

            {{-- Register Link --}}
            <p class="text-center mt-8 text-sm text-[var(--color-tertiary)] font-['DM_Sans']">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-[var(--color-primary)] hover:text-[var(--color-primary-dim)] font-medium transition-colors">Daftar sekarang</a>
            </p>

            {{-- Admin Login Link --}}
            <p class="text-center mt-4 text-sm text-[var(--color-tertiary)] font-['DM_Sans']">
                Atau masuk sebagai
                <a href="{{ route('admin.login') }}" class="text-[var(--color-on-surface)] hover:text-[var(--color-primary)] font-medium underline underline-offset-4 transition-colors">Admin & Pengelola</a>
            </p>
        </div>
    </div>
</div>
@endsection
