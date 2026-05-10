<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'product'])->latest()->paginate(20);
        
        // جلب جميع المواصفات مع خياراتها
        $allAttributes = \App\Models\Attribute::with('options')->get();
        $attributesMap = $allAttributes->pluck('name', 'id');
        
        return view('admin.orders.index', compact('orders', 'attributesMap'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'product']);

        // تحويل attributes إذا كان string
        if (is_string($order->attributes)) {
            $order->attributes = json_decode($order->attributes, true);
        }
        // 🔥 الحل هنا: يجب جلب الخريطة أيضاً في دالة العرض (show)
        $attributesMap = \App\Models\Attribute::pluck('name', 'id');
        
        return view('admin.orders.show', compact('order', 'attributesMap'));
    }

    // ✅ تحديث الحالة
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function destroy(Order $order)
    {
        if ($order->product && in_array($order->status, ['pending', 'processing'])) {
            $order->product->increment('stock', $order->quantity);
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'تم حذف الطلب بنجاح');
    }
}