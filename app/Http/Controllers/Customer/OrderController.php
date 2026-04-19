<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function success(): View
    {
        return view('pages.orders.success');
    }
}
