<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$key = env('BITESHIP_API_KEY');
$originLat = env('STORE_LATITUDE', '-7.0487028');
$originLng = env('STORE_LONGITUDE', '110.0510852');
$destLat   = -7.04962090;
$destLng   = 110.05125558;

echo "Key: " . substr($key, 0, 30) . "...\n";
echo "Origin: $originLat, $originLng\n";
echo "Dest: $destLat, $destLng\n\n";

$response = Illuminate\Support\Facades\Http::withToken($key)->post('https://api.biteship.com/v1/rates/couriers', [
    'origin_latitude'      => floatval($originLat),
    'origin_longitude'     => floatval($originLng),
    'destination_latitude' => floatval($destLat),
    'destination_longitude'=> floatval($destLng),
    'couriers' => 'jne,jnt,sicepat,anteraja',
    'items' => [[
        'name'     => 'Test Item',
        'value'    => 100000,
        'weight'   => 1000,
        'quantity' => 1
    ]]
]);

echo "HTTP Status: " . $response->status() . "\n";
$json = $response->json();
echo "Response:\n";
print_r($json);
