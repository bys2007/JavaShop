@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')
    <section class="py-8">
        <div class="container-main">
            <div class="grid lg:grid-cols-4 gap-8">
                {{-- Sidebar --}}
                @include('components.account-sidebar')

                {{-- Main Content --}}
                <div class="lg:col-span-3">
                    <h1 class="font-display font-semibold text-h1 text-on-surface mb-6">Profil Saya</h1>

                    @if(session('success'))
                        <div class="bg-success/10 border border-success/20 rounded-card px-5 py-3 mb-6 text-success text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="card p-5 text-center">
                            <div class="font-display font-semibold text-3xl text-primary">{{ $orderCount }}</div>
                            <div class="text-caption text-tertiary mt-1">Pesanan</div>
                        </div>
                        <div class="card p-5 text-center">
                            <div class="font-display font-semibold text-3xl text-primary">{{ $reviewCount }}</div>
                            <div class="text-caption text-tertiary mt-1">Ulasan</div>
                        </div>
                        <div class="card p-5 text-center">
                            <div class="font-display font-semibold text-3xl text-primary">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                            <div class="text-caption text-tertiary mt-1">Total Belanja</div>
                        </div>
                    </div>

                    {{-- Profile Form --}}
                    <div class="card p-6">
                        <h2 class="font-display font-medium text-h3 text-on-surface mb-5">Informasi Pribadi</h2>
                        <form method="POST" action="{{ route('account.update-profile') }}" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label for="name" class="form-label">NAMA LENGKAP</label>
                                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="email" class="form-label">EMAIL</label>
                                    <input id="email" type="email" value="{{ $user->email }}" class="form-input bg-surface" disabled>
                                    <p class="text-xs text-tertiary mt-1">Email tidak dapat diubah</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label for="phone" class="form-label">NO. TELEPON</label>
                                    <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input" placeholder="0812-xxxx-xxxx">
                                </div>
                                <div>
                                    <label for="birth_date" class="form-label">TANGGAL LAHIR</label>
                                    <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}" class="form-input">
                                </div>
                            </div>

                            <div>
                                <label class="form-label">JENIS KELAMIN</label>
                                <div class="flex gap-4 mt-1">
                                    @foreach(['male' => 'Laki-laki', 'female' => 'Perempuan', 'other' => 'Lainnya'] as $val => $label)
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="gender" value="{{ $val }}" {{ old('gender', $user->gender) === $val ? 'checked' : '' }} class="text-primary focus:ring-primary">
                                            <span class="text-sm">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
