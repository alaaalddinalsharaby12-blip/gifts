<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    // =========================
    // 📌 الصفحة الرئيسية
    // =========================
    public function index()
    {
        $categories = Category::withCount(['products' => function ($query) {
            $query->active();
        }])
            ->latest()
            ->get();

        $featuredProducts = Product::active()
            ->with(['category', 'images'])
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.home', compact('categories', 'featuredProducts'));
    }

    // =========================
    // 📌 عرض منتجات قسم معين
    // =========================
    public function showCategory($id)
    {
        $category = Category::findOrFail($id);

        $products = Product::active()
            ->where('category_id', $id)
            ->with(['images', 'category'])
            ->latest()
            ->paginate(12);

        return view('frontend.category-show', compact('category', 'products'));
    }
}