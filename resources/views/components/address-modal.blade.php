<style>
    .leaflet-container { z-index: 10 !important; font-family: inherit; }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<div x-data="{ 
    open: {{ $errors->any() ? 'true' : 'false' }},
    provinces: [], cities: [], districts: [], villages: [],
    selectedProvId: '', selectedCityId: '', selectedDistId: '', selectedVillId: '',
    lat: '{{ env('STORE_LATITUDE', '-7.048702868015205') }}', 
    lng: '{{ env('STORE_LONGITUDE', '110.05108520899812') }}',
    map: null, marker: null,
    loading: false, isSubmitting: false,
    async init() {
        this.fetchProvinces();
        $watch('open', value => {
            if (value && !this.map) {
                setTimeout(() => this.initMap(), 100);
            }
        });
    },
    async fetchProvinces() {
        this.loading = true;
        try {
            const r = await fetch('https://ibnux.github.io/data-indonesia/provinsi.json');
            this.provinces = await r.json();
        } catch(e) {}
        this.loading = false;
    },
    async fetchCities() {
        this.cities = []; this.districts = []; this.villages = [];
        this.selectedCityId = ''; this.selectedDistId = ''; this.selectedVillId = '';
        this.updateHidden();
        if(!this.selectedProvId) return;
        this.loading = true;
        try {
            const r = await fetch(`https://ibnux.github.io/data-indonesia/kabupaten/${this.selectedProvId}.json`);
            this.cities = await r.json();
        } catch(e) {}
        this.loading = false;
    },
    async fetchDistricts() {
        this.districts = []; this.villages = [];
        this.selectedDistId = ''; this.selectedVillId = '';
        this.updateHidden();
        if(!this.selectedCityId) return;
        this.loading = true;
        try {
            const r = await fetch(`https://ibnux.github.io/data-indonesia/kecamatan/${this.selectedCityId}.json`);
            this.districts = await r.json();
        } catch(e) {}
        this.loading = false;
    },
    async fetchVillages() {
        this.villages = [];
        this.selectedVillId = '';
        this.updateHidden();
        if(!this.selectedDistId) return;
        this.loading = true;
        try {
            const r = await fetch(`https://ibnux.github.io/data-indonesia/kelurahan/${this.selectedDistId}.json`);
            this.villages = await r.json();
        } catch(e) {}
        this.loading = false;
    },
    updateHidden() {
        const p = this.provinces.find(x => x.id == this.selectedProvId)?.nama || '';
        const c = this.cities.find(x => x.id == this.selectedCityId)?.nama || '';
        const d = this.districts.find(x => x.id == this.selectedDistId)?.nama || '';
        const v = this.villages.find(x => x.id == this.selectedVillId)?.nama || '';
        
        $refs.provinceInput.value = p;
        $refs.cityInput.value = c;
    },
    async detectLocation() {
        if (!navigator.geolocation) {
            alert('Browser Anda tidak mendukung geolokasi.');
            return;
        }
        this.loading = true;
        navigator.geolocation.getCurrentPosition(
            async (pos) => {
                try {
                    const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${pos.coords.latitude}&lon=${pos.coords.longitude}&accept-language=id`);
                    const data = await res.json();

                    this.lat = pos.coords.latitude;
                    this.lng = pos.coords.longitude;
                    if (this.map) {
                        this.map.setView([this.lat, this.lng], 15);
                        this.marker.setLatLng([this.lat, this.lng]);
                    }
                    $refs.latInput.value = this.lat;
                    $refs.lngInput.value = this.lng;

                    if (data.display_name) {
                        $refs.addressText.value = data.display_name;
                    }
                    if (data.address && data.address.postcode) {
                        $refs.postalInput.value = data.address.postcode;
                    }

                    if (data.address && data.address.state) {
                        let state = data.address.state.replace('Daerah Khusus Ibukota', 'DKI').replace('Daerah Istimewa', 'DI');
                        let prov = this.provinces.find(p => p.nama.toLowerCase().includes(state.toLowerCase()) || state.toLowerCase().includes(p.nama.toLowerCase()));
                        if (prov) {
                            this.selectedProvId = prov.id;
                            await this.fetchCities();

                            let cityName = data.address.city || data.address.county || data.address.town || data.address.municipality;
                            if (cityName) {
                                cityName = cityName.replace('Kabupaten', 'KAB.').replace('Kota', 'KOTA');
                                let city = this.cities.find(c => c.nama.toLowerCase().includes(cityName.toLowerCase()) || cityName.toLowerCase().includes(c.nama.toLowerCase()));
                                if (city) {
                                    this.selectedCityId = city.id;
                                    await this.fetchDistricts();

                                    let distName = data.address.city_district || data.address.suburb || data.address.municipality;
                                    if (distName) {
                                        distName = distName.replace('Kecamatan', '').trim();
                                        let dist = this.districts.find(d => d.nama.toLowerCase().includes(distName.toLowerCase()) || distName.toLowerCase().includes(d.nama.toLowerCase()));
                                        if (dist) {
                                            this.selectedDistId = dist.id;
                                            await this.fetchVillages();

                                            let villName = data.address.village || data.address.suburb || data.address.neighbourhood || data.address.hamlet;
                                            if (villName) {
                                                villName = villName.replace('Kelurahan', '').replace('Desa', '').trim();
                                                let vill = this.villages.find(v => v.nama.toLowerCase().includes(villName.toLowerCase()) || villName.toLowerCase().includes(v.nama.toLowerCase()));
                                                if (vill) {
                                                    this.selectedVillId = vill.id;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    this.updateHidden();
                } catch(e) {
                    console.error('Reverse geocode error:', e);
                }
                this.loading = false;
            },
            (err) => {
                this.loading = false;
                console.warn('Geolocation ditolak:', err.message);
                if (this.map) {
                    this.lat = '{{ env("STORE_LATITUDE", "-7.048702868015205") }}';
                    this.lng = '{{ env("STORE_LONGITUDE", "110.05108520899812") }}';
                    this.map.setView([this.lat, this.lng], 13);
                    this.marker.setLatLng([this.lat, this.lng]);
                }
            },
            { timeout: 10000, maximumAge: 60000 }
        );
    },
    initMap() {
        this.map = L.map($refs.mapContainer).setView([this.lat, this.lng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(this.map);
        
        this.marker = L.marker([this.lat, this.lng], {draggable: true}).addTo(this.map);
        
        this.marker.on('dragend', (e) => {
            const pos = e.target.getLatLng();
            this.lat = pos.lat;
            this.lng = pos.lng;
            $refs.latInput.value = this.lat;
            $refs.lngInput.value = this.lng;
        });

        this.map.on('click', (e) => {
            this.lat = e.latlng.lat;
            this.lng = e.latlng.lng;
            this.marker.setLatLng([this.lat, this.lng]);
            $refs.latInput.value = this.lat;
            $refs.lngInput.value = this.lng;
        });
        
        $refs.latInput.value = this.lat;
        $refs.lngInput.value = this.lng;
    }
}" @open-address-modal.window="open = true">
    {{-- Trigger Button (Optional, can be hidden if parent uses dispatch) --}}
    @if(isset($showTrigger) && $showTrigger)
        <button type="button" @click="open = true" class="btn-primary w-full">
            Tambah Alamat Baru
        </button>
    @endif

    {{-- Modal Overlay --}}
    <div x-show="open" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="open = false"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="open" class="relative bg-surface rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <form method="POST" action="{{ route('account.addresses.store') }}" @submit="isSubmitting = true">
                    @csrf
                    <div class="px-6 py-5 border-b border-surface">
                        <div class="flex items-center justify-between">
                            <h3 class="font-display font-semibold text-lg text-on-surface">Tambah Alamat Baru</h3>
                            <button type="button" @click="open = false" class="text-tertiary hover:text-on-surface">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        @if($errors->any())
                            <div class="mt-3 p-3 bg-error/10 text-error text-sm rounded-lg">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Label Alamat</label>
                                <input type="text" name="label" required placeholder="Cth: Rumah, Kantor" class="form-input">
                            </div>
                            <div>
                                <label class="form-label">Nama Penerima</label>
                                <input type="text" name="recipient_name" required value="{{ auth()->user()->name }}" class="form-input">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="form-label mb-0">Tandai Lokasi Peta</label>
                            </div>
                            <div x-ref="mapContainer" class="w-full h-48 rounded-lg border-2 border-neutral focus:border-primary z-10 mb-2"></div>
                            <p class="text-xs text-tertiary">Geser pin peta atau klik "Ambil Lokasi Saya" untuk titik koordinat pengiriman kurir yang akurat.</p>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="form-label mb-0">Alamat Lengkap</label>
                                <button type="button" @click="detectLocation" class="text-xs text-primary font-medium flex items-center hover:underline" :disabled="loading" :class="loading && 'opacity-50'">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span x-text="loading ? 'Mendeteksi...' : 'Ambil Lokasi Saya'"></span>
                                </button>
                            </div>
                            <textarea name="address" x-ref="addressText" required rows="3" placeholder="Nama Jalan, Gedung, No. Rumah..." class="form-input"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Provinsi <span x-show="loading" class="text-xs text-primary animate-pulse ml-2">Loading...</span></label>
                                <select x-model="selectedProvId" @change="fetchCities" class="form-input" required>
                                    <option value="">Pilih Provinsi...</option>
                                    <template x-for="p in provinces" :key="p.id">
                                        <option :value="p.id" x-text="p.nama"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Kota/Kabupaten</label>
                                <select x-model="selectedCityId" @change="fetchDistricts" class="form-input" :disabled="cities.length === 0" required>
                                    <option value="">Pilih Kota/Kab...</option>
                                    <template x-for="c in cities" :key="c.id">
                                        <option :value="c.id" x-text="c.nama"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Kecamatan</label>
                                <select x-model="selectedDistId" @change="fetchVillages" class="form-input" :disabled="districts.length === 0" required>
                                    <option value="">Pilih Kecamatan...</option>
                                    <template x-for="d in districts" :key="d.id">
                                        <option :value="d.id" x-text="d.nama"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Desa/Kelurahan</label>
                                <select x-model="selectedVillId" @change="updateHidden" class="form-input" :disabled="villages.length === 0" required>
                                    <option value="">Pilih Desa...</option>
                                    <template x-for="v in villages" :key="v.id">
                                        <option :value="v.id" x-text="v.nama"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" name="phone" required placeholder="0812..." class="form-input">
                            </div>
                            <div>
                                <label class="form-label">Kode Pos</label>
                                <input type="text" name="postal_code" x-ref="postalInput" required placeholder="Cth: 15220" class="form-input">
                            </div>
                        </div>

                        {{-- Hidden inputs to pass Province and City strings rather than IDs to the backend --}}
                        <input type="hidden" name="province" x-ref="provinceInput">
                        <input type="hidden" name="city" x-ref="cityInput">
                        <input type="hidden" name="latitude" x-ref="latInput">
                        <input type="hidden" name="longitude" x-ref="lngInput">
                    </div>

                    <div class="px-6 py-4 bg-base/50 flex justify-end gap-3 rounded-b-2xl">
                        <button type="button" @click="open = false" class="btn bg-surface text-on-surface hover:bg-neutral border border-neutral">Batal</button>
                        <button type="submit" class="btn-primary" :disabled="isSubmitting" :class="isSubmitting && 'opacity-50 cursor-not-allowed'">
                            <span x-show="!isSubmitting">Simpan Alamat</span>
                            <span x-show="isSubmitting" style="display: none;">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
