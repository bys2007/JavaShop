<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the authenticated customer's e-commerce dashboard (home).
     */
    public function index()
    {
        // 1. Fetch Active Banners
        $banners = Banner::active()->orderBy('sort_order')->get();

        // 2. Fetch Categories
        $categories = Category::active()
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('name')
            ->get();

        // 3. Fake "Featured" / "Best Sellers" (we take random active products for now)
        $featuredProducts = Product::with(['category', 'variants', 'images'])
            ->active()
            ->inRandomOrder()
            ->take(8)
            ->get();

        // 4. Latest Arrivals
        $latestProducts = Product::with(['category', 'variants', 'images'])
            ->active()
            ->latest()
            ->take(8)
            ->get();

        return view('pages.customer.home', compact('banners', 'categories', 'featuredProducts', 'latestProducts'));
    }
}
