@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    :root {
        --primary: #8b5cf6;
        --primary-light: #ddd6fe;
        --primary-glow: rgba(139, 92, 246, 0.15);
        --secondary: #f59e0b;
        --secondary-light: #fde68a;
        --dark: #0f172a;
        --dark-light: #1e293b;
        --gray: #64748b;
        --light: #f8fafc;
        --white: #ffffff;
        --danger: #ef4444;
        --danger-light: #fee2e2;
        --warning: #f59e0b;
        --warning-light: #fef3c7;
        --success: #10b981;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
        color: var(--dark);
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* ====== خلفية متحركة ====== */
    .luxury-bg {
        position: fixed;
        inset: 0;
        z-index: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .luxury-bg .glow-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(100px);
        opacity: 0.5;
        animation: orb-float 25s infinite ease-in-out;
    }

    .glow-1 {
        width: 500px;
        height: 500px;
        background: linear-gradient(135deg, var(--primary-light), #c4b5fd);
        top: -200px;
        right: -100px;
        animation-delay: 0s;
    }

    .glow-2 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, var(--secondary-light), #fcd34d);
        bottom: -100px;
        left: -100px;
        animation-delay: -8s;
    }

    .glow-3 {
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, #bfdbfe, #93c5fd);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation-delay: -16s;
    }

    @keyframes orb-float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -40px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }

    /* ====== المحتوى ====== */
    .wrapper {
        position: relative;
        z-index: 1;
    }

    /* ====== Header فاخر ====== */
    .luxury-header {
        background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,255,255,0.7));
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(139, 92, 246, 0.1);
        padding: 1.5rem 0;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .header-inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .breadcrumb-lux {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--primary);
    }

    .breadcrumb-lux a {
        color: var(--primary);
        text-decoration: none;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .breadcrumb-lux a:hover {
        color: var(--secondary);
        transform: translateX(-3px);
    }

    .breadcrumb-sep {
        color: var(--gray);
        opacity: 0.5;
    }

    .page-title-lux {
        font-size: clamp(1.3rem, 3vw, 1.8rem);
        font-weight: 900;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .lux-badge {
        background: linear-gradient(135deg, var(--primary), #7c3aed);
        color: white;
        font-size: 0.7rem;
        font-weight: 900;
        padding: 0.4rem 1rem;
        border-radius: 100px;
        box-shadow: 0 4px 15px var(--primary-glow);
        animation: badge-pulse 2s infinite;
    }

    @keyframes badge-pulse {
        0%, 100% { box-shadow: 0 4px 15px var(--primary-glow); }
        50% { box-shadow: 0 4px 25px rgba(139, 92, 246, 0.3); }
    }

    .btn-back-lux {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        border: 2px solid var(--primary-light);
        border-radius: 1rem;
        color: var(--primary);
        font-size: 0.85rem;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .btn-back-lux:hover {
        background: linear-gradient(135deg, var(--primary), #7c3aed);
        color: white;
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px var(--primary-glow);
    }

    .btn-back-lux svg {
        width: 18px;
        height: 18px;
        transition: transform 0.3s;
    }

    .btn-back-lux:hover svg {
        transform: translateX(-4px);
    }

    /* ====== شبكة المنتجات ====== */
    .products-luxury {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        padding: 3rem 2rem 5rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ====== بطاقة فاخرة ====== */
    .lux-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        border-radius: 2rem;
        padding: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 
            0 4px 6px -1px rgba(0, 0, 0, 0.05),
            0 20px 40px -10px rgba(139, 92, 246, 0.08);
        transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }

    .lux-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary), var(--primary));
        background-size: 200% 100%;
        animation: shimmer-bar 3s infinite;
        z-index: 10;
    }

    @keyframes shimmer-bar {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .lux-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 
            0 30px 60px -15px rgba(139, 92, 246, 0.15),
            0 10px 20px -5px rgba(139, 92, 246, 0.1);
        border-color: var(--primary-light);
    }

    /* ====== صورة المنتج ====== */
    .lux-img-box {
        aspect-ratio: 1 / 1;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border-radius: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        overflow: hidden;
        position: relative;
    }

    .lux-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.7s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .lux-card:hover .lux-img-box img {
        transform: scale(1.1);
    }

    /* تأثير الإطار الذهبي عند الهوفر */
    .lux-img-box::after {
        content: '';
        position: absolute;
        inset: 0;
        border: 3px solid transparent;
        border-radius: 1.5rem;
        transition: all 0.5s;
        pointer-events: none;
    }

    .lux-card:hover .lux-img-box::after {
        border-color: var(--secondary);
    }

    /* ====== شارة التوفر الفاخرة ====== */
    .lux-stock {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.4rem 1rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 900;
        z-index: 10;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 0.4rem;
        animation: stock-slide 0.5s ease;
    }

    @keyframes stock-slide {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .lux-stock::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: stock-dot 2s infinite;
    }

    .lux-stock.low {
        color: var(--warning);
        border: 1px solid var(--warning-light);
    }

    .lux-stock.low::before {
        background: var(--warning);
    }

    .lux-stock.out {
        color: var(--danger);
        border: 1px solid var(--danger-light);
    }

    .lux-stock.out::before {
        background: var(--danger);
        animation: none;
    }

    @keyframes stock-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.8); }
    }

    /* ====== الصور المصغرة الفاخرة ====== */
    .lux-thumbs {
        display: flex;
        gap: 0.6rem;
        margin-bottom: 1.25rem;
        overflow-x: auto;
        scrollbar-width: none;
        padding: 0.25rem;
    }

    .lux-thumbs::-webkit-scrollbar {
        display: none;
    }

    .lux-thumb {
        width: 48px;
        height: 48px;
        border-radius: 1rem;
        overflow: hidden;
        border: 2px solid transparent;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        position: relative;
    }

    .lux-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .lux-thumb::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--primary-glow), transparent);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .lux-thumb:hover,
    .lux-thumb.active {
        border-color: var(--primary);
        transform: scale(1.15) translateY(-3px);
        box-shadow: 0 8px 20px var(--primary-glow);
    }

    .lux-thumb:hover::after,
    .lux-thumb.active::after {
        opacity: 1;
    }

    /* ====== معلومات المنتج ====== */
    .lux-info {
        text-align: right;
        flex-grow: 1;
        margin-bottom: 1.25rem;
    }

    .lux-name {
        font-size: 1.1rem;
        font-weight: 900;
        color: var(--dark);
        margin-bottom: 0.6rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s;
    }

    .lux-card:hover .lux-name {
        color: var(--primary);
    }

    .lux-desc {
        font-size: 0.85rem;
        color: var(--gray);
        line-height: 1.7;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ====== زر فاخر ====== */
    .lux-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 100%);
        color: white;
        border-radius: 1.25rem;
        font-size: 0.9rem;
        font-weight: 900;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        margin-top: auto;
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
    }

    .lux-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s;
    }

    .lux-btn:hover::before {
        left: 100%;
    }

    .lux-btn:hover {
        background: linear-gradient(135deg, var(--primary) 0%, #7c3aed 100%);
        transform: translateY(-3px);
        box-shadow: 0 15px 35px var(--primary-glow);
    }

    .lux-btn svg {
        width: 18px;
        height: 18px;
        transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .lux-btn:hover svg {
        transform: translateX(-5px) scale(1.1);
    }

    /* ====== فارغ فاخر ====== */
    .lux-empty {
        text-align: center;
        padding: 8rem 2rem;
        grid-column: 1 / -1;
    }

    .lux-empty-orb {
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, var(--primary-glow), transparent 70%);
        border-radius: 50%;
        margin: 0 auto 2rem;
        animation: empty-float 4s ease-in-out infinite;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
    }

    @keyframes empty-float {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-15px) scale(1.05); }
    }

    .lux-empty h3 {
        font-size: 1.5rem;
        font-weight: 900;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .lux-empty p {
        color: var(--gray);
        font-size: 0.9rem;
    }

    /* ====== تأثير الظهور ====== */
    .lux-reveal {
        opacity: 0;
        transform: translateY(40px) scale(0.95);
        transition: all 0.7s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .lux-reveal.visible {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    /* ====== Scrollbar فاخر ====== */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: var(--light); }
    ::-webkit-scrollbar-thumb { background: linear-gradient(var(--primary), #7c3aed); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: linear-gradient(#7c3aed, var(--primary)); }

    /* ====== استجابة ====== */
    @media (max-width: 1024px) {
        .products-luxury {
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .header-inner {
            flex-direction: column;
            text-align: center;
            padding: 0 1rem;
        }

        .page-title-lux {
            justify-content: center;
            font-size: 1.2rem;
        }

        .btn-back-lux {
            width: 100%;
            justify-content: center;
        }

        .products-luxury {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            padding: 2rem 1rem 4rem;
        }

        .lux-card {
            border-radius: 1.5rem;
            padding: 1rem;
        }

        .lux-img-box {
            border-radius: 1.25rem;
        }

        .lux-thumb {
            width: 40px;
            height: 40px;
            border-radius: 0.75rem;
        }

        .lux-btn {
            padding: 0.85rem;
            font-size: 0.8rem;
            border-radius: 1rem;
        }
    }

    @media (max-width: 480px) {
        .products-luxury {
            grid-template-columns: 1fr;
        }

        .lux-card {
            border-radius: 1.25rem;
        }

        .lux-name {
            font-size: 1rem;
        }

        .lux-stock {
            font-size: 0.65rem;
            padding: 0.3rem 0.75rem;
        }
    }

    /* تقليل الحركة */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<!-- خلفية متحركة -->
<div class="luxury-bg">
    <div class="glow-orb glow-1"></div>
    <div class="glow-orb glow-2"></div>
    <div class="glow-orb glow-3"></div>
</div>

<div class="wrapper">
    <!-- Header -->
    <div class="luxury-header">
        <div class="header-inner">
            <div>
                <div class="breadcrumb-lux">
                    <a href="{{ route('home') }}">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        الرئيسية
                    </a>
                    <span class="breadcrumb-sep">›</span>
                    <span style="color: var(--gray);">{{ $category->name }}</span>
                </div>
                <h1 class="page-title-lux">
                    {{ $category->name }}
                    <span class="lux-badge">{{ $products->count() }} منتج</span>
                </h1>
            </div>

            <a href="{{ route('home') }}" class="btn-back-lux">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
                العودة للأقسام
            </a>
        </div>
    </div>

    <!-- المنتجات -->
    <div class="products-luxury" dir="rtl">
        @if($products->count() > 0)
            @foreach($products as $index => $product)
            <div class="lux-card lux-reveal" style="transition-delay: {{ $index * 0.08 }}s">

                <!-- شارة التوفر -->
                @if(($product->stock ?? 0) > 0 && ($product->stock ?? 0) < 5)
                    <span class="lux-stock low">
                        <span></span>
                        أوشك على النفاذ
                    </span>
                @elseif(($product->stock ?? 0) == 0)
                    <span class="lux-stock out">
                        <span></span>
                        نفذت الكمية
                    </span>
                @endif

                <!-- الصورة الرئيسية -->
                <div class="lux-img-box">
                    @if($product->images->count() > 0)
                        <img src="{{ asset('storage/'.$product->images->first()->image) }}" 
                             id="main-img-{{ $product->id }}" 
                             alt="{{ $product->name }}"
                             loading="lazy">
                    @else
                        <div style="color: #cbd5e1; font-size: 0.9rem; font-weight: 700;">لا توجد صورة</div>
                    @endif
                </div>

                <!-- الصور المصغرة -->
                @if($product->images->count() > 1)
                <div class="lux-thumbs">
                    @foreach($product->images->take(4) as $imgIndex => $img)
                        <div class="lux-thumb {{ $imgIndex == 0 ? 'active' : '' }} t-group-{{ $product->id }}" 
                             onclick="updateImage('{{ $product->id }}', '{{ asset('storage/'.$img->image) }}', this)">
                            <img src="{{ asset('storage/'.$img->image) }}" alt="" loading="lazy">
                        </div>
                    @endforeach
                </div>
                @endif

                <!-- المعلومات -->
                <div class="lux-info">
                    <h3 class="lux-name">{{ $product->name }}</h3>
                    <p class="lux-desc">{{ $product->description }}</p>
                </div>

                <!-- زر الطلب -->
                <a href="{{ route('product.show', $product->id) }}" class="lux-btn">
                    <span>عرض التفاصيل</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

            </div>
            @endforeach
        @else
            <div class="lux-empty">
                <div class="lux-empty-orb">📦</div>
                <h3>لا توجد منتجات</h3>
                <p>سيتم إضافة منتجات جديدة قريباً</p>
            </div>
        @endif
    </div>
</div>

<script>
// تبديل الصورة
function updateImage(prodId, newSrc, element) {
    const mainImg = document.getElementById('main-img-' + prodId);
    if (!mainImg) return;

    mainImg.style.transform = 'scale(0.9)';
    mainImg.style.opacity = '0';

    setTimeout(() => {
        mainImg.src = newSrc;
        mainImg.style.transform = 'scale(1)';
        mainImg.style.opacity = '1';
    }, 200);

    document.querySelectorAll('.t-group-' + prodId).forEach(el => el.classList.remove('active'));
    element.classList.add('active');
}

// تأثير الظهور
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });

document.querySelectorAll('.lux-reveal').forEach(el => observer.observe(el));
</script>
@endsection