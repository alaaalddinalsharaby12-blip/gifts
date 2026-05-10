<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images'])
            ->latest()
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'stock'       => 'required|integer|min:0',
            'images.*'    => 'nullable|image|max:2048',
        ]);

        $product = Product::create([
            'name'        => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'stock'       => $request->stock,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        // رفع الصور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $img) {
                $path = $img->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $path,
                    'type'       => $request->types[$i] ?? null
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        
        $product->update($validated);

        // رفع صور جديدة
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image' => $path,
                    'type' => 'gallery',
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'تم تحديث المنتج');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function destroy(Product $product)
    {
        // حذف الصور من السيرفر
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image);
        }

        $product->delete();

        return back()->with('success', 'تم حذف المنتج بنجاح');
    }

    public function deleteImage(ProductImage $image)
    {
        // حذف الملف من التخزين
        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }
        
        // حذف السجل من قاعدة البيانات
        $image->delete();
        
        return back()->with('success', 'تم حذف الصورة بنجاح');
    }
}