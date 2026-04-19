<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherApiController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric'
        ]);

        $voucher = Voucher::where('code', $request->code)->first();

        if (!$voucher) {
            return response()->json(['valid' => false, 'message' => 'Kode voucher tidak valid.']);
        }

        $check = $voucher->isValid($request->subtotal);

        if (!$check['valid']) {
            return response()->json([
                'valid' => false, 
                'message' => $check['message']
            ]);
        }

        $discount = $voucher->calculateDiscount($request->subtotal);

        return response()->json([
            'valid' => true,
            'message' => 'Voucher berhasil diterapkan!',
            'discount' => $discount,
            'voucher_id' => $voucher->id
        ]);
    }
}
