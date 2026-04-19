@extends('layouts.app')
@section('title', 'Beranda')
@section('is_landing', 'true')
@section('content')

    {{-- ═══ HERO SECTION (100vh, full-bleed) ═══ --}}
    <section class="relative h-screen flex overflow-hidden">
        {{-- Left: Photo Side (55%) --}}
        <div class="hidden lg:block relative w-[55%] h-full">
            <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1200&fit=crop"
                 alt="Espresso artisanal"
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-on-surface/10 via-transparent to-on-surface/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-on-surface/60 to-transparent"></div>

            {{-- Content overlay bottom-left --}}
            <div class="absolute bottom-[15%] left-10 xl:left-20 z-10">
                <span class="block font-body text-[11px] uppercase tracking-[0.16em] text-primary mb-4">
                    Specialty Coffee Indonesia
                </span>
                <h1 class="font-display font-semibold text-6xl xl:text-[72px] text-surface leading-[1.0]"
                    style="text-shadow: 0 2px 24px rgba(28,10,0,0.4)">
                    Setiap Tegukan,<br>Sebuah Karya.
                </h1>
                <p class="font-body text-base text-surface/70 max-w-[400px] mt-4 leading-relaxed">
                    Biji kopi pilihan petani Nusantara, kini di depan pintu Anda.
                </p>
            </div>
        </div>

        {{-- Right: Dark Panel (45%) --}}
        <div class="relative w-full lg:w-[45%] bg-on-surface flex items-center justify-center px-8"
             style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23B8924A\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">

            {{-- Mobile: also show bg photo --}}
            <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&fit=crop"
                 alt="Espresso"
                 class="absolute inset-0 w-full h-full object-cover opacity-20 lg:hidden">

            <div class="relative text-center max-w-[320px] mx-auto">
                {{-- Logo Mark --}}
                <img src="{{ asset('storage/Icon.png') }}" alt="JavaShop Logo" class="w-16 h-16 object-contain mx-auto mb-6 drop-shadow-lg">

                <p class="font-display font-medium italic text-[28px] text-surface leading-snug mb-8">
                    Mulai perjalanan kopi<br>terbaik Anda hari ini.
                </p>

                <div class="space-y-3 w-full">
                    <a href="{{ route('register') }}" class="btn-primary w-full text-center block">
                        Daftar Sekarang — Gratis
                    </a>
                    <a href="{{ route('catalog.index') }}" class="block w-full py-3.5 border-[1.5px] border-surface/30 text-surface text-sm font-medium uppercase tracking-wide rounded-button text-center hover:bg-surface/10 transition-all">
                        Jelajahi Produk
                    </a>
                </div>

                <p class="mt-6 text-sm text-tan">
                    ★★★★★ Dipercaya 10.000+ pecinta kopi
                </p>
            </div>
        </div>

        {{-- Bottom Strip --}}
        <div class="absolute bottom-0 left-0 right-0 h-14 bg-on-surface/70 backdrop-blur-sm z-10 hidden md:flex items-center justify-center">
            <div class="flex items-center divide-x divide-surface/20 text-[13px] text-surface/70">
                <span class="px-6 flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> 500+ Produk Pilihan</span>
                <span class="px-6 flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Dari 15 Daerah Asal</span>
                <span class="px-6 flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Pengiriman ke Seluruh Indonesia</span>
                <span class="px-6 flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Pembayaran Aman via Midtrans</span>
            </div>
        </div>
    </section>

    {{-- ═══ HOW IT WORKS ═══ --}}
    <section class="py-24 bg-base">
        <div class="container-main text-center">
            <span class="section-label" data-aos="fade-up">CARA KERJA</span>
            <h2 class="font-display font-semibold text-[44px] text-on-surface mt-3 mb-16" data-aos="fade-up" data-aos-delay="100">
                Belanja Kopi Premium<br>Cukup 3 Langkah
            </h2>

            <div class="grid md:grid-cols-3 gap-16 max-w-3xl mx-auto relative">
                {{-- Connecting Line --}}
                <div class="hidden md:block absolute top-7 left-[25%] right-[25%] h-px border-t-2 border-dashed border-primary/40"></div>

                @php
                    $steps = [
                        ['num' => '1', 'title' => 'Pilih & Pesan', 'desc' => 'Temukan kopi pilihan dari ratusan produk. Pilih ukuran dan tingkat gilingan sesuai kebutuhanmu.'],
                        ['num' => '2', 'title' => 'Bayar dengan Mudah', 'desc' => 'Pembayaran aman via Midtrans. Transfer bank, virtual account, GoPay, OVO, atau kartu kredit.'],
                        ['num' => '3', 'title' => 'Terima di Rumah', 'desc' => 'Dikirim via Biteship ke seluruh Indonesia. Estimasi 2–5 hari kerja dengan tracking real-time.'],
                    ];
                @endphp

                @foreach($steps as $i => $step)
                    <div class="relative" data-aos="fade-up" data-aos-delay="{{ ($i + 1) * 100 }}">
                        <div class="w-14 h-14 rounded-full border-[1.5px] border-primary flex items-center justify-center mx-auto relative bg-base z-10">
                            <span class="font-display font-semibold text-2xl text-primary">{{ $step['num'] }}</span>
                        </div>
                        <h3 class="font-body font-medium text-lg text-on-surface mt-5 mb-2">{{ $step['title'] }}</h3>
                        <p class="font-body text-sm text-tertiary leading-relaxed max-w-[240px] mx-auto">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-12" data-aos="fade-up" data-aos-delay="400">
                <a href="{{ route('register') }}" class="btn-primary">Mulai Sekarang</a>
            </div>
        </div>
    </section>

    {{-- ═══ FEATURED PRODUCTS ═══ --}}
    <section class="py-20 bg-surface">
        <div class="container-main">
            <div class="text-center mb-12">
                <span class="section-label" data-aos="fade-up">PRODUK UNGGULAN</span>
                <h2 class="font-display font-semibold text-[44px] text-on-surface mt-3" data-aos="fade-up" data-aos-delay="100">
                    Yang Sedang Disukai<br>Pecinta Kopi Indonesia
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    @include('components.product-card', ['product' => $product, 'showAddToCart' => true])
                @endforeach
            </div>

            <div class="text-center mt-10" data-aos="fade-up">
                <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-1 font-body font-medium text-sm text-primary hover:underline group">
                    Lihat Semua Produk
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ═══ ORIGIN STORY / BRAND ═══ --}}
    <section class="py-20 bg-on-surface" id="tentang-kami">
        <div class="container-main">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                {{-- Left: Photo Collage --}}
                <div class="relative" data-aos="fade-up">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=500&fit=crop"
                                 alt="Coffee farm" class="rounded-2xl w-full aspect-[3/4] object-cover border border-primary/20">
                            <img src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefda?w=500&fit=crop"
                                 alt="Coffee packaging" class="rounded-2xl w-full aspect-square object-cover border border-primary/20">
                        </div>
                        <div class="pt-8">
                            <img src="https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=500&fit=crop"
                                 alt="Roasting coffee" class="rounded-2xl w-full aspect-[3/5] object-cover border border-primary/20">
                        </div>
                    </div>
                </div>

                {{-- Right: Text --}}
                <div data-aos="fade-up" data-aos-delay="100">
                    <span class="section-label !text-left">TENTANG KAMI</span>
                    <h2 class="font-display font-semibold text-[44px] text-surface leading-[1.15] mt-3 mb-5">
                        Langsung dari<br>Petani Pilihan
                    </h2>
                    <p class="font-body text-base text-tan leading-[1.8] mb-8">
                        JavaShop hadir untuk menjembatani petani kopi lokal terbaik Indonesia dengan para pencinta kopi di seluruh penjuru negeri. Setiap produk yang kami hadirkan telah melalui seleksi ketat — dari ketinggian kebun, proses panen, hingga roasting.
                    </p>
                    <div class="flex gap-10">
                        <div>
                            <div class="font-display font-semibold text-4xl text-primary">15+</div>
                            <div class="font-body text-sm text-tan mt-1">Daerah Asal</div>
                        </div>
                        <div>
                            <div class="font-display font-semibold text-4xl text-primary">200+</div>
                            <div class="font-body text-sm text-tan mt-1">Petani Mitra</div>
                        </div>
                        <div>
                            <div class="font-display font-semibold text-4xl text-primary">2020</div>
                            <div class="font-body text-sm text-tan mt-1">Sejak</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ TESTIMONIALS ═══ --}}
    <section class="py-20 bg-base">
        <div class="container-main text-center">
            <h2 class="section-heading" data-aos="fade-up">Kata Mereka</h2>
            <p class="font-body text-base text-tertiary mt-3 mb-12" data-aos="fade-up" data-aos-delay="100">
                Lebih dari 10.000 pelanggan setia telah merasakan bedanya.
            </p>

            <div class="grid md:grid-cols-3 gap-6">
                @php
                    $testimonials = [
                        ['text' => 'Baru kali ini saya menemukan kopi yang aromanya konsisten dari bungkus pertama sampai terakhir. Arabika Gayonya luar biasa!', 'name' => 'Reza M.', 'city' => 'Jakarta'],
                        ['text' => 'Pengirimannya cepat, packagingnya rapi banget. Langsung jadi toko kopi online favorit saya.', 'name' => 'Siti N.', 'city' => 'Surabaya'],
                        ['text' => 'Suka banget pilihan gilingannya bisa disesuaikan. Cocok banget buat yang pakai pour over kayak saya.', 'name' => 'Dimas A.', 'city' => 'Bandung'],
                    ];
                @endphp

                @foreach($testimonials as $i => $t)
                    <div class="bg-surface rounded-2xl p-8 text-left relative" data-aos="fade-up" data-aos-delay="{{ ($i + 1) * 100 }}">
                        <span class="font-display font-semibold text-7xl text-primary/20 absolute top-4 left-6">"</span>
                        <p class="font-body italic text-base text-on-surface leading-[1.8] mt-8 mb-6">{{ $t['text'] }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-primary/20 flex items-center justify-center">
                                    <span class="font-body font-bold text-sm text-primary">{{ mb_substr($t['name'], 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-body font-medium text-sm text-on-surface">{{ $t['name'] }}</p>
                                    <p class="font-body text-xs text-tertiary">{{ $t['city'] }}</p>
                                </div>
                            </div>
                            <div class="flex gap-0.5 text-primary">
                                @for($s = 0; $s < 5; $s++)
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 256 256"><path d="M234.5,114.38l-45.1,39.36,13.51,58.6a16,16,0,0,1-23.84,17.34l-51.11-31-51,31a16,16,0,0,1-23.84-17.34l13.49-58.54L21.49,114.38a16,16,0,0,1,9.11-28.06l59.46-5.15,23.21-55.36a15.95,15.95,0,0,1,29.44,0h0L166,81.17l59.44,5.15a16,16,0,0,1,9.11,28.06Z"/></svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ CTA STRIP ═══ --}}
    <section class="py-16 bg-primary">
        <div class="container-main text-center max-w-xl mx-auto">
            <h2 class="font-display font-semibold text-5xl text-base leading-[1.1]" data-aos="fade-up">
                Mulai Perjalanan Kopi<br>Terbaik Anda
            </h2>
            <p class="font-body text-base text-base/80 mt-3 mb-8" data-aos="fade-up" data-aos-delay="100">
                Daftar gratis, tidak ada syarat minimum pembelian.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('register') }}" class="btn bg-on-surface text-surface hover:bg-dark-surface px-8 py-4">Daftar Sekarang</a>
                <a href="{{ route('login') }}" class="btn bg-transparent border-[1.5px] border-base text-base hover:bg-base/10 px-8 py-4">Masuk ke Akun</a>
            </div>
        </div>
    </section>

@endsection

