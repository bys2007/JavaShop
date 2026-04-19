<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Initialize Midtrans settings
        new MidtransService();

        // Validate signature
        $serverKey    = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        $orderId      = $request->input('order_id');
        $statusCode   = $request->input('status_code');
        $grossAmount  = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans: Invalid signature for order ' . $orderId);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::warning('Midtrans: Order not found: ' . $orderId);
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transaction  = $request->input('transaction_status');
        $paymentType  = $request->input('payment_type');
        $fraudStatus  = $request->input('fraud_status');
        $transactionId = $request->input('transaction_id');

        // Upsert Payment record with correct field names
        $payment = Payment::firstOrCreate(
            ['order_id' => $order->id],
            [
                'method'                 => $paymentType,
                'status'                 => 'pending',
                'amount'                 => $order->total,
                'midtrans_transaction_id' => $transactionId,
                'midtrans_status'        => $transaction,
            ]
        );

        Log::info("Midtrans webhook: order={$orderId} transaction={$transaction} type={$paymentType}");

        if ($transaction === 'capture') {
            if ($fraudStatus === 'challenge') {
                $payment->update(['status' => 'pending', 'midtrans_status' => $transaction]);
            } else {
                $payment->update([
                    'status'                 => 'confirmed',
                    'midtrans_transaction_id' => $transactionId,
                    'midtrans_status'        => $transaction,
                    'method'                 => $paymentType,
                    'confirmed_at'           => now(),
                ]);
                $this->advanceOrder($order);
            }
        } elseif ($transaction === 'settlement') {
            $payment->update([
                'status'                 => 'confirmed',
                'midtrans_transaction_id' => $transactionId,
                'midtrans_status'        => $transaction,
                'method'                 => $paymentType,
                'confirmed_at'           => now(),
            ]);
            $this->advanceOrder($order);
        } elseif ($transaction === 'pending') {
            $payment->update([
                'status'                 => 'pending',
                'midtrans_transaction_id' => $transactionId,
                'midtrans_status'        => $transaction,
                'method'                 => $paymentType,
            ]);
        } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
            $payment->update([
                'status'          => 'rejected',
                'midtrans_status' => $transaction,
            ]);
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Called directly from frontend onSuccess callback as a localhost-friendly fallback.
     * Midtrans cannot reach 127.0.0.1, so we use this to update the order immediately.
     */
    public function finish(Request $request)
    {
        $orderId = $request->input('order_id');

        $order = Order::where('order_number', $orderId)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Upsert payment as confirmed
        $payment = Payment::firstOrCreate(
            ['order_id' => $order->id],
            [
                'method'  => $request->input('payment_type', 'midtrans'),
                'status'  => 'pending',
                'amount'  => $order->total,
            ]
        );

        $payment->update([
            'status'                  => 'confirmed',
            'method'                  => $request->input('payment_type', 'midtrans'),
            'midtrans_transaction_id' => $request->input('transaction_id'),
            'midtrans_status'         => $request->input('transaction_status', 'settlement'),
            'confirmed_at'            => now(),
        ]);

        $this->advanceOrder($order);

        return response()->json(['message' => 'OK']);
    }

    private function advanceOrder(Order $order): void
    {
        // Advance to 'processing' directly (skip pending_admin)
        if (in_array($order->status, ['pending_payment', 'pending_admin'])) {
            $order->update(['status' => 'processing']);
        }
    }
}
