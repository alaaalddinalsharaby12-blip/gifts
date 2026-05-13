@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    .order-show-page {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #faf7f2 0%, #f5f0e8 50%, #faf7f2 100%);
        min-height: 100vh;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
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
        transition: left 0.7s;
    }

    .luxury-card:hover::before {
        left: 100%;
    }

    .info-row {
        transition: all 0.3s ease;
        padding: 0.75rem 1rem;
        border-radius: 1rem;
    }

    .info-row:hover {
        background: linear-gradient(90deg, rgba(214, 51, 132, 0.03), rgba(214, 51, 132, 0.06));
        transform: translateX(-4px);
    }

    .status-pending {
        background: linear-gradient(135deg, #fef3c7, #fbbf24);
        color: #92400e;
    }

    .status-processing {
        background: linear-gradient(135deg, #dbeafe, #60a5fa);
        color: #1e40af;
    }

    .status-completed {
        background: linear-gradient(135deg, #d1fae5, #34d399);
        color: #065f46;
    }

    .status-cancelled {
        background: linear-gradient(135deg, #fee2e2, #f87171);
        color: #991b1b;
    }

    .spec-tag {
        background: linear-gradient(135deg, #fdf2f8, #fce7f3);
        border: 1px solid rgba(214, 51, 132, 0.12);
        transition: all 0.3s ease;
    }

    .spec-tag:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(214, 51, 132, 0.15);
    }

    .spec-label {
        background: linear-gradient(135deg, #d63384, #be185d);
    }

    .update-btn {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .update-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .update-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .update-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(59, 130, 246, 0.3);
    }

    .delete-btn {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .delete-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(239, 68, 68, 0.3);
    }

    .select-luxury {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .select-luxury:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
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
        background: linear-gradient(135deg, #d63384, #f472b6);
        top: -10%;
        right: -10%;
        animation: float 8s ease-in-out infinite;
    }

    .back-btn {
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        transform: translateX(-3px);
        background: linear-gradient(135deg, #fce7f3, #fdf2f8);
    }

    /* ✅ زر الرجوع لـ Dashboard */
    .back-dashboard-btn {
        background: white;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }

    .back-dashboard-btn:hover {
        border-color: #d63384;
        background: #fdf2f8;
        box-shadow: 0 6px 20px rgba(214,51,132,0.12);
    }

    .back-dashboard-btn:hover svg {
        color: #d63384;
        transform: translateX(-3px);
    }

    .back-dashboard-btn:hover span {
        color: #a61e63;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        right: 0;
        width: 40px;
        height: 4px;
        background: linear-gradient(90deg, #d63384, #f472b6);
        border-radius: 2px;
        transition: width 0.4s ease;
    }

    .page-title:hover::after {
        width: 100%;
    }

    /* 📱 تحسينات الموبايل */
    @media (max-width: 768px) {
        .order-show-page {
            padding: 1.5rem 0.5rem !important;
        }

        .page-title {
            font-size: 1.3rem !important;
        }

        .back-dashboard-btn {
            padding: 0.5rem 0.8rem !important;
            border-radius: 1rem !important;
            margin-bottom: 1rem !important;
        }

        .back-dashboard-btn svg {
            width: 16px !important;
            height: 16px !important;
        }

        .back-dashboard-btn span {
            font-size: 0.7rem !important;
        }

        .back-btn {
            padding: 0.6rem !important;
        }

        .back-btn svg {
            width: 18px !important;
            height: 18px !important;
        }

        .luxury-card {
            border-radius: 1.5rem !important;
            padding: 1.25rem !important;
        }

        .luxury-card h3 {
            font-size: 1rem !important;
            margin-bottom: 1rem !important;
        }

        .info-row {
            padding: 0.5rem 0.75rem !important;
        }

        .info-row span {
            font-size: 0.7rem !important;
        }

        h4 {
            font-size: 1.1rem !important;
        }

        .spec-tag .spec-label,
        .spec-tag span {
            padding: 0.4rem 0.75rem !important;
            font-size: 0.65rem !important;
        }

        .update-btn,
        .delete-btn {
            padding: 0.75rem 1rem !important;
            font-size: 0.75rem !important;
            width: 100%;
            justify-content: center;
        }

        .update-btn svg,
        .delete-btn svg {
            width: 16px !important;
            height: 16px !important;
        }

        .select-luxury {
            padding: 0.75rem 1rem !important;
            font-size: 0.75rem !important;
            min-width: auto !important;
            width: 100%;
        }

        .grid-cols-2 {
            grid-template-columns: 1fr !important;
        }
    }

    @media (max-width: 360px) {
        .back-dashboard-btn {
            padding: 0.4rem 0.6rem !important;
        }

        .back-dashboard-btn span {
            font-size: 0.65rem !important;
        }

        .page-title {
            font-size: 1.1rem !important;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .back-dashboard-btn {
            padding: 0.7rem 1rem !important;
        }
    }
</style>

<div class="order-show-page py-6 md:py-12 px-3 md:px-4 relative">
    <div class="bg-blob blob-1"></div>

    <div class="max-w-4xl mx-auto relative z-10">

        {{-- 🔙 زر الرجوع إلى لوحة التحكم (مناسب لجميع الشاشات) --}}
        <a href="{{ route('admin.index') }}" 
           class="back-dashboard-btn inline-flex items-center gap-2 px-3 sm:px-5 py-2 sm:py-3 rounded-2xl mb-5 md:mb-8">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 transition-all duration-300" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" 
                      d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="text-sm font-bold text-gray-600 transition-colors duration-300">
                <span class="hidden sm:inline">العودة للوحة الطلبات</span>
                <span class="sm:hidden">لوحة الطلبات</span>
            </span>
        </a>

        <!-- الهيدر -->
        <div class="flex items-center gap-3 sm:gap-4 mb-6 md:mb-10 animate-fade-in-up" style="animation-delay: 0.1s;">
            <a href="{{ route('admin.orders.index') }}" class="back-btn p-2.5 sm:p-3 bg-white rounded-2xl shadow-sm border border-gray-100">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="page-title relative inline-block text-xl sm:text-3xl font-black text-gray-900">تفاصيل الطلب #{{ $order->id }}</h1>
                <p class="text-gray-500 text-xs sm:text-sm mt-1 sm:mt-2">{{ $order->created_at->format('Y/m/d H:i') }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="animate-fade-in-up mb-5 md:mb-6" style="animation-delay: 0.15s;">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-r-4 border-green-500 text-green-700 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-lg text-xs sm:text-sm font-bold">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            
            <!-- معلومات الطلب -->
            <div class="luxury-card rounded-[2rem] md:rounded-[2.5rem] p-5 sm:p-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                <h3 class="text-base sm:text-lg font-black text-gray-900 mb-4 sm:mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    معلومات الطلب
                </h3>
                
                @php
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

                <div class="space-y-1.5 sm:space-y-2">
                    <div class="info-row flex justify-between items-center">
                        <span class="text-gray-500 text-xs sm:text-sm font-bold">رقم الطلب:</span>
                        <span class="font-black text-gray-900 text-xs sm:text-sm">#{{ $order->id }}</span>
                    </div>
                    <div class="info-row flex justify-between items-center">
                        <span class="text-gray-500 text-xs sm:text-sm font-bold">التاريخ:</span>
                        <span class="font-bold text-gray-700 text-xs sm:text-sm">{{ $order->created_at->format('Y/m/d H:i') }}</span>
                    </div>
                    <div class="info-row flex justify-between items-center">
                        <span class="text-gray-500 text-xs sm:text-sm font-bold">الحالة:</span>
                        <span class="{{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600' }} px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[10px] sm:text-xs font-black">
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                    </div>
                    <div class="info-row flex justify-between items-center">
                        <span class="text-gray-500 text-xs sm:text-sm font-bold">الكمية:</span>
                        <span class="font-black text-pink-600 text-base sm:text-lg">{{ $order->quantity }}</span>
                    </div>
                </div>
            </div>

            <!-- معلومات العميل -->
            <div class="luxury-card rounded-[2rem] md:rounded-[2.5rem] p-5 sm:p-8 animate-fade-in-up" style="animation-delay: 0.25s;">
                <h3 class="text-base sm:text-lg font-black text-gray-900 mb-4 sm:mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    معلومات العميل
                </h3>
                
                <div class="space-y-1.5 sm:space-y-2">
                    <div class="info-row flex justify-between items-center">
                        <span class="text-gray-500 text-xs sm:text-sm font-bold">الاسم:</span>
                        <span class="font-bold text-gray-900 text-xs sm:text-sm">{{ $order->user->name ?? 'غير معروف' }}</span>
                    </div>
                    <div class="info-row flex justify-between items-center">
                        <span class="text-gray-500 text-xs sm:text-sm font-bold">البريد:</span>
                        <span class="font-bold text-gray-700 text-left text-xs sm:text-sm" dir="ltr">{{ $order->user->email ?? '-' }}</span>
                    </div>
                    <div class="info-row flex justify-between items-center">
                        <span class="text-gray-500 text-xs sm:text-sm font-bold">الهاتف:</span>
                        <span class="font-bold text-gray-700 text-left text-xs sm:text-sm" dir="ltr">{{ $order->user->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- تفاصيل المنتج والمواصفات -->
            <div class="luxury-card rounded-[2rem] md:rounded-[2.5rem] p-5 sm:p-8 md:col-span-2 animate-fade-in-up" style="animation-delay: 0.3s;">
                <h3 class="text-base sm:text-lg font-black text-gray-900 mb-4 sm:mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    تفاصيل المنتج
                </h3>
                
                <div class="mb-4 sm:mb-6">
                    <h4 class="font-black text-xl sm:text-2xl text-gray-900 mb-1 sm:mb-2">{{ $order->product_name }}</h4>
                    <div class="flex items-center gap-2 text-gray-400 text-xs sm:text-sm">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                        كود المنتج: #{{ $order->product_id }}
                    </div>
                </div>

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
                @endphp

                @if(count($orderAttributes) > 0)
                <div class="mt-4 sm:mt-6">
                    <h5 class="text-[10px] sm:text-xs font-black text-gray-400 uppercase tracking-widest mb-3 sm:mb-4 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"/>
                        </svg>
                        المواصفات المختارة
                    </h5>
                    
                    <div class="flex flex-wrap gap-2 sm:gap-3">
                        @foreach($orderAttributes as $attrId => $attrValue)
                            @php
                                $attrName = $attributesMap[$attrId] ?? 'مواصفة';
                            @endphp
                            <div class="spec-tag flex items-center rounded-xl overflow-hidden shadow-sm">
                                <span class="spec-label text-white px-3 sm:px-4 py-2 sm:py-2.5 text-[10px] sm:text-xs font-black">
                                    {{ $attrName }}
                                </span>
                                <span class="text-gray-700 text-xs sm:text-sm font-bold px-3 sm:px-4 py-2 sm:py-2.5 bg-white/80">
                                    {{ $attrValue }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="mt-4 sm:mt-6 flex items-center gap-2 sm:gap-3 bg-gray-50 w-fit px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl border border-dashed border-gray-200">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs sm:text-sm text-gray-400 font-bold">لا توجد خصائص مخصصة لهذا الطلب</span>
                </div>
                @endif
            </div>

            <!-- تحديث الحالة -->
            <div class="luxury-card rounded-[2rem] md:rounded-[2.5rem] p-5 sm:p-8 md:col-span-2 animate-fade-in-up" style="animation-delay: 0.35s;">
                <h3 class="text-base sm:text-lg font-black text-gray-900 mb-4 sm:mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    تحديث الحالة
                </h3>
                
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex flex-col sm:flex-row gap-3 sm:gap-4 items-start sm:items-center">
                    @csrf
                    @method('PATCH')
                    
                    <select name="status" class="select-luxury w-full sm:w-auto px-4 sm:px-6 py-3 sm:py-3.5 rounded-2xl font-bold text-gray-700 text-xs sm:text-sm appearance-none cursor-pointer">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ قيد الانتظار</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>🔧 جاري التنفيذ</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✨ مكتمل</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ ملغي</option>
                    </select>
                    
                    <button type="submit" class="update-btn text-white px-6 sm:px-8 py-3 sm:py-3.5 rounded-2xl font-black text-xs sm:text-sm flex items-center gap-2 w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        تحديث الحالة
                    </button>
                </form>
            </div>

            <!-- حذف الطلب -->
            <div class="luxury-card rounded-[2rem] md:rounded-[2.5rem] p-5 sm:p-8 md:col-span-2 animate-fade-in-up" style="animation-delay: 0.4s;">
                <h3 class="text-base sm:text-lg font-black text-red-600 mb-4 sm:mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    منطقة الخطر
                </h3>
                
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" 
                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟ لا يمكن التراجع!');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn text-white px-6 sm:px-8 py-3 sm:py-3.5 rounded-2xl font-black text-xs sm:text-sm flex items-center gap-2 w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        حذف الطلب نهائياً
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection