{{-- JavaShop Footer Component --}}
<footer class="bg-dark-base text-surface/70 pt-16 pb-8" id="kontak">
    <div class="container-main">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            {{-- Brand Column --}}
            <div id="tentang-kami">
                <div class="flex items-center gap-2.5 mb-4">
                    <img src="{{ asset('storage/Icon.png') }}" alt="JavaShop Logo" class="w-8 h-8 object-contain">
                    <span class="font-display font-semibold text-2xl text-surface">JavaShop</span>
                </div>
                <p class="font-display italic text-base text-surface/60 mb-6">
                    "Setiap cangkir, sebuah cerita."
                </p>
                <div class="flex items-center gap-4">
                    {{-- Instagram --}}
                    <a href="https://instagram.com/javashop" target="_blank" rel="noopener" class="text-surface/50 hover:text-primary transition-colors" aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 256 256"><path d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160ZM176,24H80A56.06,56.06,0,0,0,24,80v96a56.06,56.06,0,0,0,56,56h96a56.06,56.06,0,0,0,56-56V80A56.06,56.06,0,0,0,176,24Zm40,152a40,40,0,0,1-40,40H80a40,40,0,0,1-40-40V80A40,40,0,0,1,80,40h96a40,40,0,0,1,40,40ZM192,76a12,12,0,1,1-12-12A12,12,0,0,1,192,76Z"/></svg>
                    </a>
                    {{-- TikTok --}}
                    <a href="https://tiktok.com/@javashop" target="_blank" rel="noopener" class="text-surface/50 hover:text-primary transition-colors" aria-label="TikTok">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 256 256"><path d="M224,72a48.05,48.05,0,0,1-48-48,8,8,0,0,0-8-8H128a8,8,0,0,0-8,8V156a20,20,0,1,1-28.57-18.08A8,8,0,0,0,96,130.69V88a8,8,0,0,0-9.4-7.88C50.91,86.48,24,117.48,24,156a76,76,0,0,0,152,0V116.29A103.25,103.25,0,0,0,224,128a8,8,0,0,0,8-8V80A8,8,0,0,0,224,72Z"/></svg>
                    </a>
                    {{-- WhatsApp --}}
                    <a href="https://wa.me/6281200000000" target="_blank" rel="noopener" class="text-surface/50 hover:text-primary transition-colors" aria-label="WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 256 256"><path d="M187.58,144.84l-32-16a8,8,0,0,0-8,.5l-14.69,9.8a40.55,40.55,0,0,1-16-16l9.8-14.69a8,8,0,0,0,.5-8l-16-32A8,8,0,0,0,104,64a40,40,0,0,0-40,40,88.1,88.1,0,0,0,88,88,40,40,0,0,0,40-40A8,8,0,0,0,187.58,144.84ZM152,176a72.08,72.08,0,0,1-72-72A24,24,0,0,1,99.29,80.46l11.48,23L101,118a8,8,0,0,0-.73,7.51,56.47,56.47,0,0,0,30.15,30.15A8,8,0,0,0,138,155l14.61-9.74,23,11.48A24,24,0,0,1,152,176ZM128,24A104,104,0,0,0,36.18,176.88L24.83,210.93a16,16,0,0,0,20.24,20.24l34.05-11.35A104,104,0,1,0,128,24Zm0,192a87.87,87.87,0,0,1-44.06-11.81,8,8,0,0,0-6.54-.67L40,216,52.47,178.6a8,8,0,0,0-.66-6.54A88,88,0,1,1,128,216Z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Navigation --}}
            <div>
                <h4 class="font-body font-bold text-label uppercase tracking-widest text-surface/40 mb-5">Navigasi</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('landing') }}" class="text-sm text-surface/60 hover:text-primary transition-colors">Beranda</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="text-sm text-surface/60 hover:text-primary transition-colors">Produk</a></li>
                    <li><a href="/#tentang-kami" class="text-sm text-surface/60 hover:text-primary transition-colors">Tentang Kami</a></li>
                </ul>
            </div>

            {{-- Help --}}
            <div>
                <h4 class="font-body font-bold text-label uppercase tracking-widest text-surface/40 mb-5">Bantuan</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-sm text-surface/60 hover:text-primary transition-colors">FAQ</a></li>
                    <li><a href="#" class="text-sm text-surface/60 hover:text-primary transition-colors">Cara Pemesanan</a></li>
                    <li><a href="#" class="text-sm text-surface/60 hover:text-primary transition-colors">Kebijakan Pengembalian</a></li>
                    <li><a href="#" class="text-sm text-surface/60 hover:text-primary transition-colors">Hubungi Kami</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-body font-bold text-label uppercase tracking-widest text-surface/40 mb-5">Kontak</h4>
                <ul class="space-y-3 text-sm text-surface/60">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary shrink-0" fill="currentColor" viewBox="0 0 256 256"><path d="M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48ZM203.43,64,128,133.15,52.57,64ZM216,192H40V74.19l82.59,75.71a8,8,0,0,0,10.82,0L216,74.19V192Z"/></svg>
                        hello@javashop.id
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary shrink-0" fill="currentColor" viewBox="0 0 256 256"><path d="M187.58,144.84l-32-16a8,8,0,0,0-8,.5l-14.69,9.8a40.55,40.55,0,0,1-16-16l9.8-14.69a8,8,0,0,0,.5-8l-16-32A8,8,0,0,0,104,64a40,40,0,0,0-40,40,88.1,88.1,0,0,0,88,88,40,40,0,0,0,40-40A8,8,0,0,0,187.58,144.84Z"/></svg>
                        0812-xxxx-xxxx
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-primary mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 256 256"><path d="M128,40a96,96,0,1,0,96,96A96.11,96.11,0,0,0,128,40Zm0,176a80,80,0,1,1,80-80A80.09,80.09,0,0,1,128,216Zm45.66-109.66a8,8,0,0,1,0,11.32l-40,40a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L128,140.69l34.34-34.35A8,8,0,0,1,173.66,106.34Z"/></svg>
                        <span>Sen - Sab<br>08.00 – 17.00 WIB</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-dark-border pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-[10px] font-body uppercase tracking-wide text-surface/30">
                © {{ date('Y') }} JavaShop Digital Atelier. All rights reserved.
            </p>
            <div class="flex items-center gap-4 text-[10px] font-body uppercase tracking-wide text-surface/30">
                <span>Pembayaran aman via <span class="text-primary/60">Midtrans</span></span>
                <span>·</span>
                <span>Pengiriman oleh <span class="text-primary/60">Biteship</span></span>
            </div>
        </div>
    </div>
</footer>
