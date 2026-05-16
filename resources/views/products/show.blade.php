@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');
    
    :root {
        --primary: #d63384;
        --primary-light: #f8d7e8;
        --primary-dark: #a61e63;
        --gold: #d4af37;
        --gold-light: #f4e5a1;
        --dark: #0f0f0f;
    }

    body { 
        font-family: 'Tajawal', sans-serif; 
        background: linear-gradient(135deg, #faf7f2 0%, #f5f0e8 50%, #faf7f2 100%);
        color: #1a1a1a;
        overflow-x: hidden;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(-60px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(60px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    @keyframes borderRotate {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .animate-fade-in-up {
        animation: fadeInUp 1s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        opacity: 0;
    }

    .animate-slide-right {
        animation: slideInRight 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        opacity: 0;
    }

    .animate-slide-left {
        animation: slideInLeft 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        opacity: 0;
    }

    .glass-luxury {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
    }

    .card-3d {
        transform-style: preserve-3d;
        transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .card-3d:hover {
        transform: translateY(-8px) rotateX(2deg);
    }

    .text-shimmer {
        background: linear-gradient(90deg, var(--primary), var(--gold), var(--primary));
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 4s linear infinite;
    }

    .btn-luxury {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--dark) 0%, #2a2a2a 100%);
        transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .btn-luxury::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s;
    }

    .btn-luxury:hover::before {
        left: 100%;
    }

    .btn-luxury:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(214, 51, 132, 0.3);
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
    }

    .animated-border {
        position: relative;
        background: white;
        border-radius: 2.5rem;
        z-index: 1;
    }

    .animated-border::before {
        content: '';
        position: absolute;
        inset: -2px;
        border-radius: 2.6rem;
        background: linear-gradient(60deg, var(--primary), var(--gold), var(--primary-light), var(--primary));
        background-size: 300% 300%;
        animation: borderRotate 4s ease infinite;
        z-index: -1;
    }

    /* ====== تقسيم الشاشة ====== */
    .split-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: start;
        min-height: calc(100vh - 300px);
    }

    /* ====== القسم الأيسر - الصورة ====== */
    .left-section {
        position: sticky;
        top: 2rem;
        align-self: start;
        transition: top 0.3s ease;
    }

    /* تأثير النزول مع السكرول */
    .image-scroll-wrapper {
        transition: transform 0.1s linear, opacity 0.1s linear;
        will-change: transform;
    }

    /* ====== القسم الأيمن - المحتوى ====== */
    .right-section {
        padding-top: 2rem;
    }

    .gallery-container {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .gallery-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        will-change: opacity;
    }

    .gallery-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        -webkit-user-drag: none;
        user-select: none;
        -webkit-user-select: none;
    }

    .image-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 4/3;
        overflow: hidden;
        border-radius: 2.3rem;
    }

    .quote-luxury {
        position: relative;
        font-style: italic;
    }
    .quote-luxury::before {
        content: '"';
        position: absolute;
        top: -20px; right: -10px;
        font-size: 6rem;
        color: var(--primary-light);
        font-family: serif;
        line-height: 1;
        z-index: 0;
        opacity: 0.6;
    }

    .feature-item {
        position: relative;
        padding-right: 2rem;
        transition: all 0.3s ease;
    }
    .feature-item::before {
        content: '◆';
        position: absolute;
        right: 0;
        color: var(--gold);
        font-size: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
    }
    .feature-item:hover {
        transform: translateX(-5px);
        color: var(--primary-dark);
    }

    .counter-badge {
        background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,255,255,0.7));
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.6);
    }

    /* تأثير النزول للصورة عند التحميل */
    .image-drop-effect {
        animation: dropIn 1.4s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        opacity: 0;
    }

    @keyframes dropIn {
        0% {
            opacity: 0;
            transform: translateY(-80px) scale(0.95);
            filter: blur(10px);
        }
        60% {
            opacity: 1;
            transform: translateY(10px) scale(1.02);
            filter: blur(0px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0px);
        }
    }

    /* تأثير الظهور التدريجي للمحتوى */
    .stagger-item {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .stagger-item.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* =========================== */
    /* 📱 موبايل عام               */
    /* =========================== */
    @media (max-width: 1023px) {
        .split-container {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .left-section {
            position: relative !important;
            top: 0 !important;
        }
    }

    @media (min-width: 381px) and (max-width: 640px) {
        .split-container { gap: 0.8rem; }
        
        h1 { font-size: 1.3rem !important; }
        
        .animated-border { border-radius: 1rem; }
        .animated-border::before { border-radius: calc(1rem + 1.5px); }
        .image-wrapper, .gallery-container { aspect-ratio: 1/1; border-radius: 0.9rem; }
        
        .btn-luxury { padding: 0.85rem !important; font-size: 0.95rem !important; border-radius: 1rem !important; }
        .btn-luxury svg { width: 18px !important; height: 18px !important; }
        
        .glass-luxury { padding: 0.85rem !important; border-radius: 1rem !important; }
        
        .gallery-nav-btn { width: 32px !important; height: 32px !important; }
        .gallery-nav-btn svg { width: 14px !important; height: 14px !important; }
        
        .contents-card { padding: 0.85rem !important; border-radius: 1rem !important; }
        .contents-title { font-size: 0.95rem !important; }
        .contents-title .icon-box { width: 32px !important; height: 32px !important; min-width: 32px !important; }
        .feature-item { font-size: 0.75rem !important; }
    }

    @media (min-width: 1024px) {
        .animated-border { border-radius: 2rem; }
        .animated-border::before { border-radius: calc(2rem + 1.5px); }
        .image-wrapper, .gallery-container { border-radius: 1.8rem; }
    }
    
    @media (max-width: 640px) {
        .min-h-screen {
            padding-top: 1.5rem !important;
            padding-bottom: 2rem !important;
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        
        h1 {
            font-size: 1.5rem !important;
            line-height: 1.3 !important;
        }
        
        .text-5xl {
            font-size: 1.5rem !important;
        }
        
        .lg\\:text-7xl {
            font-size: 1.5rem !important;
        }
        
        .hero-section .badge {
            font-size: 0.65rem !important;
            padding: 0.25rem 0.8rem !important;
        }
        
        .animated-border {
            border-radius: 1.2rem;
        }
        
        .animated-border::before {
            border-radius: 1.3rem;
        }
        
        .image-wrapper {
            border-radius: 1.2rem;
            aspect-ratio: 1/1;
        }
        
        .btn-luxury {
            padding: 1rem !important;
            font-size: 1.1rem !important;
            border-radius: 1.5rem !important;
        }
        
        .btn-luxury svg {
            width: 22px !important;
            height: 22px !important;
        }
        
        .glass-luxury {
            padding: 1.2rem !important;
            border-radius: 1.5rem !important;
        }
        
        .quote-luxury::before {
            font-size: 3rem !important;
            top: -10px !important;
            right: -5px !important;
        }
        
        .quote-luxury p {
            font-size: 0.9rem !important;
        }
        
        .counter-badge {
            bottom: 0.5rem !important;
            left: 0.5rem !important;
            padding: 0.3rem 0.8rem !important;
            font-size: 0.7rem !important;
        }
        
        .counter-badge span {
            font-size: 0.8rem !important;
        }
        
        .gallery-nav-btn {
            width: 36px !important;
            height: 36px !important;
        }
        
        .gallery-nav-btn svg {
            width: 16px !important;
            height: 16px !important;
        }
        
        .bg-white.rounded-\\[2\\.5rem\\] {
            border-radius: 1.5rem !important;
            padding: 1.2rem !important;
        }
        
        .contents-title {
            font-size: 1.1rem !important;
        }
        
        .contents-title .icon-box {
            width: 40px !important;
            height: 40px !important;
        }
        
        .contents-title .icon-box svg {
            width: 20px !important;
            height: 20px !important;
        }
        
        .feature-item {
            font-size: 0.85rem !important;
        }
        
        .space-y-8 > * + * {
            margin-top: 1rem !important;
        }
        
        .mb-12 {
            margin-bottom: 1.5rem !important;
        }
        
        .mb-10 {
            margin-bottom: 1rem !important;
        }
        
        .p-10 {
            padding: 1.2rem !important;
        }
        
        .p-8 {
            padding: 1rem !important;
        }
        
        .gap-4 {
            gap: 0.5rem !important;
        }
        
        .text-2xl {
            font-size: 1.1rem !important;
        }
        
        .text-xl {
            font-size: 0.9rem !important;
        }
        
        .text-lg {
            font-size: 0.85rem !important;
        }
        
        .w-14 {
            width: 40px !important;
        }
        
        .h-14 {
            height: 40px !important;
        }
        
        .w-8 {
            width: 20px !important;
        }
        
        .h-8 {
            height: 20px !important;
        }
        
        .w-24 {
            width: 50px !important;
        }
        
        .mt-6 {
            margin-top: 1rem !important;
        }
        
        .text-sm {
            font-size: 0.7rem !important;
        }
        
        .text-xs {
            font-size: 0.6rem !important;
        }
    }

    /* =========================== */
    /* 📱 360px - إصلاح العرض     */
    /* =========================== */
    @media (max-width: 380px) {
        .product-container {
            padding: 0.15rem !important;
        }

        .split-container {
            grid-template-columns: 1fr;
            gap: 0.6rem;
        }

        .left-section {
            position: relative !important;
            top: 0 !important;
        }

        h1 {
            font-size: 1.05rem !important;
            line-height: 1.25 !important;
        }

        .badge {
            font-size: 0.58rem !important;
            padding: 0.15rem 0.4rem !important;
        }

        .animated-border {
            border-radius: 0.8rem;
            padding: 0.6rem !important;
        }

        .animated-border::before {
            border-radius: calc(0.8rem + 1.5px);
        }

        .image-wrapper,
        .gallery-container {
            aspect-ratio: 1/1;
            border-radius: 0.7rem;
        }

        .gallery-nav-btn {
            width: 28px !important;
            height: 28px !important;
        }

        .gallery-nav-btn svg {
            width: 12px !important;
            height: 12px !important;
        }

        .counter-badge {
            bottom: 0.3rem !important;
            left: 0.3rem !important;
            padding: 0.15rem 0.4rem !important;
            font-size: 0.6rem !important;
            border-radius: 0.4rem !important;
        }

        .counter-badge span {
            font-size: 0.65rem !important;
        }

        .gallery-dot {
            width: 4px !important;
            height: 4px !important;
        }

        .gallery-dot.bg-white {
            width: 10px !important;
        }
        .btn-luxury {
            padding: 0.7rem !important;
            font-size: 0.85rem !important;
            border-radius: 0.8rem !important;
        }

        .btn-luxury svg {
            width: 16px !important;
            height: 16px !important;
        }

        .glass-luxury {
            padding: 0.7rem !important;
            border-radius: 0.8rem !important;
        }

        .quote-luxury::before {
            font-size: 2rem !important;
            top: -8px !important;
            right: -2px !important;
        }

        .quote-luxury p {
            font-size: 0.7rem !important;
            line-height: 1.5 !important;
        }

        .contents-card {
            padding: 0.7rem !important;
            border-radius: 0.8rem !important;
        }

        .contents-title {
            font-size: 0.85rem !important;
            gap: 0.4rem !important;
            margin-bottom: 0.5rem !important;
        }

        .contents-title .icon-box {
            width: 28px !important;
            height: 28px !important;
            min-width: 28px !important;
            border-radius: 8px !important;
        }

        .contents-title .icon-box svg {
            width: 14px !important;
            height: 14px !important;
        }

        .contents-title .sub {
            font-size: 0.65rem !important;
        }

        .contents-list-wrapper {
            padding: 0.6rem !important;
            border-radius: 0.7rem !important;
        }

        .contents-list-wrapper .list-label {
            font-size: 0.7rem !important;
            margin-bottom: 0.4rem !important;
        }

        .feature-item {
            font-size: 0.68rem !important;
            padding-right: 1rem !important;
            line-height: 1.4 !important;
        }

        .contents-footer {
            font-size: 0.62rem !important;
            margin-top: 0.4rem !important;
            padding-top: 0.4rem !important;
        }

        /* مسافات */
        .mb-12, .mb-10, .mb-8 { margin-bottom: 0.5rem !important; }
        .mb-6, .mb-5, .mb-4 { margin-bottom: 0.4rem !important; }
        .mb-3 { margin-bottom: 0.3rem !important; }
        .mt-6, .mt-5, .mt-4 { margin-top: 0.4rem !important; }
        .mt-3 { margin-top: 0.3rem !important; }
        .p-10, .p-8 { padding: 0.7rem !important; }
        .p-6, .p-5, .p-4 { padding: 0.6rem !important; }
        .gap-4, .gap-3 { gap: 0.3rem !important; }
        
        .text-5xl, .text-4xl, .text-3xl { font-size: 1.05rem !important; }
        .text-2xl { font-size: 0.9rem !important; }
        .text-xl { font-size: 0.8rem !important; }
        .text-lg { font-size: 0.75rem !important; }
        .text-base { font-size: 0.7rem !important; }
        .text-sm { font-size: 0.65rem !important; }
        .text-xs { font-size: 0.6rem !important; }
        
        .w-14, .w-12 { width: 28px !important; }
        .h-14, .h-12 { height: 28px !important; }
        .w-10, .w-9 { width: 24px !important; }
        .h-10, .h-9 { height: 24px !important; }
        .w-8 { width: 20px !important; }
        .h-8 { height: 20px !important; }
        .w-24 { width: 40px !important; }
        .w-16 { width: 30px !important; }
        .w-6 { width: 16px !important; }
        .h-6 { height: 16px !important; }
        
        .space-y-8 > * + * { margin-top: 0.5rem !important; }
        .space-y-4 > * + * { margin-top: 0.3rem !important; }
    }
    #A{
        font-size:31px;
    }
</style>

<div class="min-h-screen py-6 md:py-12 px-3 md:px-8 relative z-10" dir="rtl">
    <div class="max-w-7xl mx-auto">
        
        <!-- ====== الهيدر ====== -->
        <header class="text-center mb-6 md:mb-12 animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="flex items-center justify-center gap-2 md:gap-4 mb-4 md:mb-6 flex-wrap">
                <span class="px-4 py-1.5 md:px-6 md:py-2 bg-white/80 backdrop-blur-sm border border-pink-200 text-pink-600 rounded-full text-xs md:text-sm font-bold tracking-wider shadow-lg shadow-pink-100/50">
                    ✨ {{ $product->category->name ?? 'صناديق الخطوبة' }}
                </span>
                @if($product->stock > 0)
                <span class="flex items-center gap-1.5 md:gap-2 text-emerald-600 text-xs md:text-sm font-bold bg-emerald-50/80 backdrop-blur-sm px-3 py-1.5 md:px-4 md:py-2 rounded-full border border-emerald-200 shadow-lg">
                    <span class="relative flex h-2 w-2 md:h-3 md:w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 md:h-3 md:w-3 bg-emerald-500"></span>
                    </span>
                    جاهز للتنفيذ الفوري
                </span>
                @endif
            </div>
            
            <h1 class="text-2xl md:text-5xl lg:text-7xl font-black text-gray-900 leading-tight mb-3 md:mb-4 tracking-tight">
                <span class="block text-shimmer">{{ $product->name }}</span>
            </h1>
            
            <div class="w-16 md:w-24 h-1 bg-gradient-to-r from-pink-500 via-yellow-400 to-pink-500 mx-auto rounded-full mt-3 md:mt-6"></div>
        </header>

        <!-- ====== تقسيم الشاشة نصفين ====== -->
        <div class="split-container">
            
            <!-- ====== النصف الأيسر: الصورة (تأثير نزول) ====== -->
            <div class="left-section" id="leftSection">
                <div class="image-drop-effect image-scroll-wrapper" id="imageScrollWrapper" style="animation-delay: 0.3s">
                
                    <!-- معرض الصور -->
                    <div class="animated-border p-1 md:p-1.5 shadow-2xl shadow-pink-100/30 card-3d mb-4 md:mb-6">
                        <div class="image-wrapper bg-gradient-to-br from-gray-50 to-gray-100 shadow-inner group">
                            <div id="imageGallery" class="gallery-container">
                                @forelse($product->images as $index => $image)
                                    <div class="gallery-slide {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-index="{{ $index }}" style="transition: opacity 1s cubic-bezier(0.22, 1, 0.36, 1);">
                                        <img src="{{ asset('storage/'.$image->image) }}" 
                                             class="transform group-hover:scale-110 transition-transform duration-[4s] ease-out" 
                                             alt="{{ $product->name }}"
                                             loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                             draggable="false">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                                    </div>
                                @empty
                                    <div class="flex items-center justify-center h-full bg-gradient-to-br from-pink-50 to-purple-50">
                                        <svg class="w-16 h-16 md:w-24 md:h-24 text-pink-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endforelse
                            </div>

                            @if($product->images->count() > 1)
                            <!-- عداد الصور -->
                            <div class="absolute bottom-3 left-3 md:bottom-6 md:left-6 z-20 counter-badge px-3 py-1.5 md:px-5 md:py-2.5 rounded-xl md:rounded-2xl text-gray-800 text-xs md:text-sm font-bold shadow-xl">
                                <span id="imageCounter" class="text-pink-600 text-base md:text-lg font-black">1</span>
                                <span class="text-gray-400 mx-0.5 md:mx-1">/</span>
                                <span class="text-gray-500 text-xs md:text-sm">{{ $product->images->count() }}</span>
                            </div>

                            <!-- أزرار التنقل -->
                            <button onclick="prevImage()" class="gallery-nav-btn absolute right-2 md:right-5 top-1/2 -translate-y-1/2 z-30 w-10 h-10 md:w-14 md:h-14 glass-luxury rounded-full flex items-center justify-center text-gray-700 hover:bg-pink-600 hover:text-white transition-all duration-300 shadow-xl opacity-0 group-hover:opacity-100 transform translate-x-4 md:translate-x-8 group-hover:translate-x-0 hover:scale-110">
                                <svg class="w-5 h-5 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            <button onclick="nextImage()" class="gallery-nav-btn absolute left-2 md:left-5 top-1/2 -translate-y-1/2 z-30 w-10 h-10 md:w-14 md:h-14 glass-luxury rounded-full flex items-center justify-center text-gray-700 hover:bg-pink-600 hover:text-white transition-all duration-300 shadow-xl opacity-0 group-hover:opacity-100 transform -translate-x-4 md:-translate-x-8 group-hover:translate-x-0 hover:scale-110">
                                <svg class="w-5 h-5 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </button>

                            <!-- مؤشرات النقاط -->
                            <div class="absolute bottom-3 md:bottom-6 right-1/2 translate-x-1/2 z-20 flex gap-1.5 md:gap-2">
                                @foreach($product->images as $index => $image)
                                <button onclick="showImage({{ $index }})" class="h-2 md:h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white w-6 md:w-8' : 'bg-white/50 hover:bg-white/80 w-2 md:w-2.5' }} gallery-dot" data-index="{{ $index }}"></button>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- الوصف تحت الصورة -->
                    <div class="glass-luxury p-4 md:p-8 rounded-2xl md:rounded-[2.5rem] relative overflow-hidden group hover:shadow-2xl transition-shadow duration-500 stagger-item">
                        <div class="absolute top-0 right-8 md:right-12 -translate-y-1/2 w-10 md:w-16 h-1 md:h-1.5 bg-gradient-to-r from-pink-400 to-yellow-400 rounded-full"></div>
                        
                        <div class="quote-luxury relative z-10">
                            <p class="text-sm md:text-xl text-gray-700 leading-[1.7] md:leading-[1.8] font-medium text-right relative z-10">
                                {{ $product->description }}
                            </p>
                        </div>
                        
                        <div class="mt-3 md:mt-4 flex items-center gap-2 md:gap-3 text-pink-600/60 text-xs md:text-sm font-bold">
                            <span class="w-8 md:w-12 h-px bg-pink-300"></span>
                            <span>تفاصيل تُصنع بعناية فائقة</span>
                        </div>
                    </div>
                    
                </div>
            </div> <!-- نهاية النصف الأيسر -->

            <!-- ====== النصف الأيمن: المحتوى ====== -->
            <div class="right-section space-y-4 md:space-y-8">
                
                <!-- ====== "لمحات من الفخامة بداخل البوكس" ====== -->
                @if(isset($product->category) && $product->category->contents)
                <div class="bg-white rounded-2xl md:rounded-[2.5rem] p-4 md:p-10 shadow-2xl shadow-pink-100/40 relative overflow-hidden border border-pink-50 card-3d stagger-item" style="transition-delay: 0.2s">
                    <div class="absolute -top-20 -right-20 w-60 h-60 bg-gradient-to-br from-pink-100/40 to-purple-100/40 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-gradient-to-tr from-yellow-100/30 to-pink-100/30 rounded-full blur-3xl"></div>
                    
                    <div class="relative mb-4 md:mb-10">
                        <h3 class="text-gray-900 font-black text-lg md:text-2xl flex items-center gap-3 md:gap-4">
                            <span class="w-10 h-10 md:w-14 md:h-14 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl md:rounded-2xl flex items-center justify-center shadow-xl shadow-pink-200/50 transform hover:rotate-6 transition-transform duration-300">
                                <svg class="w-5 h-5 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </span>
                            <span class="leading-tight">
                                تفاصيل من...
                                <span id="A" class="text-pink-500 text-sm ">السعادة</span>
                            </span>
                        </h3>
                    </div>

                    <div class="relative space-y-3 md:space-y-4">
                        @php 
                            $items = explode("\n", $product->category->contents);
                            $filteredItems = array_filter(array_map('trim', $items));
                        @endphp
                        
                        <div class="bg-gradient-to-br from-pink-50/80 to-purple-50/30 p-4 md:p-8 rounded-2xl md:rounded-3xl border border-pink-100/50 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-pink-200/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            
                            <div class="relative z-10">
                                <span class="text-pink-700 font-black block mb-3 md:mb-4 text-base md:text-xl">يحتوي هذا البوكس المصمم بعناية على:</span>
                                
                                <div class="space-y-2 md:space-y-3">
                                    @foreach($filteredItems as $item)
                                        <div class="feature-item text-sm md:text-base text-gray-600 font-semibold">{{ $item }}</div>
                                    @endforeach
                                </div>
                                
                                <span class="text-pink-600 font-black block mt-4 md:mt-6 pt-3 md:pt-4 border-t border-pink-200/30 text-sm md:text-base">.. وأكثر، لتكتمل تفاصيل لاحظتكم الخاصة ✨</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- قسم الطلب -->
                <div class="space-y-3 md:space-y-6 stagger-item" style="transition-delay: 0.4s">
                    @if($product->stock > 0)
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-pink-600 via-purple-600 to-pink-600 rounded-2xl md:rounded-[2.5rem] blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                        <a href="{{ route('order.create', $product) }}" 
                           class="btn-luxury relative w-full text-white p-4 md:p-8 rounded-2xl md:rounded-[2.3rem] font-black text-lg md:text-2xl text-center flex items-center justify-center gap-2 md:gap-4 active:scale-[0.98] shadow-2xl">
                            <span class="relative z-10 flex items-center gap-2 md:gap-3">
                                <span>احجز الآن</span>
                                <svg class="w-5 h-5 md:w-8 md:h-8 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                    
                    <div class="text-center space-y-2 md:space-y-3">
                        <p class="text-gray-400 text-xs md:text-sm font-medium flex items-center justify-center gap-2">
                            <span class="w-6 md:w-8 h-px bg-gray-300"></span>
                            ✨ تنسيق خاص لكل طلب لضمان التميز
                            <span class="w-6 md:w-8 h-px bg-gray-300"></span>
                        </p>
                        <div class="flex items-center justify-center gap-1.5 md:gap-2 text-[10px] md:text-xs text-gray-400 flex-wrap">
                            <svg class="w-3 h-3 md:w-4 md:h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>دفع آمن</span>
                            <span class="w-0.5 h-0.5 md:w-1 md:h-1 bg-gray-300 rounded-full"></span>
                            <svg class="w-3 h-3 md:w-4 md:h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>توصيل سريع</span>
                            <span class="w-0.5 h-0.5 md:w-1 md:h-1 bg-gray-300 rounded-full"></span>
                            <svg class="w-3 h-3 md:w-4 md:h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>جودة مضمونة</span>
                        </div>
                    </div>
                    @else
                    <button disabled class="w-full bg-gray-100 text-gray-400 p-4 md:p-8 rounded-2xl md:rounded-[2.5rem] font-black text-lg md:text-2xl cursor-not-allowed border-2 border-dashed border-gray-200 relative overflow-hidden">
                        <span class="relative z-10">مغلق حالياً</span>
                        <div class="absolute inset-0 bg-gray-50/50"></div>
                    </button>
                    <p class="text-center text-gray-400 text-xs md:text-sm">سيتم إشعارك عند توفر المنتج</p>
                    @endif
                </div>
                
            </div> <!-- نهاية النصف الأيمن -->
            
        </div> <!-- نهاية التقسيم -->
    </div>
</div>

<script>
    // ==========================================
// 1️⃣ حساب ارتفاع الـ nav تلقائياً (متوافق مع app.blade.php)
// ==========================================
function updateNavHeight() {
    const leftSection = document.getElementById('leftSection');
    if (!leftSection) return;

    // للموبايل - خلّيه relative
    if (window.innerWidth <= 1023) {
        leftSection.style.top = '0px';
        return;
    }

    // نجيب ارتفاع nav من المتغير اللي حطيناه في app.blade.php
    const navHeight = getComputedStyle(document.documentElement).getPropertyValue('--nav-height').trim();
    const navHeightPx = parseInt(navHeight) || 0;
    
    // المسافة = ارتفاع nav + هامش 24px
    const topOffset = navHeightPx + 24;
    leftSection.style.top = topOffset + 'px';
}

// تشغيل
updateNavHeight();
window.addEventListener('resize', updateNavHeight);
window.addEventListener('load', updateNavHeight);
// نتأكد بعد شوي لأن بعض المتصفحات تتأخر بتحميل الـ nav
setTimeout(updateNavHeight, 100);
setTimeout(updateNavHeight, 500);


// ==========================================
// 2️⃣ تأثير النزول مع السكرول (ديسكتوب فقط)
// ==========================================
const imageScrollWrapper = document.getElementById('imageScrollWrapper');
let ticking = false;

function updateImageScroll() {
    if (window.innerWidth <= 1023) {
        if (imageScrollWrapper) {
            imageScrollWrapper.style.transform = 'none';
            imageScrollWrapper.style.opacity = '1';
        }
        ticking = false;
        return;
    }

    const scrollY = window.scrollY;
    const maxScroll = 500;
    const translateY = scrollY * 0.15;
    const progress = Math.min(scrollY / maxScroll, 1);
    const opacity = 1 - (progress * 0.15);
    
    if (imageScrollWrapper) {
        imageScrollWrapper.style.transform = `translateY(${translateY}px)`;
        imageScrollWrapper.style.opacity = Math.max(opacity, 0.85);
    }
    
    ticking = false;
}

window.addEventListener('scroll', () => {
    if (!ticking) {
        requestAnimationFrame(updateImageScroll);
        ticking = true;
    }
}, { passive: true });

updateImageScroll();


// ==========================================
// 3️⃣ معرض الصور
// ==========================================
let currentImage = 0;
const totalImages = {{ $product->images->count() }};

function showImage(index) {
    const slides = document.querySelectorAll('.gallery-slide');
    const dots = document.querySelectorAll('.gallery-dot');
    const counter = document.getElementById('imageCounter');
    
    slides.forEach((slide, i) => {
        if (i === index) {
            slide.classList.remove('opacity-0');
            slide.classList.add('opacity-100');
        } else {
            slide.classList.remove('opacity-100');
            slide.classList.add('opacity-0');
        }
    });

    dots.forEach((dot, i) => {
        if (i === index) {
            dot.classList.remove('bg-white/50', 'w-2', 'md:w-2.5');
            dot.classList.add('bg-white', 'w-6', 'md:w-8');
        } else {
            dot.classList.remove('bg-white', 'w-6', 'md:w-8');
            dot.classList.add('bg-white/50', 'w-2', 'md:w-2.5');
        }
    });

    if (counter) counter.textContent = index + 1;
    currentImage = index;
}

function nextImage() { 
    if(totalImages > 1) showImage((currentImage + 1) % totalImages); 
}

function prevImage() { 
    if(totalImages > 1) showImage((currentImage - 1 + totalImages) % totalImages); 
}

@if($product->images->count() > 1)
let autoSlide = setInterval(nextImage, 5000);

const gallery = document.getElementById('imageGallery');
gallery?.addEventListener('mouseenter', () => clearInterval(autoSlide));
gallery?.addEventListener('mouseleave', () => autoSlide = setInterval(nextImage, 6000));
gallery?.addEventListener('touchstart', () => clearInterval(autoSlide), { passive: true });
gallery?.addEventListener('touchend', () => autoSlide = setInterval(nextImage, 6000));
@endif


// ==========================================
// 4️⃣ تأثير الظهور التدريجي
// ==========================================
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

document.querySelectorAll('.stagger-item').forEach(el => observer.observe(el));


// ==========================================
// 5️⃣ دعم لوحة المفاتيح
// ==========================================
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight') { e.preventDefault(); nextImage(); }
    else if (e.key === 'ArrowLeft') { e.preventDefault(); prevImage(); }
});
</script>
@endsection