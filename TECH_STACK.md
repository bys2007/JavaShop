# ☕ JavaShop E-Commerce - Tech Stack & Architecture

Dokumen ini merangkum seluruh teknologi, kerangka kerja (framework), pustaka (library), serta antarmuka pemrograman aplikasi (API) pihak ketiga yang digunakan untuk membangun sistem JavaShop e-commerce.

---

## 🏗️ Core & Backend Framework
*   **PHP 8.3**: Bahasa pemrograman utama di sisi server yang memberikan performa dan keamanan tinggi yang modern.
*   **Laravel 13.0**: Framework PHP MVC utama untuk merancang alur logika backend, *routing*, ORM (Model), dan lapisan pelindung keamanan situs (CSRF, Middleware).
*   **MySQL**: Sistem manajemen basis data (DBMS) relasional utama untuk menyimpan semua entitas mulai dari Pengguna, Pesanan, Produk, dan lain-lain.
*   **Filament Admin v3**: Digunakan sebangai fondasi utama portal Admin (Dashboard). Membangun antarmuka pengelolaan tabel inventaris (`OrderResource`, `ProductResource`, dll) secara dinamis tanpa banyak menulis baris kode UI secara manual.
*   **Laravel Breeze**: Menyediakan struktur fondasi cepat (*scaffolding*) untuk sistem otentikasi (Auth) seperti fitur Registrasi, Login, dan Lupa Sandi.

## 🎨 Frontend & UI/UX Ekosistem
Sistem toko *(front-end)* murni menggunakan pendekatan server-driven yang modern tanpa harus membangun *Single Page Application* murni, yang menjadikan performa SEO lebih superior.

*   **Blade Templating Engine**: Mesin *render* HTML bawaan Laravel untuk membangun kerangka *views* UI dengan *layouting* modular (komponen).
*   **Tailwind CSS (v3)**: Framework CSS secara utilitas (*utility-first*) mumpuni untuk merancang gaya desain antarmuka *(styling)* yang cepat, *responsive* dan modern. 
    *   *Plugin Tambahan*: `@tailwindcss/forms` untuk merapikan form bawaan.
*   **Alpine.js (v3)**: *Framework* JavaScript super ringan yang disisipkan langsung ke dalam HTML. Sangat krusial dalam menangani perilaku interaktif di halaman seperti **Dropdown**, **Keranjang Belanja (*Cart Modal*)**, **Tombol Ubah Kuantitas**, dan **Modal Review Ulasan**.
*   **Vite**: Sistem *bundling* front-end super cepat (*next-generation*) untuk mengkompilasi file CSS dan memuat JavaScript.
*   **AOS (Animate On Scroll)**: Library animasi elemen UI ketika kursor di-skrol ke bawah pada suatu blok desain tertentu (membuat situs terasa lebih premium).
*   **Anime.js**: Engine animasi berbasis JavaScript yang ringan tapi bertenaga untuk menyisipkan *micro-interactions* tingkat lanjut.

## 🔗 Integrasi API Pihak Ketiga (External Service)

Ekosistem *JavaShop* bergantung pada layanan eksternal untuk otomasi fitur-fitur sentral di e-commerce dunia nyata:

#### 1. Midtrans API (Payment Gateway)
*   **Modul Resmi**: `midtrans/midtrans-php`
*   **Tujuan**: Digunakan untuk mengakomodasi segala bentuk sistem pembayaran non-tunai (Digital).
*   **Teknik Utama**: Menggunakan **Midtrans SNAP** yaitu modul pop-up pintar dari sisi browser (frontend) sebagai terminal pembayaran untuk E-Wallet (GoPay dll), Transfer Bank (VA), atau QRIS. Selain itu, sistem menggunakan *background* **Webhook Controller** (Server-to-Server) guna memperbarui tanda lunas atau batal secara otomatis tanpa menunggu *refresh browser* milik pelanggan.

#### 2. Biteship API (Aggregator Kurir)
*   **Tujuan**: Menjawab tantangan sistem pengecekan ongkos logistik dinamis. Melakukan komparasi harga jasa ekspedisi seperti JNE, J&T, Sicepat secara *real-time*.
*   **Logika Fallback Khusus**: Pada sistem JavaShop, algoritma didesain tahan banting (*fault-tolerant*). Jika layanan Biteship *down* atau saldo API habis/error, sistem otomatis menggantinya menggunakan rumus jarak matematika kordinat asli **Haversine Formula**, dan memberlakukan tarif flat logistik lokal buatan mandiri berdasarkan jarak (*radius*) km dari koordinat kedai JavaShop ke koordinat pelanggan.

#### 3. Nominatim API (OpenStreetMap)
*   **Tujuan**: Pustaka geocoding (Pemetaan Resolusi Tinggi).
*   **Aksi Utama**: Digunakan ketika pengguna memilih untuk mendeteksi alamat asal melalui sensor Lokasi (*Geolocation browser/GPS*). API ini menangkap data Lintang Bujur (*Latitude & Longitude*) dan menerjemahkannya ke sebuah nama kelurahan, jalan, kecamatan secara *reverse-geocoding*.

## 🛠️ Modul Infrastruktur Pendukung Lainnya
*   **Guzzle HTTP Client**: Digunakan untuk melakukan panggilan REST API dari dalam backend Laravel ke API Eksternal (seperti Biteship).
*   **Blade Icons**: Komponen penyisipan ikon berformat berkas grafis vektor *SVG* dinamis ke dalam kode HTML.
*   **Artisan Commands**: Pemrograman konsol internal untuk eksekusi antrean asinkron *(background Queue)*, seperti fitur baru pengiriman email otomatis saat order *Shipped*, serta pembersihan memori sementara.
