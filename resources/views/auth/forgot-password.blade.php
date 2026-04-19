@extends('layouts.auth')
@section('title', 'Lupa Kata Sandi')
@section('content')
<div class="min-h-screen flex">
    {{-- LEFT: Photo Panel --}}
    <div class="hidden lg:flex relative w-[55%] bg-cover bg-center"
         style="background-image: url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1400&fit=crop&q=80');">
        <div class="absolute inset-0 bg-gradient-to-br from-[#1C0A00]/80 via-[#1C0A00]/60 to-[#1C0A00]/80"></div>
        <a href="{{ route('landing') }}" class="absolute top-8 left-8 z-10 flex items-center gap-2">
            <div class="w-7 h-7 bg-[var(--color-primary)] rounded-sm"></div>
            <span class="font-['Cormorant_Garamond'] font-semibold text-2xl text-white">JavaShop</span>
        </a>
        <div class="absolute bottom-12 left-10 right-10 z-10">
            <blockquote class="font-['Cormorant_Garamond'] text-3xl text-white/90 italic leading-snug">
                "Jangan khawatir, kami akan bantu Anda kembali menikmati kopi favorit."
            </blockquote>
        </div>
    </div>

    {{-- RIGHT: Form --}}
    <div class="w-full lg:w-[45%] bg-[var(--color-base)] flex items-center justify-center px-8 py-12">
        <div class="w-full max-w-[420px]">
            <div class="lg:hidden flex items-center gap-2 mb-10">
                <div class="w-6 h-6 bg-[var(--color-primary)] rounded-sm"></div>
                <span class="font-['Cormorant_Garamond'] font-semibold text-xl text-[var(--color-on-surface)]">JavaShop</span>
            </div>

            <h1 class="font-['Cormorant_Garamond'] font-semibold text-4xl text-[var(--color-on-surface)] mb-2">Lupa Kata Sandi?</h1>
            <p class="text-sm text-[var(--color-tertiary)] font-['DM_Sans'] mb-8">Masukkan email Anda dan kami akan mengirimkan tautan untuk mereset kata sandi.</p>

            {{-- Success Message --}}
            @if (session('status'))
                <div class="mb-6 bg-[var(--color-success)]/10 border border-[var(--color-success)]/20 rounded-lg px-5 py-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[var(--color-success)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <p class="text-sm text-[var(--color-success)] font-['DM_Sans']">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-[10px] font-bold uppercase tracking-wider text-[var(--color-tertiary)] font-['DM_Sans'] mb-1.5">EMAIL</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 bg-[var(--color-surface)] border border-[var(--color-neutral)] rounded-lg text-sm text-[var(--color-on-surface)] font-['DM_Sans'] placeholder:text-[var(--color-tertiary)]/50 focus:outline-none focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20 transition-all"
                           placeholder="nama@email.com">
                    @error('email') <p class="text-[var(--color-error)] text-xs mt-1 font-['DM_Sans']">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full py-3.5 bg-[var(--color-primary)] hover:bg-[var(--color-primary-dim)] text-white text-sm font-bold uppercase tracking-wider rounded-lg font-['DM_Sans'] transition-all duration-200 transform hover:translate-y-[-1px] active:translate-y-0">
                    Kirim Tautan Reset
                </button>
            </form>

            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 mt-8 text-sm text-[var(--color-tertiary)] hover:text-[var(--color-primary)] font-['DM_Sans'] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke halaman masuk
            </a>
        </div>
    </div>
</div>
@endsection
