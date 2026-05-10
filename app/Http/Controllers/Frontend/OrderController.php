<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $orders = Order::with(['user', 'product'])->latest()->paginate(10);
        } else {
            $orders = Order::where('user_id', auth()->id())->with('product')->latest()->paginate(10);
        }

        $attributesMap = Attribute::pluck('name', 'id')->toArray();

        return view('orders.index', compact('orders', 'attributesMap'));
    }

    public function create(Request $request, $productId)
    {
        $product = Product::with(['images', 'category'])->findOrFail($productId);

        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'المنتج غير متوفر حالياً');
        }

        $attributes = Attribute::where('category_id', $product->category_id)
            ->with('options')
            ->get();

        return view('orders.create', compact('product', 'attributes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:100',
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable|string|max:255',
            'notes'      => 'nullable|string|max:2000',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية المطلوبة غير متوفرة. المخزون: ' . $product->stock
            ], 422);
        }

        // ✅ تحويل القيم إلى أسماء عربية قبل التخزين
        $attributes = [];
        if (!empty($validated['attributes'])) {
            foreach ($validated['attributes'] as $attrId => $value) {
                if ($value !== null && $value !== '') {
                    // جلب الاسم العربي للون/الخيار
                    $option = AttributeOption::where('attribute_id', $attrId)
                        ->where('value', $value)
                        ->first();
                    
                    // ✅ تخزين الاسم العربي بدلاً من الكود
                    $attributes[$attrId] = $option?->label_ar ?? $value;
                }
            }
        }

        $order = Order::create([
            'user_id'       => auth()->id(),
            'product_id'    => $product->id,
            'product_name'  => $product->name,
            'quantity'      => $validated['quantity'],
            'attributes'    => !empty($attributes) ? json_encode($attributes) : null,
            'status'        => 'pending',
            'notes'         => $validated['notes'] ?? null,
            'data'          => null,
        ]);

        $product->decrement('stock', $validated['quantity']);

        $this->sendDirectWhatsApp($order, $product);

        return response()->json([
            'success' => true,
            'message' => 'تم استلام طلبك بنجاح!'
        ]);
    }

    private function sendDirectWhatsApp(Order $order, Product $product)
    {
        $user = auth()->user();

        $msg = "🔔 *طلب جديد* \n";
        $msg .= "--------------------------\n";
        $msg .= "📦 المنتج: {$product->name}\n";
        $msg .= "🔢 الكمية: {$order->quantity}\n";
        $msg .= "👤 العميل: {$user->name}\n";
        $msg .= "📞 هاتف: {$user->phone}\n";

        if ($order->attributes) {
            $attrs = json_decode($order->attributes, true);
            if (!empty($attrs)) {
                $msg .= "🎨 السمات:\n";
                foreach ($attrs as $attrId => $value) {
                    $attrName = Attribute::find($attrId)?->name ?? 'مواصفة';
                    $msg .= "   • {$attrName}: {$value}\n";
                }
            }
        }

        if ($order->notes) {
            $msg .= "📝 ملاحظات: {$order->notes}\n";
        }

        $msg .= "--------------------------";

        try {
            $token = env('WHATSAPP_TOKEN');
            $instance = env('WHATSAPP_INSTANCE');
            $to = env('WHATSAPP_PHONE');

            if ($token && $instance && $to) {
                Http::post("https://api.ultramsg.com/{$instance}/messages/chat", [
                    'token' => $token,
                    'to'    => $to,
                    'body'  => $msg
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("فشل إرسال واتساب: " . $e->getMessage());
        }
    }
}