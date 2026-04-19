<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function getSnapToken(Order $order): string
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->address->recipient_name,
                'email' => $order->user->email,
                'phone' => $order->address->phone,
                'shipping_address' => [
                    'first_name' => $order->address->recipient_name,
                    'phone' => $order->address->phone,
                    'address' => $order->address->address,
                    'city' => $order->address->city,
                    'postal_code' => $order->address->postal_code,
                    'country_code' => 'IDN'
                ]
            ],
        ];

        return Snap::getSnapToken($params);
    }
}
