<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'variants', 'images'])->active();

        // Search
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->kategori));
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->whereHas('variants', fn ($q) => $q->where('price', '>=', $request->min_price));
        }
        if ($request->filled('max_price')) {
            $query->whereHas('variants', fn ($q) => $q->where('price', '<=', $request->max_price));
        }

        // Sort
        $query->when($request->sort, fn ($q, $sort) => match ($sort) {
            'terbaru' => $q->latest(),
            'termurah' => $q->orderByRaw('(SELECT MIN(price) FROM product_variants WHERE product_variants.product_id = products.id) ASC'),
            'termahal' => $q->orderByRaw('(SELECT MIN(price) FROM product_variants WHERE product_variants.product_id = products.id) DESC'),
            'terlaris' => $q->withCount('reviews')->orderBy('reviews_count', 'desc'),
            'rating' => $q->latest(),
            default => $q->latest(),
        }, fn ($q) => $q->latest());

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::active()->withCount(['products' => fn ($q) => $q->active()])->orderBy('name')->get();

        return view('pages.catalog.index', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'variants', 'images', 'reviews.user']);

        $relatedProducts = Product::with(['category', 'variants', 'images'])
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('pages.catalog.show', compact('product', 'relatedProducts'));
    }
}
