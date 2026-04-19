@php
    $user = filament()->auth()->user();
@endphp

<style>
    /* Styling khusus agar sejajar dengan tinggi kotak sebelahnya */
    .custom-profile-widget { height: 100%; }
    .custom-profile-widget .fi-section { height: 100%; display: flex; flex-direction: column; justify-content: center; }
    .custom-profile-widget .fi-section-content-wrapper { flex: 1; display: flex; flex-direction: column; justify-content: center; height: 100%; }
    .custom-profile-widget .fi-section-content { flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 1.5rem !important; height: 100%; }
    
    /* Membesarkan ukuran Avatar dinamis sesuai tinggi grid */
    .custom-profile-widget .fi-avatar { width: auto !important; height: 100% !important; aspect-ratio: 1 / 1; object-fit: cover; }
</style>

<x-filament-widgets::widget class="custom-profile-widget">
    <x-filament::section class="h-full">
        <!-- Bento Grid: 3 Kolom, 2 Baris -->
        <div style="display: grid; grid-template-columns: auto 1fr auto; grid-template-rows: 1fr 1fr; gap: 0 1.5rem; width: 100%; height: 100%; align-items: center;">
            
            {{-- Kolom 1, Baris 1-2 (Rentang Penuh Vertikal): Avatar --}}
            <div style="grid-column: 1; grid-row: 1 / span 2; height: 100%; display: flex; align-items: center; justify-content: center;">
                <x-filament-panels::avatar.user
                    :user="$user"
                    loading="lazy"
                    class="rounded-full shadow-sm ring-2 ring-primary/20"
                />
            </div>

            {{-- Kolom 2, Baris 1: Selamat Datang --}}
            <div style="grid-column: 2; grid-row: 1; display: flex; align-items: flex-end; height: 100%; padding-bottom: 0.1rem;">
                <h2 class="truncate" style="font-size: 1.75rem; font-weight: 800 !important; color: #111827; line-height: 1;">
                    Selamat Datang
                </h2>
            </div>

            {{-- Kolom 2, Baris 2: Admin Javashop --}}
            <div style="grid-column: 2; grid-row: 2; display: flex; align-items: flex-start; height: 100%; padding-top: 0.1rem;">
                <p class="truncate" style="font-size: 1.1rem; font-weight: 400 !important; color: #6b7280; line-height: 1;">
                    {{ filament()->getUserName($user) }}
                </p>
            </div>

            {{-- Kolom 3, Baris 1-2 (Rentang Penuh Vertikal): Tombol Keluar --}}
            <div style="grid-column: 3; grid-row: 1 / span 2; display: flex; align-items: center; height: 100%;">
                <form action="{{ filament()->getLogoutUrl() }}" method="post" style="display: block;">
                    @csrf
                    <x-filament::button
                        color="gray"
                        icon="heroicon-o-arrow-right-start-on-rectangle"
                        tag="button"
                        type="submit"
                        size="lg"
                    >
                        Keluar
                    </x-filament::button>
                </form>
            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
