@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    .orders-admin-page {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #f8f9fc 0%, #eef2ff 50%, #f8f9fc 100%);
        min-height: 100vh;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }

    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }

    @keyframes pulse-ring {
        0% { transform: scale(0.8); opacity: 0.6; }
        100% { transform: scale(1.4); opacity: 0; }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }

    .luxury-card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.7);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .luxury-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        transition: left 0.7s ease;
    }

    .luxury-card:hover::before {
        left: 100%;
    }

    .luxury-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(99, 102, 241, 0.08), 0 0 0 1px rgba(99, 102, 241, 0.05);
    }

    .status-badge {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .status-pending {
        background: linear-gradient(135deg, #fef3c7, #fbbf24);
        color: #92400e;
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.35);
    }

    .status-processing {
        background: linear-gradient(135deg, #dbeafe, #60a5fa);
        color: #1e40af;
        box-shadow: 0 4px 15px rgba(96, 165, 250, 0.35);
    }

    .status-completed {
        background: linear-gradient(135deg, #d1fae5, #34d399);
        color: #065f46;
        box-shadow: 0 4px 15px rgba(52, 211, 153, 0.35);
    }

    .status-cancelled {
        background: linear-gradient(135deg, #fee2e2, #f87171);
        color: #991b1b;
        box-shadow: 0 4px 15px rgba(248, 113, 113, 0.35);
    }

    .spec-tag {
        background: linear-gradient(135deg, #fdf2f8, #fce7f3);
        border: 1px solid rgba(214, 51, 132, 0.12);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .spec-tag:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(214, 51, 132, 0.15);
    }

    .spec-label {
        background: linear-gradient(135deg, #d63384, #be185d);
    }

    .action-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        transform: scale(1.1);
    }

    .bg-blob {
        position: fixed;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.1;
        pointer-events: none;
        z-index: 0;
    }

    .blob-1 {
        width: 500px;
        height: 500px;
        background: linear-gradient(135deg, #6366f1, #a855f7);
        top: -10%;
        right: -10%;
        animation: float 8s ease-in-out infinite;
    }

    .blob-2 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, #ec4899, #f472b6);
        bottom: -10%;
        left: -10%;
        animation: float 10s ease-in-out infinite reverse;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        right: 0;
        width: 50px;
        height: 4px;
        background: linear-gradient(90deg, #6366f1, #a855f7);
        border-radius: 2px;
        transition: width 0.4s ease;
    }

    .page-title:hover::after {
        width: 100%;
    }

    .empty-state { animation: fadeInUp 0.8s ease-out; }
    .empty-icon { animation: float 5s ease-in-out infinite; }
</style>

<div class="orders-admin-page py-12 px-4 relative">
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="max-w-7xl mx-auto relative z-10">

        <!-- الهيدر -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="text-center md:text-right">
                <h1 class="page-title relative inline-block text-4xl font-black text-gray-900 mb-2">إدارة الطلبات</h1>
                <p class="text-gray-500 text-sm">إجمالي الطلبات: <span class="text-indigo-600 font-bold">{{ $orders->total() }}</span></p>
            </div>
        </div>

        @if(session('success'))
            <div class="animate-fade-in-up mb-8" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-r-4 border-green-500 text-green-700 px-6 py-4 rounded-2xl shadow-lg shadow-green-100/50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="animate-fade-in-up mb-8" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-r from-red-50 to-rose-50 border-r-4 border-red-500 text-red-700 px-6 py-4 rounded-2xl shadow-lg shadow-red-100/50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- جدول الطلبات -->
        <div class="luxury-card rounded-[2.5rem] overflow-hidden animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="bg-gradient-to-l from-gray-50 to-white border-b border-gray-100">
                            <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-widest">#</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-widest">العميل</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-widest">المنتج</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-widest">المواصفات</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-widest text-center">الكمية</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-widest">الحالة</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-widest">التاريخ</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-widest text-center">إجراءات</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($orders as $index => $order)
                        @php
                            $orderAttributes = [];
                            if (!empty($order->attributes)) {
                                if (is_array($order->attributes)) {
                                    $orderAttributes = $order->attributes;
                                } elseif (is_string($order->attributes)) {
                                    $decoded = json_decode($order->attributes, true);
                                    if (is_array($decoded)) {
                                        $orderAttributes = $decoded;
                                    }
                                }
                            }

                            $statusColors = [
                                'pending' => 'status-pending',
                                'processing' => 'status-processing',
                                'completed' => 'status-completed',
                                'cancelled' => 'status-cancelled',
                            ];
                            $statusLabels = [
                                'pending' => '⏳ قيد الانتظار',
                                'processing' => '🔧 جاري التنفيذ',
                                'completed' => '✨ مكتمل',
                                'cancelled' => '❌ ملغي',
                            ];
                        @endphp

                        <tr class="hover:bg-indigo-50/20 transition-all duration-300 group animate-fade-in-up" style="animation-delay: {{ 0.3 + ($index * 0.05) }}s;">
                            <td class="px-6 py-5">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-900 to-gray-700 flex items-center justify-center text-white font-black text-sm shadow-lg">
                                    #{{ $order->id }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-gray-900">{{ $order->user->name ?? 'غير معروف' }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $order->user->email ?? '' }}</div>
                            </td>

                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-gray-800">{{ $order->product_name }}</div>
                            </td>

                            <td class="px-6 py-5">
                                @if(count($orderAttributes) > 0)
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($orderAttributes as $attrId => $attrValue)
                                            @php
                                                $attrName = $attributesMap[$attrId] ?? 'مواصفة';
                                            @endphp
                                            <span class="spec-tag inline-flex items-center rounded-lg overflow-hidden shadow-sm">
                                                <span class="spec-label text-white px-2 py-1 text-[10px] font-black">{{ $attrName }}</span>
                                                <span class="text-gray-700 text-[10px] font-bold px-2 py-1 bg-white">{{ $attrValue }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs italic">لا توجد خصائص</span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 font-black text-sm">
                                    {{ $order->quantity }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <span class="status-badge {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600' }} px-4 py-2 rounded-full text-xs font-black">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-gray-700">{{ $order->created_at->format('Y/m/d') }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $order->created_at->format('H:i') }}</div>
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="action-btn p-3 text-blue-500 hover:bg-blue-50 rounded-xl transition" title="عرض">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب نهائياً؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn p-3 text-red-500 hover:bg-red-50 rounded-xl transition" title="حذف">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="empty-state flex flex-col items-center">
                                    <div class="empty-icon w-24 h-24 rounded-full bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center mb-4 shadow-inner">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-bold text-lg mb-2">لا توجد طلبات حالياً</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($orders->hasPages())
            <div class="mt-8 animate-fade-in-up" style="animation-delay: 0.6s;">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection