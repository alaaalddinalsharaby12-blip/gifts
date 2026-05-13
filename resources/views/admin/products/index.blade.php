@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    .products-page {
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

    .product-img {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .product-img:hover {
        transform: scale(1.08);
    }

    .status-active {
        background: linear-gradient(135deg, #d1fae5, #34d399);
        color: #065f46;
        box-shadow: 0 4px 15px rgba(52, 211, 153, 0.3);
    }

    .status-inactive {
        background: linear-gradient(135deg, #e5e7eb, #9ca3af);
        color: #374151;
        box-shadow: 0 4px 15px rgba(156, 163, 175, 0.2);
    }

    .action-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transform: translateX(-100%);
        transition: transform 0.5s;
    }

    .action-btn:hover::before {
        transform: translateX(100%);
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

    .stock-bar {
        height: 6px;
        background: #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .stock-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stock-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: shimmer 2s infinite;
    }

    .empty-state { animation: fadeInUp 0.8s ease-out; }
    .empty-icon { animation: float 5s ease-in-out infinite; }

    .add-btn {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .add-btn::before {
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

    .add-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(99, 102, 241, 0.3);
    }

    /* ✅ زر الرجوع لـ Dashboard */
    .back-dashboard-btn {
        background: white;
        border: 1px solid #e8e8f0;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }

    .back-dashboard-btn:hover {
        border-color: #6366f1;
        background: #eef2ff;
        box-shadow: 0 6px 20px rgba(99,102,241,0.12);
    }

    .back-dashboard-btn:hover svg {
        color: #4f46e5;
        transform: translateX(-3px);
    }

    .back-dashboard-btn:hover span {
        color: #4338ca;
    }

    /* 📱 تحسينات الموبايل */
    @media (max-width: 768px) {
        .products-page {
            padding: 2rem 0.5rem !important;
        }

        .page-title {
            font-size: 1.5rem !important;
        }

        .back-dashboard-btn {
            padding: 0.6rem 0.9rem !important;
            border-radius: 1rem !important;
            margin-bottom: 1.25rem !important;
        }

        .back-dashboard-btn svg {
            width: 18px !important;
            height: 18px !important;
        }

        .back-dashboard-btn span {
            font-size: 0.75rem !important;
        }

        .luxury-card {
            border-radius: 1.5rem !important;
        }

        .add-btn {
            padding: 0.75rem 1.5rem !important;
            font-size: 0.85rem !important;
            width: 100%;
            justify-content: center;
        }

        .add-btn svg {
            width: 18px !important;
            height: 18px !important;
        }

        table {
            font-size: 0.7rem !important;
        }

        th, td {
            padding: 0.6rem 0.5rem !important;
        }

        .product-img {
            width: 40px !important;
            height: 40px !important;
        }

        .stock-bar {
            width: 80px !important;
        }

        .status-active,
        .status-inactive {
            padding: 0.3rem 0.6rem !important;
            font-size: 0.6rem !important;
        }

        .action-btn {
            padding: 0.5rem !important;
        }

        .action-btn svg {
            width: 16px !important;
            height: 16px !important;
        }
    }

    @media (max-width: 360px) {
        .back-dashboard-btn {
            padding: 0.5rem 0.7rem !important;
        }

        .back-dashboard-btn svg {
            width: 16px !important;
            height: 16px !important;
        }

        .back-dashboard-btn span {
            font-size: 0.7rem !important;
        }

        .page-title {
            font-size: 1.3rem !important;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .back-dashboard-btn {
            padding: 0.7rem 1rem !important;
        }
    }
</style>

<div class="products-page py-6 md:py-12 px-3 md:px-4 relative">
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="max-w-6xl mx-auto relative z-10">

        {{-- 🔙 زر الرجوع إلى لوحة التحكم (مناسب لجميع الشاشات) --}}
        <a href="{{ route('admin.dashboard') }}" 
           class="back-dashboard-btn inline-flex items-center gap-2 px-3 sm:px-5 py-2 sm:py-3 rounded-2xl mb-5 md:mb-8">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 transition-all duration-300" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" 
                      d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="text-sm font-bold text-gray-600 transition-colors duration-300">
                <span class="hidden sm:inline">العودة للوحة التحكم</span>
                <span class="sm:hidden">لوحة التحكم</span>
            </span>
        </a>

        <!-- الهيدر -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 md:mb-10 gap-4 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="text-center md:text-right">
                <h1 class="page-title relative inline-block text-2xl sm:text-4xl font-black text-gray-900 mb-2">إدارة المنتجات</h1>
                <p class="text-gray-500 text-xs sm:text-sm">تتبع، تعديل، أو إضافة منتجات جديدة لمتجرك</p>
            </div>

            <a href="{{ route('admin.products.create') }}"
               class="add-btn inline-flex items-center text-white px-6 sm:px-8 py-3 sm:py-4 rounded-2xl shadow-lg font-bold text-sm sm:text-lg w-full sm:w-auto justify-center">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة منتج جديد
            </a>
        </div>

        @if(session('success'))
            <div class="animate-fade-in-up mb-6 md:mb-8" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-r-4 border-green-500 text-green-700 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-lg shadow-green-100/50 flex items-center gap-2 sm:gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="font-bold text-xs sm:text-sm">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="mr-auto text-green-400 hover:text-green-600 transition">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="animate-fade-in-up mb-6 md:mb-8" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-r from-red-50 to-rose-50 border-r-4 border-red-500 text-red-700 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-lg shadow-red-100/50 flex items-center gap-2 sm:gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-bold text-xs sm:text-sm">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- جدول المنتجات -->
        <div class="luxury-card rounded-[2rem] md:rounded-[2.5rem] overflow-hidden animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="bg-gradient-to-l from-gray-50 to-white border-b border-gray-100">
                            <th class="px-3 sm:px-6 py-4 sm:py-5 text-[10px] sm:text-xs font-black text-gray-500 uppercase tracking-widest">المنتج</th>
                            <th class="px-3 sm:px-6 py-4 sm:py-5 text-[10px] sm:text-xs font-black text-gray-500 uppercase tracking-widest hidden sm:table-cell">القسم</th>
                            <th class="px-3 sm:px-6 py-4 sm:py-5 text-[10px] sm:text-xs font-black text-gray-500 uppercase tracking-widest">المخزون</th>
                            <th class="px-3 sm:px-6 py-4 sm:py-5 text-[10px] sm:text-xs font-black text-gray-500 uppercase tracking-widest">الحالة</th>
                            <th class="px-3 sm:px-6 py-4 sm:py-5 text-[10px] sm:text-xs font-black text-gray-500 uppercase tracking-widest text-center">التحكم</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($products as $index => $product)
                        <tr class="hover:bg-indigo-50/20 transition-all duration-300 group animate-fade-in-up" style="animation-delay: {{ 0.3 + ($index * 0.05) }}s;">
                            <td class="px-3 sm:px-6 py-4 sm:py-5">
                                <div class="flex items-center gap-2 sm:gap-4">
                                    <div class="relative w-10 h-10 sm:w-14 sm:h-14 rounded-2xl overflow-hidden shadow-md group-hover:shadow-xl transition-shadow flex-shrink-0">
                                        @if($product->images->count() > 0)
                                            <img src="{{ asset('storage/'.$product->images->first()->image) }}" class="product-img w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-xs sm:text-sm font-black text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $product->name }}</div>
                                        <div class="text-[9px] sm:text-[10px] text-gray-400 font-bold mt-1">#{{ $product->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-3 sm:px-6 py-4 sm:py-5 hidden sm:table-cell">
                                <span class="inline-flex items-center gap-1.5 px-3 sm:px-4 py-1 sm:py-1.5 text-[10px] sm:text-xs font-bold bg-indigo-50 text-indigo-600 rounded-full border border-indigo-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                                    {{ $product->category->name ?? 'بدون قسم' }}
                                </span>
                            </td>

                            <td class="px-3 sm:px-6 py-4 sm:py-5">
                                <div class="w-24 sm:w-32">
                                    <div class="flex justify-between items-center mb-1.5 sm:mb-2">
                                        <span class="text-[10px] sm:text-xs font-bold {{ $product->stock > 5 ? 'text-green-600' : ($product->stock > 0 ? 'text-orange-500' : 'text-red-500') }}">
                                            {{ $product->stock }} قطعة
                                        </span>
                                    </div>
                                    <div class="stock-bar">
                                        <div class="stock-fill {{ $product->stock > 10 ? 'bg-gradient-to-r from-green-400 to-emerald-500' : ($product->stock > 0 ? 'bg-gradient-to-r from-orange-400 to-amber-500' : 'bg-gradient-to-r from-red-400 to-rose-500') }}" 
                                             style="width: {{ min(100, ($product->stock / 50) * 100) }}%"></div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-3 sm:px-6 py-4 sm:py-5">
                                <form action="{{ route('admin.products.toggleStatus', $product) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="focus:outline-none group/status">
                                        @if($product->is_active)
                                            <span class="status-active inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-4 py-1 sm:py-2 rounded-full text-[10px] sm:text-xs font-black transition-all hover:scale-105 whitespace-nowrap">
                                                <span class="relative w-1.5 h-1.5 sm:w-2 sm:h-2">
                                                    <span class="absolute inset-0 rounded-full bg-white animate-ping opacity-75"></span>
                                                    <span class="relative w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-white inline-block"></span>
                                                </span>
                                                نشط
                                            </span>
                                        @else
                                            <span class="status-inactive inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-4 py-1 sm:py-2 rounded-full text-[10px] sm:text-xs font-black transition-all hover:scale-105 whitespace-nowrap">
                                                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-gray-500"></span>
                                                معطل
                                            </span>
                                        @endif
                                    </button>
                                </form>
                            </td>

                            <td class="px-3 sm:px-6 py-4 sm:py-5">
                                <div class="flex justify-center gap-1 sm:gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="action-btn p-2 sm:p-3 text-blue-500 hover:bg-blue-50 rounded-xl transition" title="تعديل">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" 
                                          onsubmit="return confirm('سيتم حذف المنتج نهائياً، هل أنت متأكد؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn p-2 sm:p-3 text-red-500 hover:bg-red-50 rounded-xl transition" title="حذف">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 sm:py-16 text-center">
                                <div class="empty-state flex flex-col items-center">
                                    <div class="empty-icon w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center mb-4 shadow-inner">
                                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-bold text-base sm:text-lg mb-2">لا توجد منتجات حالياً</p>
                                    <a href="{{ route('admin.products.create') }}" class="text-indigo-600 text-sm font-bold hover:underline">أضف أول منتج الآن</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($products->hasPages())
            <div class="mt-6 md:mt-8 animate-fade-in-up" style="animation-delay: 0.6s;">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection