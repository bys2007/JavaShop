<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'JavaShop — Artisan Coffee Roasters. Kopi pilihan dari petani terbaik Indonesia.')">

    <title>@yield('title', 'Beranda') — JavaShop</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/Icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body bg-base text-on-surface antialiased" x-data="toast">

    {{-- Navbar --}}
    @include('components.navbar', ['isLanding' => View::yieldContent('is_landing') === 'true'])

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    {{-- Toast Notifications --}}
    <div class="fixed bottom-6 right-6 z-50 space-y-3" aria-live="polite" x-init="
        @if(session('success')) add('{{ addslashes(session('success')) }}', 'success'); @endif
        @if(session('error')) add('{{ addslashes(session('error')) }}', 'error'); @endif
    ">
        <template x-for="toast in toasts" :key="toast.id">
            <div class="toast-enter flex items-center gap-3 px-5 py-3.5 rounded-card shadow-modal max-w-sm"
                 :class="toast.type === 'success' ? 'bg-success text-white' : toast.type === 'error' ? 'bg-error text-white' : 'bg-surface text-on-surface border border-neutral'">
                <svg x-show="toast.type === 'success'" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <svg x-show="toast.type === 'error'" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                <span x-text="toast.message" class="text-sm font-medium"></span>
                <button @click="remove(toast.id)" class="ml-auto shrink-0 opacity-70 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </template>
    </div>

    @stack('scripts')
</body>
</html>
