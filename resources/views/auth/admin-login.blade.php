@extends('layouts.auth')
@section('title', 'Admin Login')
@section('content')
<div class="min-h-screen flex items-center justify-center px-4"
     style="background-color: #140C05; background-image: radial-gradient(ellipse at 20% 50%, rgba(184, 146, 74, 0.06) 0%, transparent 50%), radial-gradient(ellipse at 80% 20%, rgba(184, 146, 74, 0.04) 0%, transparent 50%), radial-gradient(circle at 50% 80%, rgba(184, 146, 74, 0.03) 0%, transparent 40%);">

    <div class="w-full max-w-[420px]">
        {{-- Card --}}
        <div class="bg-[#1E1109] border border-[#3A2516] rounded-2xl p-8 shadow-2xl">
            {{-- Logo --}}
            <div class="flex items-center justify-center gap-2.5 mb-8">
                <img src="{{ asset('storage/Icon.png') }}" alt="JavaShop Logo" class="w-10 h-10 object-contain drop-shadow-md">
                <div>
                    <span class="font-['Cormorant_Garamond'] font-semibold text-2xl text-[#F0E8D8]">JavaShop</span>
                    <p class="text-[10px] text-[#6B4C35] font-['DM_Sans'] -mt-1 tracking-wider">ADMIN PANEL</p>
                </div>
            </div>

            <h1 class="font-['Cormorant_Garamond'] font-semibold text-2xl text-[#F0E8D8] text-center mb-1">Masuk Admin</h1>
            <p class="text-xs text-[#6B4C35] font-['DM_Sans'] text-center mb-6">Akses terbatas untuk administrator</p>

            {{-- Error --}}
            @if (session('error'))
                <div class="mb-4 bg-[#C0392B]/10 border border-[#C0392B]/20 rounded-lg px-4 py-3">
                    <p class="text-sm text-[#C0392B] font-['DM_Sans']">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Rate Limit Warning --}}
            @if (session('throttle'))
                <div class="mb-4 bg-[#E67E22]/10 border border-[#E67E22]/20 rounded-lg px-4 py-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#E67E22] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <p class="text-xs text-[#E67E22] font-['DM_Sans']">{{ session('throttle') }}</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[10px] font-bold uppercase tracking-wider text-[#6B4C35] font-['DM_Sans'] mb-1.5">EMAIL ADMIN</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 bg-[#2C1D14] border border-[#3A2516] rounded-lg text-sm text-[#F0E8D8] font-['DM_Sans'] placeholder:text-[#6B4C35]/60 focus:outline-none focus:border-[#B8924A] focus:ring-2 focus:ring-[#B8924A]/20 transition-all"
                           placeholder="admin@javashop.id">
                    @error('email') <p class="text-[#C0392B] text-xs mt-1 font-['DM_Sans']">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-[10px] font-bold uppercase tracking-wider text-[#6B4C35] font-['DM_Sans'] mb-1.5">KATA SANDI</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-3 bg-[#2C1D14] border border-[#3A2516] rounded-lg text-sm text-[#F0E8D8] font-['DM_Sans'] placeholder:text-[#6B4C35]/60 focus:outline-none focus:border-[#B8924A] focus:ring-2 focus:ring-[#B8924A]/20 transition-all"
                           placeholder="••••••••">
                    @error('password') <p class="text-[#C0392B] text-xs mt-1 font-['DM_Sans']">{{ $message }}</p> @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full py-3.5 bg-[#B8924A] hover:bg-[#9A7735] text-[#1C0A00] text-sm font-bold uppercase tracking-wider rounded-lg font-['DM_Sans'] transition-all duration-200">
                    Masuk ke Admin
                </button>
            </form>
        </div>

        {{-- Security Notice --}}
        <div class="mt-6 flex items-center justify-center gap-2 text-[10px] text-[#3A2516] font-['DM_Sans']">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Halaman ini hanya untuk administrator resmi JavaShop. Aktivitas login dicatat.
        </div>

        {{-- Back to site --}}
        <a href="{{ route('landing') }}" class="mt-4 flex items-center justify-center gap-1.5 text-xs text-[#6B4C35] hover:text-[#B8924A] font-['DM_Sans'] transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke JavaShop
        </a>
    </div>
</div>
@endsection
