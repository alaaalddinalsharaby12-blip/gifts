@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    .dashboard-page {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    .bg-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.15;
        pointer-events: none;
        animation: orbFloat 20s ease-in-out infinite;
    }

    .orb-1 {
        width: 600px;
        height: 600px;
        background: linear-gradient(135deg, #e94560, #ff6b6b);
        top: -20%;
        right: -10%;
    }

    .orb-2 {
        width: 500px;
        height: 500px;
        background: linear-gradient(135deg, #0f3460, #533483);
        bottom: -20%;
        left: -10%;
        animation-delay: -5s;
    }

    @keyframes orbFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(30px, -30px) scale(1.1); }
        50% { transform: translate(-20px, 20px) scale(0.95); }
        75% { transform: translate(20px, 10px) scale(1.05); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(233, 69, 96, 0.2); }
        50% { box-shadow: 0 0 40px rgba(233, 69, 96, 0.4); }
    }

    .animate-fade-up {
        animation: fadeInUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        opacity: 0;
    }

    .animate-fade-down {
        animation: fadeInDown 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        opacity: 0;
    }

    .dashboard-header {
        position: relative;
    }

    .title-shimmer {
        background: linear-gradient(90deg, #fff 0%, #e94560 25%, #fff 50%, #e94560 75%, #fff 100%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 4s linear infinite;
    }

    .luxury-card {
        position: relative;
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 2rem;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        text-decoration: none;
        display: block;
    }

    .luxury-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,0.05) 50%, transparent 60%);
        background-size: 200% 200%;
        opacity: 0;
        transition: opacity 0.5s;
    }

    .luxury-card:hover::before {
        opacity: 1;
        animation: shimmer 2s ease infinite;
    }

    .luxury-card:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(255, 255, 255, 0.15);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3), 0 0 100px rgba(233, 69, 96, 0.1);
    }

    .luxury-card:active {
        transform: scale(0.97);
    }

    .card-icon {
        position: relative;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .luxury-card:hover .card-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .icon-glow {
        position: absolute;
        inset: -10px;
        border-radius: inherit;
        opacity: 0;
        transition: opacity 0.5s;
        filter: blur(20px);
    }

    .luxury-card:hover .icon-glow {
        opacity: 0.5;
    }

    .decorative-line {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    }

    .counter-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        min-width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #e94560, #ff6b6b);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 900;
        color: white;
        box-shadow: 0 4px 15px rgba(233, 69, 96, 0.4);
        animation: pulse-glow 2s ease-in-out infinite;
        z-index: 10;
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: rippleEffect 0.6s ease-out;
        pointer-events: none;
    }

    @keyframes rippleEffect {
        to { transform: scale(4); opacity: 0; }
    }

    .grid-lines {
        position: fixed;
        inset: 0;
        background-image: 
            linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
        background-size: 50px 50px;
        pointer-events: none;
        z-index: 0;
    }

    .stat-number {
        font-variant-numeric: tabular-nums;
    }

    /* ====== 🆕 جدول متجاوب بطريقة الكروت ====== */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,0.2) transparent;
    }

    .table-wrapper::-webkit-scrollbar {
        height: 4px;
    }

    .table-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    .table-wrapper::-webkit-scrollbar-thumb {
        background: rgba(233, 69, 96, 0.3);
        border-radius: 10px;
    }

    /* عرض كروت على الموبايل */
    .orders-cards {
        display: none;
    }

    .order-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 0.5rem;
    }

    .order-card .order-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.4rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .order-card .order-row:last-child {
        border-bottom: none;
    }

    .order-card .label {
        color: #888;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .order-card .value {
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
        text-align: left;
    }

    .order-card .order-id {
        color: #e94560;
        font-family: monospace;
    }

    /* =========================== */
    /* 📱 تحسينات الموبايل        */
    /* =========================== */
    @media (max-width: 768px) {
        .dashboard-page {
            padding: 1rem 0.5rem !important;
        }

        .dashboard-header {
            margin-bottom: 2rem !important;
        }

        .dashboard-header h1 {
            font-size: 1.6rem !important;
        }

        .dashboard-header p {
            font-size: 0.8rem !important;
        }

        .dashboard-header .w-16 {
            width: 48px !important;
            height: 48px !important;
        }

        .dashboard-header .w-16 svg {
            width: 24px !important;
            height: 24px !important;
        }

        .luxury-card {
            border-radius: 1.5rem !important;
            padding: 1.2rem !important;
        }

        .luxury-card .card-icon {
            padding: 0.8rem !important;
            margin-bottom: 0.8rem !important;
        }

        .luxury-card .card-icon svg {
            width: 28px !important;
            height: 28px !important;
        }

        .luxury-card h3 {
            font-size: 1.1rem !important;
            margin-bottom: 0.3rem !important;
        }

        .luxury-card p {
            font-size: 0.7rem !important;
            margin-bottom: 0.5rem !important;
        }

        .luxury-card .text-sm {
            font-size: 0.7rem !important;
        }

        .counter-badge {
            min-width: 24px !important;
            height: 24px !important;
            font-size: 10px !important;
            top: -6px !important;
            right: -6px !important;
        }

        .grid-cols-4 {
            grid-template-columns: repeat(2, 1fr) !important;
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, 1fr) !important;
        }

        .grid-cols-5 {
            grid-template-columns: repeat(3, 1fr) !important;
        }

        .stat-number {
            font-size: 1.5rem !important;
        }

        .text-xs {
            font-size: 0.6rem !important;
        }

        .rounded-2xl {
            border-radius: 1rem !important;
        }

        .p-6 {
            padding: 1rem !important;
        }

        .p-5 {
            padding: 0.8rem !important;
        }

        .p-8 {
            padding: 1.2rem !important;
        }

        .gap-6 {
            gap: 0.8rem !important;
        }

        .gap-4 {
            gap: 0.5rem !important;
        }

        .mt-16 {
            margin-top: 2rem !important;
        }

        .mt-12 {
            margin-top: 1.5rem !important;
        }

        .mb-16 {
            margin-bottom: 2rem !important;
        }

        .mb-6 {
            margin-bottom: 0.8rem !important;
        }

        .mb-3 {
            margin-bottom: 0.3rem !important;
        }

        .mb-4 {
            margin-bottom: 0.5rem !important;
        }

        .text-2xl {
            font-size: 1.2rem !important;
        }

        .text-xl {
            font-size: 1rem !important;
        }

        .text-lg {
            font-size: 0.85rem !important;
        }

        .w-12 {
            width: 36px !important;
            height: 36px !important;
        }

        .w-12 svg {
            width: 16px !important;
        }

        /* 🆕 إخفاء الجدول وإظهار الكروت */
        .desktop-table {
            display: none !important;
        }

        .orders-cards {
            display: block !important;
        }
    }

    /* أجهزة أكبر - إظهار الجدول وإخفاء الكروت */
    @media (min-width: 769px) {
        .desktop-table {
            display: block !important;
        }

        .orders-cards {
            display: none !important;
        }
    }

    /* موبايل صغير جداً */
    @media (max-width: 360px) {
        .dashboard-header h1 {
            font-size: 1.3rem !important;
        }

        .luxury-card {
            padding: 1rem !important;
        }

        .luxury-card .card-icon svg {
            width: 24px !important;
            height: 24px !important;
        }

        .luxury-card h3 {
            font-size: 1rem !important;
        }

        .grid-cols-5 {
            grid-template-columns: repeat(2, 1fr) !important;
        }

        .order-card {
            padding: 0.8rem !important;
        }

        .order-card .label {
            font-size: 0.6rem !important;
        }

        .order-card .value {
            font-size: 0.7rem !important;
        }
    }

    /* تابلت */
    @media (min-width: 769px) and (max-width: 1024px) {
        .grid-cols-4 {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .grid-cols-5 {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }
</style>

<div class="dashboard-page py-6 md:py-12 px-3 md:px-4 relative">
    <div class="grid-lines"></div>
    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>

    <div class="max-w-6xl mx-auto relative z-10">

        <!-- الهيدر -->
        <div class="dashboard-header text-center mb-8 md:mb-16 animate-fade-down">
            <div class="inline-flex items-center gap-3 mb-4 md:mb-6">
                <div class="w-12 h-12 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-[#e94560] to-[#ff6b6b] flex items-center justify-center shadow-2xl shadow-[#e94560]/30">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl md:text-5xl font-black text-white mb-2 md:mb-3 tracking-tight">
                لوحة <span class="title-shimmer">التحكم</span>
            </h1>
            <p class="text-gray-400 text-sm md:text-lg font-medium">إدارة متجرك بكل احترافية وسهولة</p>

            <div class="decorative-line max-w-md mx-auto mt-6 md:mt-8"></div>
        </div>

        <!-- البطاقات الرئيسية -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">

            <!-- الأقسام -->
            <a href="{{ route('admin.categories.index') }}" class="luxury-card group p-4 md:p-8 animate-fade-up stagger-1" onclick="createRipple(event, this)">
                @if($stats['categories_count'] > 0)
                    <div class="counter-badge">{{ $stats['categories_count'] }}</div>
                @endif
                
                <div class="flex flex-col items-center text-center relative z-10">
                    <div class="card-icon relative p-3 md:p-5 bg-gradient-to-br from-blue-500/20 to-blue-600/10 rounded-2xl mb-3 md:mb-6 border border-blue-400/20">
                        <div class="icon-glow bg-blue-500 rounded-2xl"></div>
                        <svg class="w-7 h-7 md:w-10 md:h-10 text-blue-400 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-lg md:text-2xl font-black text-white mb-1 md:mb-2 group-hover:text-blue-300 transition-colors">الأقسام</h3>
                    <p class="text-gray-500 text-xs md:text-sm mb-2 md:mb-4">إدارة تصنيفات المنتجات</p>
                    
                    <div class="flex items-center gap-1 md:gap-2 text-blue-400 text-xs md:text-sm font-bold opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <span>دخول الآن</span>
                        <svg class="w-3 h-3 md:w-4 md:h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- المنتجات -->
            <a href="{{ route('admin.products.index') }}" class="luxury-card group p-4 md:p-8 animate-fade-up stagger-2" onclick="createRipple(event, this)">
                @if($stats['products_count'] > 0)
                    <div class="counter-badge">{{ $stats['products_count'] }}</div>
                @endif
                
                <div class="flex flex-col items-center text-center relative z-10">
                    <div class="card-icon relative p-3 md:p-5 bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 rounded-2xl mb-3 md:mb-6 border border-emerald-400/20">
                        <div class="icon-glow bg-emerald-500 rounded-2xl"></div>
                        <svg class="w-7 h-7 md:w-10 md:h-10 text-emerald-400 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-lg md:text-2xl font-black text-white mb-1 md:mb-2 group-hover:text-emerald-300 transition-colors">المنتجات</h3>
                    <p class="text-gray-500 text-xs md:text-sm mb-2 md:mb-4">إضافة وتعديل المنتجات</p>
                    
                    <div class="flex items-center gap-1 md:gap-2 text-emerald-400 text-xs md:text-sm font-bold opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <span>دخول الآن</span>
                        <svg class="w-3 h-3 md:w-4 md:h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- الطلبات -->
            <a href="{{ route('admin.orders.index') }}" class="luxury-card group p-4 md:p-8 animate-fade-up stagger-3" onclick="createRipple(event, this)">
                @if($stats['orders_count'] > 0)
                    <div class="counter-badge">{{ $stats['orders_count'] }}</div>
                @endif
                
                <div class="flex flex-col items-center text-center relative z-10">
                    <div class="card-icon relative p-3 md:p-5 bg-gradient-to-br from-orange-500/20 to-orange-600/10 rounded-2xl mb-3 md:mb-6 border border-orange-400/20">
                        <div class="icon-glow bg-orange-500 rounded-2xl"></div>
                        <svg class="w-7 h-7 md:w-10 md:h-10 text-orange-400 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-lg md:text-2xl font-black text-white mb-1 md:mb-2 group-hover:text-orange-300 transition-colors">الطلبات</h3>
                    <p class="text-gray-500 text-xs md:text-sm mb-2 md:mb-4">متابعة مبيعات العملاء</p>
                    
                    <div class="flex items-center gap-1 md:gap-2 text-orange-400 text-xs md:text-sm font-bold opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <span>دخول الآن</span>
                        <svg class="w-3 h-3 md:w-4 md:h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- المتطلبات -->
            <a href="{{ route('admin.attributes.index') }}" class="luxury-card group p-4 md:p-8 animate-fade-up stagger-4" onclick="createRipple(event, this)">
                <div class="counter-badge">8</div>
                
                <div class="flex flex-col items-center text-center relative z-10">
                    <div class="card-icon relative p-3 md:p-5 bg-gradient-to-br from-purple-500/20 to-purple-600/10 rounded-2xl mb-3 md:mb-6 border border-purple-400/20">
                        <div class="icon-glow bg-purple-500 rounded-2xl"></div>
                        <svg class="w-7 h-7 md:w-10 md:h-10 text-purple-400 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-lg md:text-2xl font-black text-white mb-1 md:mb-2 group-hover:text-purple-300 transition-colors">المتطلبات</h3>
                    <p class="text-gray-500 text-xs md:text-sm mb-2 md:mb-4">تخصيص خيارات المنتجات</p>
                    
                    <div class="flex items-center gap-1 md:gap-2 text-purple-400 text-xs md:text-sm font-bold opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <span>دخول الآن</span>
                        <svg class="w-3 h-3 md:w-4 md:h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

        </div>

        <!-- إحصائيات سريعة -->
        <div class="mt-8 md:mt-16 grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4 animate-fade-up" style="animation-delay: 0.5s;">
            <div class="text-center p-3 md:p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                <div class="stat-number text-xl md:text-3xl font-black text-white mb-1">{{ $stats['today_orders'] }}</div>
                <div class="text-[10px] md:text-xs text-gray-500 font-bold uppercase tracking-widest">طلبات اليوم</div>
            </div>
            <div class="text-center p-3 md:p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                <div class="stat-number text-xl md:text-3xl font-black text-emerald-400 mb-1">{{ $stats['pending_orders'] }}</div>
                <div class="text-[10px] md:text-xs text-gray-500 font-bold uppercase tracking-widest">طلبات جديدة</div>
            </div>
            <div class="text-center p-3 md:p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                <div class="stat-number text-xl md:text-3xl font-black text-blue-400 mb-1">{{ $stats['active_products'] }}</div>
                <div class="text-[10px] md:text-xs text-gray-500 font-bold uppercase tracking-widest">منتج نشط</div>
            </div>
            <div class="text-center p-3 md:p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                <div class="stat-number text-xl md:text-3xl font-black text-purple-400 mb-1">{{ $stats['categories_count'] }}</div>
                <div class="text-[10px] md:text-xs text-gray-500 font-bold uppercase tracking-widest">قسم</div>
            </div>
        </div>

        <!-- حالة الطلبات -->
        @if($stats['orders_count'] > 0)
        <div class="mt-8 md:mt-12 animate-fade-up" style="animation-delay: 0.6s;">
            <h3 class="text-lg md:text-xl font-black text-white mb-4 md:mb-6 text-center">حالة الطلبات</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4">
                <div class="text-center p-3 md:p-5 rounded-2xl bg-yellow-500/10 border border-yellow-500/20">
                    <div class="stat-number text-lg md:text-2xl font-black text-yellow-400 mb-1">{{ $ordersByStatus['pending'] }}</div>
                    <div class="text-[10px] md:text-xs text-yellow-500/70 font-bold">قيد الانتظار</div>
                </div>
                <div class="text-center p-3 md:p-5 rounded-2xl bg-blue-500/10 border border-blue-500/20">
                    <div class="stat-number text-lg md:text-2xl font-black text-blue-400 mb-1">{{ $ordersByStatus['processing'] }}</div>
                    <div class="text-[10px] md:text-xs text-blue-500/70 font-bold">جاري التنفيذ</div>
                </div>
                <div class="text-center p-3 md:p-5 rounded-2xl bg-green-500/10 border border-green-500/20">
                    <div class="stat-number text-lg md:text-2xl font-black text-green-400 mb-1">{{ $ordersByStatus['completed'] }}</div>
                    <div class="text-[10px] md:text-xs text-green-500/70 font-bold">مكتملة</div>
                </div>
                <div class="text-center p-3 md:p-5 rounded-2xl bg-red-500/10 border border-red-500/20">
                    <div class="stat-number text-lg md:text-2xl font-black text-red-400 mb-1">{{ $ordersByStatus['cancelled'] }}</div>
                    <div class="text-[10px] md:text-xs text-red-500/70 font-bold">ملغية</div>
                </div>
            </div>
        </div>
        @endif

        <!-- 🆕 أحدث الطلبات - عرضين: جدول للديسكتوب + كروت للموبايل -->
        @if($latestOrders->count() > 0)
        <div class="mt-8 md:mt-12 animate-fade-up" style="animation-delay: 0.7s;">
            <h3 class="text-lg md:text-xl font-black text-white mb-4 md:mb-6 text-center">أحدث الطلبات</h3>
            
            <!-- 🖥️ عرض الجدول - للديسكتوب -->
            <div class="desktop-table table-wrapper rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b border-white/10 text-gray-400 text-sm">
                            <th class="p-4 font-bold">#</th>
                            <th class="p-4 font-bold">العميل</th>
                            <th class="p-4 font-bold">المنتج</th>
                            <th class="p-4 font-bold">التاريخ</th>
                        </tr>
                    </thead>
                    <tbody class="text-white">
                        @foreach($latestOrders as $order)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="p-4 font-mono text-gray-400">#{{ $order->id }}</td>
                            <td class="p-4">{{ $order->user?->name ?? 'زائر' }}</td>
                            <td class="p-4">{{ $order->product?->name ?? '-' }}</td>
                            <td class="p-4 text-gray-400 text-sm">
                                {{ $order->created_at->locale('ar')->translatedFormat('j F Y') }}
                                <span class="text-gray-600 mx-1">|</span>
                                {{ $order->created_at->locale('ar')->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- 📱 عرض الكروت - للموبايل -->
            <div class="orders-cards">
                @foreach($latestOrders as $order)
                <div class="order-card">
                    <div class="order-row">
                        <span class="label">رقم الطلب</span>
                        <span class="value order-id">#{{ $order->id }}</span>
                    </div>
                    <div class="order-row">
                        <span class="label">العميل</span>
                        <span class="value">{{ $order->user?->name ?? 'زائر' }}</span>
                    </div>
                    <div class="order-row">
                        <span class="label">المنتج</span>
                        <span class="value">{{ $order->product?->name ?? '-' }}</span>
                    </div>
                    <div class="order-row">
                        <span class="label">التاريخ</span>
                        <span class="value">{{ $order->created_at->locale('ar')->translatedFormat('j F Y') }}</span>
                    </div>
                    <div class="order-row">
                        <span class="label">الوقت</span>
                        <span class="value">{{ $order->created_at->locale('ar')->diffForHumans() }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- أحدث المستخدمين -->
        @if($latestUsers->count() > 0)
        <div class="mt-8 md:mt-12 animate-fade-up" style="animation-delay: 0.8s;">
            <h3 class="text-lg md:text-xl font-black text-white mb-4 md:mb-6 text-center">أحدث المستخدمين</h3>
            <div class="grid grid-cols-3 md:grid-cols-5 gap-2 md:gap-4">
                @foreach($latestUsers as $user)
                <div class="text-center p-3 md:p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="w-10 h-10 md:w-12 md:h-12 mx-auto mb-2 md:mb-3 rounded-full bg-gradient-to-br from-[#e94560] to-[#ff6b6b] flex items-center justify-center text-white font-bold text-sm md:text-lg">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                    <div class="text-white font-bold text-xs md:text-sm truncate">{{ $user->name }}</div>
                    <div class="text-gray-500 text-[10px] md:text-xs mt-1">
                        {{ $user->created_at->locale('ar')->diffForHumans() }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

<script>
function createRipple(event, element) {
    const ripple = document.createElement('span');
    const rect = element.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = x + 'px';
    ripple.style.top = y + 'px';
    ripple.classList.add('ripple');
    
    element.appendChild(ripple);
    
    setTimeout(() => ripple.remove(), 600);
}
</script>
@endsection