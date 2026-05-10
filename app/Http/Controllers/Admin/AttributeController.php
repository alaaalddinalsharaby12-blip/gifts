<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Category;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with(['category', 'options'])
            ->latest()
            ->paginate(20);

        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.attributes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'type' => 'required|in:text,select,color',
            'category_id' => 'required|exists:categories,id',
            'options' => 'nullable|array',
            'options.*.value' => 'required_with:options|string|max:255',
            'options.*.label_ar' => 'nullable|string|max:255',
        ]);

        $attribute = Attribute::create([
            'name' => $request->name,
            'type' => $request->type,
            'category_id' => $request->category_id,
        ]);

        // ✅ إنشاء الخيارات مع label_ar
        if ($request->has('options') && in_array($request->type, ['select', 'color'])) {
            foreach ($request->options as $option) {
                if (!empty($option['value'])) {
                    $attribute->options()->create([
                        'value' => $option['value'],
                        'label_ar' => $option['label_ar'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.attributes.index')
            ->with('success', 'تم إضافة السمة بنجاح');
    }

    public function show(Attribute $attribute)
    {
        $attribute->load(['category', 'options', 'products']);
        return view('admin.attributes.show', compact('attribute'));
    }

    public function edit(Attribute $attribute)
    {
        $attribute->load('options');
        $categories = Category::all();
        return view('admin.attributes.edit', compact('attribute', 'categories'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'type' => 'required|in:text,select,color',
            'category_id' => 'required|exists:categories,id',
            'options' => 'nullable|array',
            'options.*.value' => 'required_with:options|string|max:255',
            'options.*.label_ar' => 'nullable|string|max:255',
        ]);

        $attribute->update([
            'name' => $request->name,
            'type' => $request->type,
            'category_id' => $request->category_id,
        ]);

        // ✅ حذف القديم وإنشاء جديد مع label_ar
        $attribute->options()->delete();

        if ($request->has('options') && in_array($request->type, ['select', 'color'])) {
            foreach ($request->options as $option) {
                if (!empty($option['value'])) {
                    $attribute->options()->create([
                        'value' => $option['value'],
                        'label_ar' => $option['label_ar'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.attributes.index')
            ->with('success', 'تم تحديث السمة بنجاح');
    }

    public function destroy(Attribute $attribute)
    {
        if ($attribute->products()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف سمة مرتبطة بمنتجات');
        }

        $attribute->options()->delete();
        $attribute->delete();

        return back()->with('success', 'تم حذف السمة بنجاح');
    }
}