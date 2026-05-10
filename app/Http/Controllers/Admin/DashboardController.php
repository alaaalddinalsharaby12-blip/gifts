<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'categories_count' => Category::count(),
            'products_count' => Product::count(),
            'orders_count' => Order::count(),
            'users_count' => User::where('role', User::ROLE_USER)->count(),
            'admins_count' => User::where('role', User::ROLE_ADMIN)->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'pending_orders' => 0,
            'completed_orders' => 0,
            'active_products' => Product::where('is_active', true)->count(),
        ];

        // ✅ التحقق من وجود الأعمدة قبل الاستخدام
        if (Schema::hasColumn('orders', 'status')) {
            $stats['pending_orders'] = Order::where('status', 'pending')->count();
            $stats['completed_orders'] = Order::where('status', 'completed')->count();
        }

        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $ordersByStatus = array_merge([
            'pending' => 0,
            'processing' => 0,
            'completed' => 0,
            'cancelled' => 0,
        ], $ordersByStatus);

        $latestOrders = Order::with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();

        $latestUsers = User::latest()
            ->where('role', User::ROLE_USER)
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'ordersByStatus', 'latestOrders', 'latestUsers'));
    }
}