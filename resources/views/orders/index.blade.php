@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    .orders-page {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #faf7f2 0%, #f5f0e8 50%, #faf7f2 100%);
        min-height: 100vh;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes pulse-ring {
        0% { transform: scale(0.8); opacity: 0.5; }
        100% { transform: scale(1.3); opacity: 0; }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .luxury-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.6);
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

    .luxury-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(214, 51, 132, 0.08);
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
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 20px rgba(214, 51, 132, 0.15);
        border-color: rgba(214, 51, 132, 0.25);
    }

    .spec-label {
        background: linear-gradient(135deg, #d63384, #be185d);
    }

    .admin-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .admin-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .admin-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .admin-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }

    .bg-blob {
        position: fixed;
        border-radius: 50%;
        filter: blur(100px);
        opacity: 0.12;
        pointer-events: none;
        z-index: 0;
    }

    .blob-1 {
        width: 600px;
        height: 600px;
        background: linear-gradient(135deg, #d63384, #f472b6);
        top: -15%;
        right: -15%;
        animation: float 10s ease-in-out infinite;
    }

    .blob-2 {
        width: 500px;
        height: 500px;
        background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        bottom: -15%;
        left: -15%;
        animation: float 12s ease-in-out infinite reverse;
    }

    .page-title {
        position: relative;
        display: inline-block;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        right: 0;
        width: 50px;
        height: 4px;
        background: linear-gradient(90deg, #d63384, #f472b6);
        border-radius: 2px;
        transition: width 0.4s ease;
    }

    .page-title:hover::after {
        width: 100%;
    }

    .empty-state { animation: fadeInUp 0.8s ease-out; }
    .empty-icon { animation: float 5s ease-in-out infinite; }

    .pulse-dot {
        position: relative;
    }

    .pulse-dot::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: inherit;
        animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }

    .back-home-btn {
        background: white;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }

    .back-home-btn:hover {
        border-color: #d63384;
        background: #fdf2f8;
        box-shadow: 0 6px 20px rgba(214,51,132,0.12);
    }

    .back-home-btn:hover svg {
        color: #d63384;
        transform: translateX(-3px);
    }

    .back-home-btn:hover span {
        color: #a61e63;
    }

    /* 📱 تحسينات الموبايل */
    @media (max-width: 768px) {
        .orders-page {
            padding: 1.5rem 0.5rem !important;
        }

        .back-home-btn {
            padding: 0.5rem 0.8rem !important;
            border-radius: 1rem !important;
            margin-bottom: 1rem !important;
        }

        .back-home-btn svg {
            width: 16px !important;
            height: 16px !important;
        }

        .back-home-btn span {
            font-size: 0.7rem !important;
        }

        .page-title {
            font-size: 1.5rem !important;
        }

        .luxury-card {
            border-radius: 1.5rem !important;
            padding: 1.25rem !important;
            margin-bottom: 1rem !important;
        }

        .status-badge {
            padding: 0.4rem 0.8rem !important;
            font-size: 0.7rem !important;
        }

        .spec-tag .spec-label,
        .spec-tag span {
            padding: 0.4rem 0.75rem !important;
            font-size: 0.65rem !important;
        }

        .admin-btn {
            padding: 0.75rem !important;
            font-size: 0.7rem !important;
        }

        .admin-btn svg {
            width: 16px !important;
            height: 16px !important;
        }
    }

    @media (max-width: 360px) {
        .page-title {
            font-size: 1.3rem !important;
        }

        .luxury-card {
            padding: 1rem !important;
        }
    }
</style>

<div class="orders-page py-6 md:py-12 px-3 md:px-4 relative">
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="max-w-4xl mx-auto relative z-10">

        {{-- 🔙 زر الرجوع إلى الصفحة الرئيسية --}}
        <a href="{{ route('home') }}" 
           class="back-home-btn inline-flex items-center gap-2 px-3 sm:px-5 py-2 sm:py-3 rounded-2xl mb-5 md:mb-8">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 transition-all duration-300" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" 
                      d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="text-sm font-bold text-gray-600 transition-colors duration-300">
                <span class="hidden sm:inline">العودة للصفحة الرئيسية</span>
                <span class="sm:hidden">الرئيسية</span>
            </span>
        </a>

        <!-- الهيدر -->
        <div class="text-center mb-8 md:mb-12 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 rounded-3xl bg-gradient-to-br from-pink-100 to-rose-100 mb-4 sm:mb-6 shadow-xl shadow-pink-100/50" style="animation: float 6s ease-in-out infinite;">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h1 class="page-title text-2xl sm:text-4xl font-black text-gray-900 mb-2 sm:mb-3">
                {{ auth()->user()->isAdmin() ? 'إدارة جميع الطلبات' : 'طلباتي الشخصية' }}
            </h1>
            <p class="text-gray-500 text-xs sm:text-sm font-medium">تتبع وإدارة طلباتك بكل سهولة</p>
        </div>

        @if(session('success'))
            <div class="animate-fade-in-up mb-6 md:mb-8" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-r-4 border-green-500 text-green-700 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-lg shadow-green-100/50 flex items-center gap-2 sm:gap-3 text-xs sm:text-sm">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

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
                'pending' => '⏳ طلب جديد',
                'processing' => '🔧 قيد التنفيذ',
                'completed' => '✨ تم الإنجاز',
                'cancelled' => '❌ ملغي',
            ];
        @endphp

        <div class="luxury-card rounded-[2rem] md:rounded-[2.5rem] p-5 sm:p-8 mb-6 md:mb-8 animate-fade-in-up" style="animation-delay: {{ 0.2 + ($index * 0.1) }}s;">
            
            <!-- رأس البطاقة -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 sm:gap-4 mb-6 md:mb-8">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-gray-900 to-gray-700 flex items-center justify-center text-white font-black text-sm sm:text-lg shadow-xl shadow-gray-200">
                        #{{ $order->id }}
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">رقم الطلب</p>
                        <p class="text-xs sm:text-sm text-gray-500 flex items-center gap-1 sm:gap-2">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $order->created_at->format('Y/m/d | H:i') }}
                        </p>
                    </div>
                </div>

                <div class="status-badge {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600' }} px-4 sm:px-6 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-black border-0">
                    {{ $statusLabels[$order->status] ?? $order->status }}
                </div>
            </div>

            <!-- معلومات العميل -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mb-6 md:mb-8">
                <div class="bg-gradient-to-br from-gray-50 to-white p-4 sm:p-5 rounded-2xl border border-gray-100 flex items-center gap-3 sm:gap-4 group hover:border-pink-200 transition-all duration-300">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center text-pink-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[9px] sm:text-[10px] text-gray-400 font-black uppercase tracking-wider mb-1">صاحب الطلب</p>
                        <p class="text-sm sm:text-base font-black text-gray-800">{{ $order->user->name ?? 'عميل غير معروف' }}</p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-gray-50 to-white p-4 sm:p-5 rounded-2xl border border-gray-100 flex items-center gap-3 sm:gap-4 group hover:border-pink-200 transition-all duration-300">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center text-pink-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[9px] sm:text-[10px] text-gray-400 font-black uppercase tracking-wider mb-1">رقم التواصل</p>
                        <p class="text-sm sm:text-base font-black text-gray-800" dir="ltr">{{ $order->user->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- تفاصيل المنتج -->
            <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-4 sm:p-6 mb-5 sm:mb-6 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-pink-500/20 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-purple-500/10 to-transparent rounded-full blur-2xl"></div>
                
                <div class="relative z-10">
                    <p class="text-pink-300 text-[10px] sm:text-xs font-bold uppercase tracking-widest mb-1 sm:mb-2 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-pink-400 pulse-dot"></span>
                        المنتج المطلوب
                    </p>
                    <p class="text-lg sm:text-2xl font-black tracking-tight">{{ $order->product_name ?? $order->product->name ?? '-' }}</p>
                    <p class="text-gray-400 text-xs sm:text-sm mt-1 sm:mt-2 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        الكمية: {{ $order->quantity }} وحدة
                    </p>
                </div>
            </div>

            <!-- المواصفات -->
            @if(count($orderAttributes) > 0)
            <div class="mb-5 sm:mb-6">
                <p class="text-[10px] sm:text-xs font-black text-gray-400 uppercase tracking-widest mb-3 sm:mb-4 mr-2 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                    المواصفات المختارة
                </p>
                <div class="flex flex-wrap gap-2 sm:gap-3">
                    @foreach($orderAttributes as $attrId => $attrValue)
                        @php 
                            $attrName = $attributesMap[$attrId] ?? 'مواصفة'; 
                        @endphp
                        <div class="spec-tag flex items-center rounded-xl overflow-hidden shadow-sm cursor-default">
                            <span class="spec-label text-white px-3 sm:px-4 py-2 sm:py-2.5 text-[10px] sm:text-xs font-black whitespace-nowrap">
                                {{ $attrName }}
                            </span>
                            <span class="text-gray-700 text-xs sm:text-sm font-bold px-3 sm:px-4 py-2 sm:py-2.5 bg-white/80 whitespace-nowrap">
                                {{ $attrValue }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="mb-5 sm:mb-6 flex items-center gap-2 sm:gap-3 bg-gray-50 w-fit px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl border border-dashed border-gray-200">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-xs sm:text-sm text-gray-400 font-bold">لا توجد مواصفات إضافية</span>
            </div>
            @endif

            <!-- ملاحظات -->
            @if($order->notes)
            <div class="mb-5 sm:mb-6 bg-amber-50 border border-amber-100 rounded-xl p-3 sm:p-4 flex items-start gap-2 sm:gap-3">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <div>
                    <p class="text-[10px] sm:text-xs font-black text-amber-600 uppercase tracking-wider mb-1">ملاحظات</p>
                    <p class="text-xs sm:text-sm text-amber-800 font-medium">{{ $order->notes }}</p>
                </div>
            </div>
            @endif

            <!-- أزرار التحكم -->
            @if(auth()->user()->isAdmin())
            <div class="pt-5 sm:pt-6 border-t border-gray-100">
                <p class="text-[10px] sm:text-xs font-black text-gray-400 uppercase tracking-widest mb-3 sm:mb-4 mr-2">تحديث الحالة</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-3">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="processing">
                        <button type="submit" class="admin-btn w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-2.5 sm:py-3.5 rounded-xl text-xs sm:text-sm font-black transition-all shadow-lg shadow-blue-200/50 flex items-center justify-center gap-1 sm:gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            قيد التنفيذ
                        </button>
                    </form>

                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="admin-btn w-full bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white py-2.5 sm:py-3.5 rounded-xl text-xs sm:text-sm font-black transition-all shadow-lg shadow-green-200/50 flex items-center justify-center gap-1 sm:gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            اكتمال الطلب
                        </button>
                    </form>

                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="admin-btn w-full bg-white border-2 border-red-100 text-red-500 hover:bg-red-50 hover:border-red-200 py-2.5 sm:py-3.5 rounded-xl text-xs sm:text-sm font-black transition-all flex items-center justify-center gap-1 sm:gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            إلغاء الطلب
                        </button>
                    </form>
                </div>
            </div>
            @endif

        </div>

        @empty
        <div class="empty-state text-center py-12 sm:py-20">
            <div class="empty-icon w-20 h-20 sm:w-28 sm:h-28 rounded-full bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center mx-auto mb-4 sm:mb-6 shadow-inner">
                <svg class="w-10 h-10 sm:w-14 sm:h-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-black text-gray-800 mb-2">لا توجد طلبات حالياً</h3>
            <p class="text-gray-400 text-xs sm:text-sm">ابدأ بتصفح المنتجات وإجراء طلبك الأول</p>
        </div>
        @endforelse

        @if($orders->hasPages())
            <div class="mt-8 md:mt-10 animate-fade-in-up" style="animation-delay: 0.5s;">
                {{ $orders->links() }}
            </div>
        @endif

    </div>
</div>
@endsection