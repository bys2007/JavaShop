<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\UserAddress;

class ShippingApiController extends Controller
{
    public function getCouriers(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:user_addresses,id'
        ]);

        $address = UserAddress::where('id', $validated['address_id'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Get cart items
        $cartItems = auth()->user()->cartItems()->with('variant.product')->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'error' => 'Keranjang kosong'], 400);
        }

        $subtotal = $cartItems->sum('subtotal');
        $weight   = 1000; // static 1kg

        $biteshipKey = env('BITESHIP_API_KEY');
        $originLat   = floatval(env('STORE_LATITUDE',  '-7.0487028'));
        $originLng   = floatval(env('STORE_LONGITUDE', '110.0510852'));

        // Auto-geocode if address has no coordinates
        if (empty($address->latitude) || empty($address->longitude)) {
            $geoQuery = urlencode("{$address->address}, {$address->city}, {$address->province} {$address->postal_code}, Indonesia");
            try {
                $geoRes  = Http::withHeaders(['User-Agent' => 'JavaShop/1.0', 'Accept-Language' => 'id'])
                    ->timeout(8)
                    ->get("https://nominatim.openstreetmap.org/search?format=json&limit=1&q={$geoQuery}");
                $geoData = $geoRes->json();
                if (!empty($geoData) && isset($geoData[0]['lat'])) {
                    $address->latitude  = $geoData[0]['lat'];
                    $address->longitude = $geoData[0]['lon'];
                    $address->saveQuietly();
                }
            } catch (\Exception $e) {
                // continue to fallback
            }
        }

        $destLat = floatval($address->latitude);
        $destLng = floatval($address->longitude);

        // Try Biteship first
        if ($biteshipKey && $destLat && $destLng) {
            try {
                $response = Http::withToken($biteshipKey)
                    ->timeout(12)
                    ->post('https://api.biteship.com/v1/rates/couriers', [
                        'origin_latitude'       => $originLat,
                        'origin_longitude'      => $originLng,
                        'destination_latitude'  => $destLat,
                        'destination_longitude' => $destLng,
                        'couriers' => 'jne,jnt,sicepat,anteraja,ninja',
                        'items'    => [[
                            'name'     => 'Pesanan JavaShop',
                            'value'    => $subtotal,
                            'weight'   => $weight,
                            'quantity' => 1,
                        ]],
                    ]);

                $json = $response->json();

                if ($response->successful() && !empty($json['pricing'])) {
                    $couriers = [];
                    foreach ($json['pricing'] as $price) {
                        if (($price['price'] ?? 0) > 0) {
                            $couriers[] = [
                                'company'              => $price['company'],
                                'type'                 => $price['type'],
                                'courier_name'         => $price['courier_name'],
                                'courier_service_name' => $price['courier_service_name'],
                                'duration'             => $price['duration'],
                                'price'                => $price['price'],
                            ];
                        }
                    }
                    if (count($couriers) > 0) {
                        return response()->json(['success' => true, 'couriers' => $couriers]);
                    }
                }
                // Fall-through to fallback
            } catch (\Exception $e) {
                // Fall-through to fallback
            }
        }

        // Fallback: distance-based estimates
        $couriers = $this->getFallbackRates($originLat, $originLng, $destLat ?: $originLat, $destLng ?: $originLng, $weight);

        return response()->json(['success' => true, 'couriers' => $couriers]);
    }

    private function getFallbackRates(float $oLat, float $oLng, float $dLat, float $dLng, int $weightGrams): array
    {
        $km = $this->haversineKm($oLat, $oLng, $dLat, $dLng);

        if ($km <= 20) {
            $base = 8000;  $tier = '1-2 hari';
        } elseif ($km <= 100) {
            $base = 14000; $tier = '1-2 hari';
        } elseif ($km <= 500) {
            $base = 20000; $tier = '2-3 hari';
        } elseif ($km <= 1500) {
            $base = 30000; $tier = '3-5 hari';
        } else {
            $base = 50000; $tier = '5-7 hari';
        }

        $extraKg   = max(0, ceil(($weightGrams - 1000) / 500));
        $surcharge = $extraKg * 3000;

        return [
            [
                'company'              => 'jne',
                'type'                 => 'REG',
                'courier_name'         => 'JNE',
                'courier_service_name' => 'JNE Reguler',
                'duration'             => $tier,
                'price'                => $base + $surcharge,
            ],
            [
                'company'              => 'jnt',
                'type'                 => 'EZ',
                'courier_name'         => 'J&T Express',
                'courier_service_name' => 'J&T Express',
                'duration'             => $tier,
                'price'                => intval(($base + $surcharge) * 0.95),
            ],
            [
                'company'              => 'sicepat',
                'type'                 => 'BEST',
                'courier_name'         => 'SiCepat',
                'courier_service_name' => 'SiCepat BEST',
                'duration'             => $tier,
                'price'                => intval(($base + $surcharge) * 0.9),
            ],
        ];
    }

    private function haversineKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R    = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a    = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
