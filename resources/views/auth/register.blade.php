@extends('layouts.auth')
@section('title', 'Daftar')
@section('content')
<div class="min-h-screen flex">
    {{-- LEFT: Form Panel (45%) --}}
    <div class="w-full lg:w-[45%] bg-[var(--color-base)] flex items-center justify-center px-8 py-12">
        <div class="w-full max-w-[420px]">
            {{-- Logo --}}
            <a href="{{ route('landing') }}" class="flex items-center gap-2 mb-10">
                <img src="{{ asset('storage/Icon.png') }}" alt="JavaShop Logo" class="w-8 h-8 object-contain">
                <span class="font-['Cormorant_Garamond'] font-semibold text-xl text-[var(--color-on-surface)]">JavaShop</span>
            </a>

            <h1 class="font-['Cormorant_Garamond'] font-semibold text-4xl text-[var(--color-on-surface)] mb-2">Buat Akun Baru</h1>
            <p class="text-sm text-[var(--color-tertiary)] font-['DM_Sans'] mb-8">Bergabung dan nikmati kopi terbaik Indonesia</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-4"
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
                      get strengthLabel() {
                          const labels = ['', 'Sangat Lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
                          return labels[this.strength] || '';
                      },
                      get strengthColor() {
                          const colors = ['', '#C0392B', '#E67E22', '#F1C40F', '#27AE60', '#27664A'];
                          return colors[this.strength] || '';
                      },
                      get strengthPercent() { return (this.strength / 5) * 100; }
                  }">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-[10px] font-bold uppercase tracking-wider text-[var(--color-tertiary)] font-['DM_Sans'] mb-1.5">NAMA LENGKAP</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
                           class="w-full px-4 py-3 bg-[var(--color-surface)] border border-[var(--color-neutral)] rounded-lg text-sm text-[var(--color-on-surface)] font-['DM_Sans'] placeholder:text-[var(--color-tertiary)]/50 focus:outline-none focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20 transition-all"
                           placeholder="Nama lengkap Anda">
                    @error('name') <p class="text-[var(--color-error)] text-xs mt-1 font-['DM_Sans']">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[10px] font-bold uppercase tracking-wider text-[var(--color-tertiary)] font-['DM_Sans'] mb-1.5">EMAIL</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           class="w-full px-4 py-3 bg-[var(--color-surface)] border border-[var(--color-neutral)] rounded-lg text-sm text-[var(--color-on-surface)] font-['DM_Sans'] placeholder:text-[var(--color-tertiary)]/50 focus:outline-none focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20 transition-all"
                           placeholder="nama@email.com">
                    @error('email') <p class="text-[var(--color-error)] text-xs mt-1 font-['DM_Sans']">{{ $message }}</p> @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-[10px] font-bold uppercase tracking-wider text-[var(--color-tertiary)] font-['DM_Sans'] mb-1.5">NO. TELEPON</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-3 bg-[var(--color-surface)] border border-[var(--color-neutral)] rounded-lg text-sm text-[var(--color-on-surface)] font-['DM_Sans'] placeholder:text-[var(--color-tertiary)]/50 focus:outline-none focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20 transition-all"
                           placeholder="0812-xxxx-xxxx">
                    @error('phone') <p class="text-[var(--color-error)] text-xs mt-1 font-['DM_Sans']">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-[10px] font-bold uppercase tracking-wider text-[var(--color-tertiary)] font-['DM_Sans'] mb-1.5">KATA SANDI</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               x-model="password"
                               class="w-full px-4 py-3 bg-[var(--color-surface)] border border-[var(--color-neutral)] rounded-lg text-sm text-[var(--color-on-surface)] font-['DM_Sans'] placeholder:text-[var(--color-tertiary)]/50 focus:outline-none focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20 transition-all"
                               placeholder="Minimal 8 karakter">
                    </div>
                    @error('password') <p class="text-[var(--color-error)] text-xs mt-1 font-['DM_Sans']">{{ $message }}</p> @enderror

                    {{-- Password Strength Bar --}}
                    <div x-show="password.length > 0" x-transition class="mt-2">
                        <div class="w-full h-1.5 bg-[var(--color-neutral)] rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-300"
                                 :style="'width: ' + strengthPercent + '%; background-color: ' + strengthColor"></div>
                        </div>
                        <p class="text-[10px] mt-1 font-['DM_Sans'] font-medium" :style="'color: ' + strengthColor" x-text="strengthLabel"></p>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-[10px] font-bold uppercase tracking-wider text-[var(--color-tertiary)] font-['DM_Sans'] mb-1.5">KONFIRMASI KATA SANDI</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full px-4 py-3 bg-[var(--color-surface)] border border-[var(--color-neutral)] rounded-lg text-sm text-[var(--color-on-surface)] font-['DM_Sans'] placeholder:text-[var(--color-tertiary)]/50 focus:outline-none focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20 transition-all"
                           placeholder="Ulangi kata sandi">
                    @error('password_confirmation') <p class="text-[var(--color-error)] text-xs mt-1 font-['DM_Sans']">{{ $message }}</p> @enderror
                </div>

                {{-- Terms --}}
                <div>
                    <label class="flex items-start gap-2.5 cursor-pointer group">
                        <input type="checkbox" name="terms" required
                               class="w-4 h-4 mt-0.5 rounded border-[var(--color-neutral)] text-[var(--color-primary)] focus:ring-[var(--color-primary)] focus:ring-offset-0">
                        <span class="text-xs text-[var(--color-tertiary)] font-['DM_Sans'] leading-relaxed">
                            Saya menyetujui <a href="/syarat" class="text-[var(--color-primary)] hover:underline" target="_blank">Syarat & Ketentuan</a> dan
                            <a href="/privasi" class="text-[var(--color-primary)] hover:underline" target="_blank">Kebijakan Privasi</a> JavaShop
                        </span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full py-3.5 bg-[var(--color-primary)] hover:bg-[var(--color-primary-dim)] text-white text-sm font-bold uppercase tracking-wider rounded-lg font-['DM_Sans'] transition-all duration-200 transform hover:translate-y-[-1px] active:translate-y-0">
                    Buat Akun
                </button>
            </form>

            {{-- Login Link --}}
            <p class="text-center mt-8 text-sm text-[var(--color-tertiary)] font-['DM_Sans']">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[var(--color-primary)] hover:text-[var(--color-primary-dim)] font-medium transition-colors">Masuk di sini</a>
            </p>
        </div>
    </div>

    {{-- RIGHT: Photo Panel (55%) --}}
    <div class="hidden lg:flex relative w-[55%] bg-cover bg-center"
         style="background-image: url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=1400&fit=crop&q=80');">
        <div class="absolute inset-0 bg-gradient-to-bl from-[#1C0A00]/70 via-[#1C0A00]/50 to-[#1C0A00]/80"></div>

        {{-- Benefits Overlay --}}
        <div class="absolute bottom-12 left-10 right-10 z-10">
            <h3 class="font-['Cormorant_Garamond'] text-2xl text-white/90 font-semibold mb-6">Keuntungan Bergabung</h3>
            <div class="space-y-4">
                @foreach([
                    ['icon' => '☕', 'text' => 'Akses ke 50+ kopi pilihan dari seluruh Nusantara'],
                    ['icon' => '🎁', 'text' => 'Voucher selamat datang untuk pembelian pertama'],
                    ['icon' => '🚚', 'text' => 'Tracking pesanan real-time ke seluruh Indonesia'],
                    ['icon' => '⭐', 'text' => 'Poin reward dan penawaran eksklusif member'],
                ] as $benefit)
                    <div class="flex items-center gap-3">
                        <span class="text-xl">{{ $benefit['icon'] }}</span>
                        <span class="text-sm text-white/80 font-['DM_Sans']">{{ $benefit['text'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
