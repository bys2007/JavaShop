@extends('layouts.app')
@section('title', 'Pesanan Berhasil')
@section('content')
    <section class="py-16">
        <div class="container-main max-w-lg mx-auto text-center">
            <div class="card p-10">
                {{-- Success Icon --}}
                <div class="w-20 h-20 rounded-full bg-success/10 mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-10 h-10 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <h1 class="font-display font-semibold text-4xl text-on-surface">Pesanan Berhasil!</h1>
                <p class="text-tertiary mt-3 mb-8">
                    Terima kasih telah berbelanja di JavaShop. Pesanan Anda sedang diproses.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('account.orders') }}" class="btn-primary">Lihat Pesanan Saya</a>
                    <a href="{{ route('catalog.index') }}" class="btn-secondary">Lanjut Belanja</a>
                </div>
            </div>
        </div>
    </section>
@endsection
