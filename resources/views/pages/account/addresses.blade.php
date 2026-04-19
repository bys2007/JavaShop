@extends('layouts.app')
@section('title', 'Alamat Saya')
@section('content')
    <section class="py-8">
        <div class="container-main">
            <div class="grid lg:grid-cols-4 gap-8">
                @include('components.account-sidebar')

                <div class="lg:col-span-3">
                    <div class="flex items-center justify-between mb-6" x-data>
                        <h1 class="font-display font-semibold text-h1 text-on-surface">Alamat Saya</h1>
                        <button type="button" @click="$dispatch('open-address-modal')" class="btn-primary py-2 px-4 text-sm">+ Tambah Baru</button>
                    </div>

                    @forelse($addresses as $address)
                        <div class="card p-5 mb-4 {{ $address->is_primary ? 'border-l-4 border-l-primary' : '' }}">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="font-body font-bold text-sm text-on-surface">{{ $address->label }}</span>
                                        @if($address->is_primary)
                                            <span class="badge-gold text-[9px]">UTAMA</span>
                                        @endif
                                    </div>
                                    <p class="text-sm font-medium text-on-surface">{{ $address->recipient_name }}</p>
                                    <p class="text-sm text-tertiary mt-0.5">{{ $address->phone }}</p>
                                    <p class="text-sm text-tertiary mt-1">{{ $address->full_formatted }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div class="w-16 h-16 rounded-full bg-surface mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-7 h-7 text-primary" fill="currentColor" viewBox="0 0 256 256"><path d="M128,16a88.1,88.1,0,0,0-88,88c0,75.3,80,132.17,83.41,134.55a8,8,0,0,0,9.18,0C136,236.17,216,179.3,216,104A88.1,88.1,0,0,0,128,16Zm0,56a32,32,0,1,1-32,32A32,32,0,0,1,128,72Z"/></svg>
                            </div>
                            <h3 class="font-display font-medium text-h3 text-on-surface">Belum ada alamat</h3>
                            <p class="text-sm text-tertiary mt-2 mb-4">Mulai tambahkan alamat untuk kemudahan pengiriman</p>
                            <button type="button" @click="$dispatch('open-address-modal')" class="btn-primary py-2 px-4 text-sm">Tambah Alamat Baru</button>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    @include('components.address-modal')
@endsection
