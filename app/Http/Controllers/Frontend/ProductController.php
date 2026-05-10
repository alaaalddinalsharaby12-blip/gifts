<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // =========================
    // 📌 عرض كل المنتجات داخل قسم
    // =========================
    public function indexByCategory($id)
    {
        $category = Category::findOrFail($id);

        $products = Product::with(['images', 'category'])
            ->where('category_id', $id)
            ->latest()
            ->paginate(12);

        return view('category_show', compact('category', 'products'));
    }

    // =========================
    // 📌 صفحة تفاصيل المنتج (مهم للخصائص)
    // =========================
    public function show($id)
    {
        $product = Product::with([
            'images',
            'category',
            'attributes'
        ])->findOrFail($id);

        return view('products.show', compact('product'));
    }
}