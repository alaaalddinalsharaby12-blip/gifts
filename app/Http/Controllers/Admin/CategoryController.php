<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // =========================
    // 📌 عرض الأقسام
    // =========================
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    // =========================
    // 📌 صفحة الإضافة
    // =========================
    public function create()
    {
        return view('admin.categories.create');
    }

    // =========================
    // 📌 حفظ القسم
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255|unique:categories,name',
            'image'    => 'required|image|max:2048',
            'video'    => 'nullable|mimes:mp4,webm|max:10240', // 10MB
            'contents' => 'nullable|string|max:5000',
        ]);

        // رفع الصورة
        $validated['image'] = $request->file('image')->store('categories', 'public');

        // رفع الفيديو
        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم إضافة القسم بنجاح');
    }

    // =========================
    // 📌 صفحة التعديل
    // =========================
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // =========================
    // 📌 تحديث القسم
    // =========================
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255|unique:categories,name,' . $category->id,
            'image'    => 'nullable|image|max:2048',
            'video'    => 'nullable|mimes:mp4,webm|max:10240',
            'contents' => 'nullable|string|max:5000',
        ]);

        $data = [
            'name'     => $request->name,
            'contents' => $request->contents,
        ];

        // تحديث الصورة
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        // تحديث الفيديو
        if ($request->hasFile('video')) {
            if ($category->video) {
                Storage::disk('public')->delete($category->video);
            }
            $data['video'] = $request->file('video')->store('videos', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    // =========================
    // 📌 حذف القسم
    // =========================
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف قسم يحتوي على منتجات');
        }

        // حذف الملفات
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        if ($category->video) {
            Storage::disk('public')->delete($category->video);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }
}