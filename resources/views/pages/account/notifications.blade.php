@extends('layouts.app')
@section('title', 'Notifikasi')
@section('content')
    <section class="py-8">
        <div class="container-main">
            <div class="grid lg:grid-cols-4 gap-8">
                @include('components.account-sidebar')

                <div class="lg:col-span-3">
                    <h1 class="font-display font-semibold text-h1 text-on-surface mb-6">Notifikasi</h1>

                    @forelse($notifications as $notif)
                        <div class="card p-5 mb-3 {{ !$notif->is_read ? 'border-l-4 border-l-primary' : '' }}">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-full {{ !$notif->is_read ? 'bg-primary/20' : 'bg-surface' }} flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 {{ !$notif->is_read ? 'text-primary' : 'text-tertiary' }}" fill="currentColor" viewBox="0 0 256 256"><path d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06Z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-on-surface">{{ $notif->title }}</p>
                                    <p class="text-sm text-tertiary mt-0.5">{{ $notif->message }}</p>
                                    <p class="text-xs text-tan mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div class="w-16 h-16 rounded-full bg-surface mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-7 h-7 text-primary" fill="currentColor" viewBox="0 0 256 256"><path d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06Z"/></svg>
                            </div>
                            <h3 class="font-display font-medium text-h3 text-on-surface">Tidak ada notifikasi</h3>
                            <p class="text-sm text-tertiary mt-2">Notifikasi baru akan muncul di sini</p>
                        </div>
                    @endforelse

                    @if($notifications->hasPages())
                        <div class="mt-6">{{ $notifications->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
