@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
    @php
        $cartItems = auth()->user()->cartItems()->with('variant.product.images')->get();
        $addresses = auth()->user()->addresses;
        $subtotal = $cartItems->sum(fn($i) => $i->subtotal);
        $itemCount = $cartItems->sum('quantity');
    @endphp

    <section class="py-8">
        <div class="container-main">
            <h1 class="font-display font-semibold text-h1 text-on-surface mb-8">Checkout</h1>

            @if($cartItems->isEmpty())
                <div class="text-center py-16">
                    <h3 class="font-display font-medium text-h3 text-on-surface">Keranjang kosong</h3>
                    <p class="text-sm text-tertiary mt-2 mb-6">Tambahkan produk terlebih dahulu</p>
                    <a href="{{ route('catalog.index') }}" class="btn-primary">Belanja Sekarang</a>
                </div>
            @else
                <form method="POST" action="{{ route('checkout.store') }}" x-data="{
                    shipping: 0,
                    voucher: '',
                    discount: 0,
                    voucher_error: '',
                    voucher_success: '',
                    checkingVoucher: false,
                    subtotal: {{ $subtotal }},
                    address_id: '{{ $addresses->where('is_default', true)->first()?->id ?? '' }}',
                    couriers: [],
                    selectedCourier: null,
                    loadingCouriers: false,
                    courierError: '',
                    get total() { return this.subtotal + this.shipping - this.discount; },
                    init() {
                        this.$watch('address_id', () => {
                            this.fetchCouriers();
                        });
                        if (this.address_id) this.fetchCouriers();
                    },
                    setCourier(price, index) {
                        this.shipping = price;
                        this.selectedCourier = index;
                    },
                    async fetchCouriers() {
                        if (!this.address_id) return;
                        this.loadingCouriers = true;
                        this.couriers = [];
                        this.courierError = '';
                        this.shipping = 0;
                        this.selectedCourier = null;

                        try {
                            const res = await fetch('{{ route('api.shipping.couriers') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                },
                                body: JSON.stringify({ address_id: this.address_id })
                            });
                            const data = await res.json();
                            if (data.success) {
                                this.couriers = data.couriers;
                                if (this.couriers.length > 0) {
                                    this.setCourier(this.couriers[0].price, 0);
                                } else {
                                    this.courierError = 'Tidak ada kurir yang bisa melayani alamat ini. Coba kurir berbeda atau periksa kode pos.';
                                }
                            } else {
                                this.couriers = [];
                                this.courierError = data.error || 'Tidak ada kurir yang tersedia untuk alamat ini.';
                            }
                        } catch (e) {
                            console.error('Gagal memuat kurir:', e);
                            this.courierError = 'Gagal menghubungi layanan pengiriman. Periksa koneksi internet Anda.';
                        } finally {
                            this.loadingCouriers = false;
                        }
                    },
                    async applyVoucher() {
                        this.voucher_error = '';
                        this.voucher_success = '';
                        if (!this.voucher) return;
                        
                        this.checkingVoucher = true;
                        try {
                            const res = await fetch('{{ route('api.voucher.check') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                },
                                body: JSON.stringify({ code: this.voucher, subtotal: this.subtotal })
                            });
                            const data = await res.json();
                            
                            if (data.valid) {
                                this.discount = data.discount;
                                this.voucher_success = data.message;
                            } else {
                                this.discount = 0;
                                this.voucher_error = data.message;
                            }
                        } catch (e) {
                            this.voucher_error = 'Gagal memeriksa voucher.';
                        } finally {
                            this.checkingVoucher = false;
                        }
                    },
                    deleteAddress(id) {
                        if (!confirm('Apakah Anda yakin ingin menghapus alamat ini?')) return;
                        const f = document.createElement('form');
                        f.method = 'POST';
                        f.action = '/akun/alamat/' + id;
                        
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = document.querySelector('meta[name=csrf-token]').content;
                        
                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';
                        
                        f.appendChild(csrf);
                        f.appendChild(method);
                        document.body.appendChild(f);
                        f.submit();
                    }
                }">
                    @csrf
                    <div class="grid lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-6">
                            {{-- Shipping Address --}}
                            <div class="card p-6">
                                <h2 class="font-display font-medium text-h3 text-on-surface mb-4">Alamat Pengiriman</h2>
                                @if($addresses->isNotEmpty())
                                    <div class="space-y-3">
                                        @foreach($addresses as $addr)
                                            <div class="relative p-4 border-[1.5px] rounded-card transition-colors {{ $addr->is_default ? 'border-primary bg-primary/5' : 'border-neutral hover:border-primary/50' }}">
                                                <label class="flex items-start gap-3 cursor-pointer w-full pr-8">
                                                    <input type="radio" name="address_id" x-model="address_id" value="{{ $addr->id }}" {{ $addr->is_default ? 'checked' : '' }} class="mt-1 text-primary focus:ring-primary">
                                                    <div>
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-sm font-medium text-on-surface">{{ $addr->label }}</span>
                                                            @if($addr->is_default) <span class="badge-gold text-[9px]">UTAMA</span> @endif
                                                        </div>
                                                        <p class="text-sm text-on-surface mt-0.5">{{ $addr->recipient_name }} · {{ $addr->phone }}</p>
                                                        <p class="text-sm text-tertiary mt-0.5">{{ $addr->full_formatted }}</p>
                                                    </div>
                                                </label>
                                                <button type="button" @click="deleteAddress({{ $addr->id }})" class="absolute top-4 right-4 text-error/70 hover:text-error transition-colors p-1 z-10" title="Hapus Alamat">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-surface rounded-card p-6 text-center">
                                        <p class="text-sm text-tertiary mb-3">Belum ada alamat tersimpan</p>
                                        <button type="button" @click="$dispatch('open-address-modal')" class="btn-primary py-2 px-4 text-xs">Tambah Alamat Baru</button>
                                    </div>
                                @endif
                                @if($addresses->isNotEmpty())
                                    <button type="button" @click="$dispatch('open-address-modal')" class="text-sm text-primary font-medium mt-4 hover:underline block w-full text-center">+ Tambah Alamat Lain</button>
                                @endif
                            </div>

                            {{-- Courier Selection --}}
                            <div class="card p-6" x-show="address_id" style="display: none;">
                                <h2 class="font-display font-medium text-h3 text-on-surface mb-4">Pengiriman</h2>
                                
                                <div x-show="loadingCouriers" class="py-8 text-center flex flex-col items-center">
                                    <div class="inline-block w-6 h-6 border-2 border-primary border-t-transparent rounded-full animate-spin mb-3"></div>
                                    <p class="text-sm text-tertiary">Mencari kurir terbaik...</p>
                                </div>
                                
                                <div x-show="!loadingCouriers && couriers.length === 0 && courierError" class="bg-error/10 text-error rounded-card p-4 text-sm" style="display: none;">
                                    <p x-text="courierError"></p>
                                    <p class="text-xs opacity-70 mt-1">Jika masalah berlanjut, coba hapus alamat lama dan buat baru dengan menandai titik peta secara manual.</p>
                                </div>
                                
                                <div x-show="!loadingCouriers && couriers.length > 0" class="space-y-3" style="display: none;">
                                    <template x-for="(courier, index) in couriers" :key="index">
                                        <label class="flex items-center justify-between p-4 border-[1.5px] rounded-card cursor-pointer transition-colors"
                                               :class="selectedCourier === index ? 'border-primary bg-primary/5' : 'border-neutral hover:border-primary/50'">
                                            <div class="flex items-start gap-3">
                                                <input type="radio" name="courier_index" :value="index" x-model.number="selectedCourier" @change="setCourier(courier.price, index)" class="mt-1 text-primary focus:ring-primary">
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-sm font-medium text-on-surface uppercase" x-text="courier.company + ' - ' + courier.type"></span>
                                                    </div>
                                                    <p class="text-xs text-tertiary mt-0.5" x-text="courier.duration"></p>
                                                </div>
                                            </div>
                                            <span class="font-medium text-sm whitespace-nowrap" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(courier.price)"></span>
                                        </label>
                                    </template>
                                </div>
                                
                                <!-- Hidden inputs to pass to Laravel backend -->
                                <template x-if="selectedCourier !== null">
                                    <div>
                                        <input type="hidden" name="courier_company" :value="couriers[selectedCourier].company">
                                        <input type="hidden" name="courier_type" :value="couriers[selectedCourier].type">
                                        <input type="hidden" name="shipping_cost" :value="couriers[selectedCourier].price">
                                    </div>
                                </template>
                            </div>

                            {{-- Order Items Preview --}}
                            <div class="card p-6">
                                <h2 class="font-display font-medium text-h3 text-on-surface mb-4">Pesanan Anda</h2>
                                <div class="space-y-3">
                                    @foreach($cartItems as $item)
                                        <div class="flex items-center gap-4">
                                            <img src="{{ $item->variant->product->primary_image_url }}"
                                                 class="w-14 h-14 rounded-lg object-cover bg-surface"
                                                 onerror="this.src='https://placehold.co/56x56/F0E8D8/6B4C35?text=Kopi'">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-on-surface truncate">{{ $item->variant->product->name }}</p>
                                                <p class="text-xs text-tertiary">{{ $item->variant->display_name }} × {{ $item->quantity }}</p>
                                            </div>
                                            <span class="text-sm font-medium">{{ $item->formatted_subtotal }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Notes --}}
                            <div class="card p-6">
                                <h2 class="font-display font-medium text-h3 text-on-surface mb-4">Catatan</h2>
                                <textarea name="notes" rows="3" class="form-input" placeholder="Catatan untuk pesanan ini (opsional)"></textarea>
                            </div>
                        </div>

                        {{-- Order Summary --}}
                        <div class="lg:col-span-1">
                            <div class="card p-6 lg:sticky lg:top-[88px]">
                                <h3 class="font-display font-medium text-h3 text-on-surface mb-4">Ringkasan</h3>

                                <div class="mb-5">
                                    <label class="form-label">KODE VOUCHER</label>
                                    <div class="flex gap-2 mt-1">
                                        <input type="text" name="voucher_code" x-model="voucher" class="form-input text-sm py-2 flex-1" placeholder="Masukkan kode">
                                        <button type="button" @click="applyVoucher" :disabled="checkingVoucher" class="btn-secondary btn-sm whitespace-nowrap min-w-[90px]" :class="checkingVoucher && 'opacity-50 cursor-not-allowed'">
                                            <span x-show="!checkingVoucher">Terapkan</span>
                                            <span x-show="checkingVoucher" style="display: none;">Proses...</span>
                                        </button>
                                    </div>
                                    <p x-show="voucher_error" x-text="voucher_error" class="text-xs text-error mt-2 font-medium" style="display: none;"></p>
                                    <p x-show="voucher_success" x-text="voucher_success" class="text-xs text-success mt-2 font-medium" style="display: none;"></p>
                                </div>

                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-tertiary">Subtotal ({{ $itemCount }} item)</span>
                                        <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-tertiary">Ongkos Kirim</span>
                                        <span x-show="loadingCouriers" class="flex items-center gap-1 text-tertiary text-xs">
                                            <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                            Menghitung...
                                        </span>
                                        <span x-show="!loadingCouriers && selectedCourier === null" class="text-xs text-tertiary italic" style="display: none;">— Pilih kurir dulu —</span>
                                        <span x-show="!loadingCouriers && selectedCourier !== null" class="font-medium text-tan" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(shipping)" style="display: none;"></span>
                                    </div>
                                    <template x-if="discount > 0">
                                        <div class="flex justify-between text-success">
                                            <span>Diskon Voucher</span>
                                            <span x-text="'-Rp ' + new Intl.NumberFormat('id-ID').format(discount)"></span>
                                        </div>
                                    </template>
                                    <div class="divider"></div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-on-surface">Total Bayar</span>
                                        <span class="font-display font-semibold text-2xl text-primary" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(total)">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <button type="submit" 
                                        class="btn-primary w-full mt-6 transition-opacity"
                                        :disabled="loadingCouriers || selectedCourier === null"
                                        :class="(loadingCouriers || selectedCourier === null) ? 'opacity-50 cursor-not-allowed' : ''"
                                >
                                    <span x-show="loadingCouriers">Menghitung ongkir...</span>
                                    <span x-show="!loadingCouriers && selectedCourier === null" style="display: none;">Pilih Kurir Pengiriman</span>
                                    <span x-show="!loadingCouriers && selectedCourier !== null" style="display: none;">Buat Pesanan</span>
                                </button>
                                <p class="text-xs text-tertiary text-center mt-3">
                                    Dengan memesan, Anda menyetujui syarat & ketentuan kami
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </section>

    @include('components.address-modal')
@endsection
