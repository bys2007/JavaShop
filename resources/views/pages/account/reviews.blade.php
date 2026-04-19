@extends('layouts.app')
@section('title', 'Ulasan Saya')
@section('content')
    <section class="py-8">
        <div class="container-main">
            <div class="grid lg:grid-cols-4 gap-8">
                @include('components.account-sidebar')

                <div class="lg:col-span-3">
                    <h1 class="font-display font-semibold text-h1 text-on-surface mb-6">Ulasan Saya</h1>
                    <div class="text-center py-16">
                        <div class="w-16 h-16 rounded-full bg-surface mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-7 h-7 text-primary" fill="currentColor" viewBox="0 0 256 256"><path d="M234.5,114.38l-45.1,39.36,13.51,58.6a16,16,0,0,1-23.84,17.34l-51.11-31-51,31a16,16,0,0,1-23.84-17.34l13.49-58.54L21.49,114.38a16,16,0,0,1,9.11-28.06l59.46-5.15,23.21-55.36a15.95,15.95,0,0,1,29.44,0h0L166,81.17l59.44,5.15a16,16,0,0,1,9.11,28.06Z"/></svg>
                        </div>
                        <h3 class="font-display font-medium text-h3 text-on-surface">Belum ada ulasan</h3>
                        <p class="text-sm text-tertiary mt-2 mb-6">Berikan ulasan setelah menyelesaikan pesanan</p>
                        <a href="{{ route('account.orders') }}" class="btn-primary">Lihat Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
