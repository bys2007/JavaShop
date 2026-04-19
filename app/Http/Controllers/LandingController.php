<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): \Illuminate\Http\RedirectResponse | View
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return redirect('/admin');
            }
            return redirect()->route('home');
        }

        $featuredProducts = Product::with(['category', 'variants', 'images'])
            ->active()
            ->take(4)
            ->get();

        $categories = Category::active()
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('name')
            ->get();

        return view('pages.landing', compact('featuredProducts', 'categories'));
    }
}
