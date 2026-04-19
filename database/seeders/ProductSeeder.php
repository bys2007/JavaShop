<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = ['100g', '250g', '500g'];
        $grinds = ['Biji Utuh', 'Coarse', 'Medium', 'Fine', 'Extra Fine'];

        $products = $this->getProducts();

        foreach ($products as $data) {
            $category = Category::where('slug', $data['category_slug'])->first();
            if (!$category) continue;

            $product = Product::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'is_active' => true,
                ]
            );

            // Create product image
            ProductImage::updateOrCreate(
                ['product_id' => $product->id, 'is_primary' => true],
                [
                    'image_url' => $data['image'],
                    'sort_order' => 0,
                ]
            );

            // Create variants: 3 sizes × 5 grind types = 15 per product
            $priceMultiplier = ['100g' => 1.0, '250g' => 2.3, '500g' => 4.2];

            foreach ($sizes as $size) {
                foreach ($grinds as $grind) {
                    $price = round($data['base_price'] * $priceMultiplier[$size], -3); // round to thousands
                    $sku = strtoupper(Str::slug($product->name, '-')) . '-' . $size . '-' . Str::slug($grind, '-');

                    ProductVariant::updateOrCreate(
                        ['sku' => $sku],
                        [
                            'product_id' => $product->id,
                            'size' => $size,
                            'grind_type' => $grind,
                            'price' => $price,
                            'stock' => rand(10, 100),
                        ]
                    );
                }
            }
        }
    }

    private function getProducts(): array
    {
        return [
            // ── ARABIKA (3) ──
            [
                'name' => 'Arabika Gayo Premium',
                'category_slug' => 'arabika',
                'base_price' => 85000,
                'image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=600&fit=crop',
                'description' => 'Biji kopi Arabika pilihan dari dataran tinggi Gayo, Aceh. Ditanam di ketinggian 1.400-1.700 mdpl dengan suhu sejuk sepanjang tahun. Memiliki body yang full dan clean cup finish. Tasting notes: coklat hitam, buah beri hutan, dan herbal segar dengan keasaman yang cerah.',
            ],
            [
                'name' => 'Arabika Toraja Sapan',
                'category_slug' => 'arabika',
                'base_price' => 95000,
                'image' => 'https://images.unsplash.com/photo-1587734195503-904fca47e0e9?w=600&fit=crop',
                'description' => 'Arabika premium dari wilayah Sapan, Tana Toraja, Sulawesi Selatan. Diproses secara wet-hull (Giling Basah) tradisional yang menghasilkan karakter unik kopi Toraja. Ketinggian 1.500 mdpl. Tasting notes: rempah-rempah hangat, karamel, tembakau manis, dan sedikit citrus di aftertaste.',
            ],
            [
                'name' => 'Arabika Flores Bajawa',
                'category_slug' => 'arabika',
                'base_price' => 90000,
                'image' => 'https://images.unsplash.com/photo-1611854779393-1b2da9d400fe?w=600&fit=crop',
                'description' => 'Kopi Arabika dari Bajawa, Flores, NTT. Ditanam di sekitar lereng vulkanik Gunung Inerie pada ketinggian 1.200-1.600 mdpl. Menghasilkan cita rasa yang kompleks dan khas. Tasting notes: coklat susu, kayu manis, madu, dan aroma floral yang lembut dengan body medium-full.',
            ],

            // ── ROBUSTA (3) ──
            [
                'name' => 'Robusta Lampung Klasik',
                'category_slug' => 'robusta',
                'base_price' => 55000,
                'image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefda?w=600&fit=crop',
                'description' => 'Robusta fine dari dataran Lampung, Sumatera. Kopi ini telah menjadi tulang punggung industri kopi Indonesia. Full body dengan crema tebal, cocok untuk lovers espresso sejati. Tasting notes: roasted nut, dark chocolate, earthy, dan sedikit woody dengan keasaman rendah.',
            ],
            [
                'name' => 'Robusta Temanggung Java',
                'category_slug' => 'robusta',
                'base_price' => 60000,
                'image' => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=600&fit=crop',
                'description' => 'Fine Robusta dari lereng Gunung Sindoro dan Sumbing, Temanggung, Jawa Tengah. Diproses natural (dijemur langsung) menghasilkan rasa yang lebih manis dan fruity dibanding Robusta pada umumnya. Tasting notes: karamel, kacang almond, dried fruit, dan sedikit spicy.',
            ],
            [
                'name' => 'Robusta Dampit Malang',
                'category_slug' => 'robusta',
                'base_price' => 50000,
                'image' => 'https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=600&fit=crop',
                'description' => 'Robusta premium dari Dampit, Malang, Jawa Timur. Tumbuh di ketinggian 600-800 mdpl dengan intensitas matahari yang optimal. Body tebal dan bold, sangat cocok untuk kopi tubruk dan espresso blend. Tasting notes: dark cocoa, roasted peanut, tobacco, dan aftertaste yang panjang.',
            ],

            // ── BLEND (2) ──
            [
                'name' => 'JavaShop House Blend',
                'category_slug' => 'blend',
                'base_price' => 75000,
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&fit=crop',
                'description' => 'Signature blend JavaShop — racikan khusus dari 60% Arabika Gayo dan 40% Robusta Lampung. Diracik untuk menghasilkan profil rasa seimbang yang cocok untuk segala metode seduh. Medium roast. Tasting notes: coklat, caramel, nutty, dan sedikit fruity dengan body medium dan keasaman lembut.',
            ],
            [
                'name' => 'Espresso Supreme Blend',
                'category_slug' => 'blend',
                'base_price' => 80000,
                'image' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=600&fit=crop',
                'description' => 'Blend premium untuk espresso sejati — 50% Arabika Toraja, 30% Robusta Temanggung, 20% Arabika Flores. Dark roast yang menghasilkan crema tebal dan kekayaan rasa yang luar biasa. Tasting notes: dark chocolate, burnt caramel, smoky, dan spice dengan body extra-full.',
            ],

            // ── SINGLE ORIGIN (2) ──
            [
                'name' => 'Papua Wamena Single Origin',
                'category_slug' => 'single-origin',
                'base_price' => 110000,
                'image' => 'https://images.unsplash.com/photo-1504630083234-14187a9df0f5?w=600&fit=crop',
                'description' => 'Kopi langka dari Lembah Baliem, Wamena, Papua. Ditanam secara organik oleh suku Dani pada ketinggian 1.500-1.800 mdpl. Satu-satunya kopi dari wilayah paling timur Indonesia. Tasting notes: buah tropis, lemon zest, madu hutan, dan floral tea-like dengan body light-medium dan keasaman yang cerah.',
            ],
            [
                'name' => 'Kintamani Bali Single Origin',
                'category_slug' => 'single-origin',
                'base_price' => 105000,
                'image' => 'https://images.unsplash.com/photo-1511920170033-f8396924c348?w=600&fit=crop',
                'description' => 'Arabika dari dataran tinggi Kintamani, Bali. Ditanam di antara pohon jeruk menggunakan sistem subak (irigasi tradisional Bali). Memiliki sertifikasi Geographical Indication. Ketinggian 1.200-1.600 mdpl. Tasting notes: citrus segar, brown sugar, vanilla, dan almond dengan keasaman tinggi dan body medium.',
            ],

            // ── DECAF (2) ──
            [
                'name' => 'Decaf Mountain Water Arabika',
                'category_slug' => 'decaf',
                'base_price' => 95000,
                'image' => 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=600&fit=crop',
                'description' => 'Arabika Gayo yang diproses decaf menggunakan metode Swiss Water Process — tanpa bahan kimia, 99.9% bebas kafein. Tetap mempertahankan karakter rasa asli kopi Gayo dengan profil yang lebih lembut. Cocok untuk penikmat kopi malam hari. Tasting notes: caramel, walnut, milk chocolate dengan keasaman rendah dan body medium.',
            ],
            [
                'name' => 'Decaf Sugarcane EA Process',
                'category_slug' => 'decaf',
                'base_price' => 100000,
                'image' => 'https://images.unsplash.com/photo-1498804103079-a6351b050096?w=600&fit=crop',
                'description' => 'Arabika Flores yang diproses decaf menggunakan metode Ethyl Acetate alami dari tebu. Proses ini lebih ramah lingkungan dan mempertahankan rasa manis alami kopi. Tasting notes: brown sugar, stone fruit, honey, dan sedikit floral. Cocok untuk yang ingin menikmati kopi tanpa kafein tapi tetap kaya rasa.',
            ],
        ];
    }
}
