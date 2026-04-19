@extends('layouts.auth')
@section('title', 'Reset Kata Sandi')
@section('content')
<div class="min-h-screen flex">
    {{-- LEFT: Photo Panel --}}
    <div class="hidden lg:flex relative w-[55%] bg-cover bg-center"
         style="background-image: url('https://images.unsplash.com/photo-1514432324607-a09d9b4aefda?w=1400&fit=crop&q=80');">
        <div class="absolute inset-0 bg-gradient-to-br from-[#1C0A00]/80 via-[#1C0A00]/60 to-[#1C0A00]/80"></div>
        <a href="{{ route('landing') }}" class="absolute top-8 left-8 z-10 flex items-center gap-2">
            <div class="w-7 h-7 bg-[var(--color-primary)] rounded-sm"></div>
            <span class="font-['Cormorant_Garamond'] font-semibold text-2xl text-white">JavaShop</span>
        </a>
    </div>

    {{-- RIGHT: Form --}}
    <div class="w-full lg:w-[45%] bg-[var(--color-base)] flex items-center justify-center px-8 py-12">
        <div class="w-full max-w-[420px]"
             x-data="{
                 password: '',
                 get strength() {
                     let s = 0;
                     if (this.password.length >= 8) s++;
                     if (this.password.length >= 12) s++;
                     if (/[A-Z]/.test(this.password)) s++;
                     if (/[0-9]/.test(this.password)) s++;
                     if (/[^A-Za-z0-9]/.test(this.password)) s++;
                     return s;
                 },
                 get strengthLabel() { return ['', 'Sangat Lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'][this.strength] || ''; },
                 get strengthColor() { return ['', '#C0392B', '#E67E22', '#F1C40F', '#27AE60', '#27664A'][this.strength] || ''; },
                 get strengthPercent() { return (this.strength / 5) * 100; }
             }">
            <h1 class="font-['Cormorant_Garamond'] font-semibold text-4xl text-[var(--color-on-surface)] mb-2">Reset Kata Sandi</h1>
            <p class="text-sm text-[var(--color-tertiary)] font-['DM_Sans'] mb-8">Buat kata sandi baru untuk akun Anda.</p>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-[10px] font-bold uppercase tracking-wider text-[var(--color-tertiary)] font-['DM_Sans'] mb-1.5">KATA SANDI BARU</label>
                    <input id="password" type="password" name="password" required x-model="password"
                           class="w-full px-4 py-3 bg-[var(--color-surface)] border border-[var(--color-neutral)] rounded-lg text-sm text-[var(--color-on-surface)] font-['DM_Sans'] placeholder:text-[var(--color-tertiary)]/50 focus:outline-none focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20 transition-all"
                           placeholder="Minimal 8 karakter">
                    @error('password') <p class="text-[var(--color-error)] text-xs mt-1 font-['DM_Sans']">{{ $message }}</p> @enderror
                    <div x-show="password.length > 0" x-transition class="mt-2">
                        <div class="w-full h-1.5 bg-[var(--color-neutral)] rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-300" :style="'width: ' + strengthPercent + '%; background-color: ' + strengthColor"></div>
                        </div>
                        <p class="text-[10px] mt-1 font-['DM_Sans'] font-medium" :style="'color: ' + strengthColor" x-text="strengthLabel"></p>
                    </div>
                </div>

                {{-- Confirm --}}
                <div>
                    <label for="password_confirmation" class="block text-[10px] font-bold uppercase tracking-wider text-[var(--color-tertiary)] font-['DM_Sans'] mb-1.5">KONFIRMASI KATA SANDI</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 bg-[var(--color-surface)] border border-[var(--color-neutral)] rounded-lg text-sm text-[var(--color-on-surface)] font-['DM_Sans'] placeholder:text-[var(--color-tertiary)]/50 focus:outline-none focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20 transition-all"
                           placeholder="Ulangi kata sandi baru">
                </div>

                <button type="submit" class="w-full py-3.5 bg-[var(--color-primary)] hover:bg-[var(--color-primary-dim)] text-white text-sm font-bold uppercase tracking-wider rounded-lg font-['DM_Sans'] transition-all duration-200">
                    Reset Kata Sandi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
