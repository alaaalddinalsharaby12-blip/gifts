@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&display=swap');

    :root {
        --primary: #d63384;
        --primary-light: #fce4ec;
        --primary-glow: rgba(214,51,132,0.25);
        --gold: #c8963e;
        --gold-light: #fdf2e0;
        --dark: #1a1a1a;
        --white: #ffffff;
        --bg: #fdf8f5;
        --card-min: 220px;
        --gap: 1rem;
        --radius: 18px;
        --shadow: 0 4px 20px rgba(0,0,0,0.03);
        --shadow-hover: 0 16px 40px rgba(214,51,132,0.13);
        --transition: 0.5s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .categories-page {
        font-family: 'Tajawal', sans-serif;
        background: var(--bg);
        color: var(--dark);
        overflow-x: hidden;
        -webkit-tap-highlight-color: transparent;
        width: 100%;
        max-width: 100vw;
    }

    .categories-page * {
        box-sizing: border-box;
        max-width: 100%;
    }

    /* ====== خلفية ====== */
    .bg-luxury {
        position: fixed;
        inset: 0;
        z-index: -1;
        pointer-events: none;
    }

    .bg-luxury::before {
        content: '';
        position: absolute;
        inset: 0;
        background: 
            radial-gradient(ellipse at 15% 20%, rgba(214,51,132,0.03) 0%, transparent 55%),
            radial-gradient(ellipse at 85% 75%, rgba(200,150,62,0.04) 0%, transparent 55%);
    }

    .bg-luxury::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 3 L20 37 M3 20 L37 20' stroke='%23e8ddd0' stroke-width='0.3' opacity='0.4'/%3E%3Ccircle cx='20' cy='20' r='0.6' fill='%23d4af37' opacity='0.2'/%3E%3C/svg%3E");
        background-size: 40px 40px;
        animation: bgDrift 40s linear infinite;
    }

    @keyframes bgDrift {
        from { background-position: 0 0; }
        to { background-position: 40px 40px; }
    }

    /* ====== أنيميشن ====== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes goldenPulse {
        0%, 100% { box-shadow: 0 4px 12px rgba(200,150,62,0.4); }
        50% { box-shadow: 0 4px 24px rgba(200,150,62,0.7); }
    }

    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-6px); }
    }

    /* ====== الهيدر ====== */
    .hero {
        text-align: center;
        padding: 2.5rem 1rem 1.5rem;
        animation: fadeInUp 0.8s ease forwards;
    }

    .hero-ornament {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        margin-bottom: 1rem;
    }

    .hero-ornament .line {
        width: 40px;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }

    .hero-ornament .icon {
        color: var(--gold);
        font-size: 0.45rem;
        opacity: 0.7;
        animation: float 3s ease-in-out infinite;
    }

    .hero-badge {
        display: inline-block;
        padding: 0.35rem 1.3rem;
        background: var(--white);
        border: 1px solid #f0e0e0;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--primary);
        letter-spacing: 1.5px;
        margin-bottom: 1.2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .hero-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(214,51,132,0.1);
    }

    .hero-title {
        font-family: 'Playfair Display', 'Tajawal', serif;
        font-size: clamp(1.8rem, 4.5vw, 3.5rem);
        font-weight: 800;
        color: var(--dark);
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }

    .hero-title .accent {
        color: var(--primary);
        font-style: italic;
        position: relative;
        display: inline-block;
    }

    .hero-title .accent::after {
        content: '';
        position: absolute;
        bottom: 4px;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--primary-light);
        border-radius: 2px;
        z-index: -1;
    }

    .hero-line {
        width: 50px;
        height: 1.5px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
        margin: 0.6rem auto;
    }

    .hero-desc {
        color: #999;
        font-size: 0.85rem;
        max-width: 420px;
        margin: 0 auto;
        line-height: 1.7;
    }

    /* ====== رأس الأقسام ====== */
    .section-head {
        text-align: center;
        padding: 1.5rem 1rem 0.5rem;
    }

    .section-head .overline {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 4px;
        color: var(--gold);
        font-weight: 700;
    }

    .section-head h2 {
        font-family: 'Playfair Display', 'Tajawal', serif;
        font-size: clamp(1.1rem, 2vw, 1.4rem);
        font-weight: 700;
        color: var(--dark);
        margin-top: 0.2rem;
    }

    /* ====== الشبكة - أقسام أصغر ====== */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(var(--card-min), 1fr));
        gap: var(--gap);
        padding: 1rem var(--gap) 4rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ====== البطاقة - حجم أصغر ====== */
    .category-card {
        position: relative;
        border-radius: var(--radius);
        overflow: visible;
        background: var(--white);
        box-shadow: var(--shadow);
        transition: all var(--transition);
        text-decoration: none;
        display: block;
        border: 1px solid rgba(0,0,0,0.03);
        outline: none;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    /* توهج خارجي */
    .category-card::before {
        content: '';
        position: absolute;
        inset: -2px;
        border-radius: calc(var(--radius) + 2px);
        background: linear-gradient(135deg, var(--primary-glow), transparent 50%, rgba(200,150,62,0.12));
        z-index: -1;
        opacity: 0;
        transition: opacity var(--transition);
    }

    .category-card:hover,
    .category-card:focus-visible {
        transform: translateY(-6px) scale(1.02);
        box-shadow: var(--shadow-hover);
    }

    .category-card:hover::before,
    .category-card:focus-visible::before {
        opacity: 1;
    }

    .category-card:focus-visible {
        outline: 3px solid var(--primary);
        outline-offset: 4px;
    }

    /* تأثير الضغط */
    .category-card:active {
        transform: scale(0.97);
        transition: transform 0.1s ease;
    }

    /* ====== حاوية الصورة/الفيديو - أصغر ====== */
    .media-box {
        position: relative;
        aspect-ratio: 3/4;
        overflow: hidden;
        background: #f5f5f5;
        border-radius: var(--radius) var(--radius) 0 0;
    }

    .media-box img,
    .media-box video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.5s ease, transform 0.7s ease;
    }

    .media-box img {
        opacity: 1;
        z-index: 2;
    }

    .media-box video {
        opacity: 0;
        z-index: 1;
    }

    /* hover/focus = فيديو يظهر */
    .category-card:hover .media-box video,
    .category-card:focus-visible .media-box video {
        opacity: 1;
    }

    .category-card:hover .media-box img,
    .category-card:focus-visible .media-box img {
        opacity: 0;
    }

    /* Zoom ناعم */
    .category-card:hover .media-box img,
    .category-card:focus-visible .media-box img,
    .category-card:hover .media-box video,
    .category-card:focus-visible .media-box video {
        transform: scale(1.05);
    }

    /* تدرج أسفل */
    .media-box::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, transparent 55%);
        z-index: 3;
        pointer-events: none;
    }

    /* ====== أيقونة التشغيل ====== */
    .play-indicator {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 4;
        opacity: 0.65;
        transition: all 0.35s ease;
        pointer-events: none;
        box-shadow: 0 4px 14px rgba(0,0,0,0.1);
    }

    .play-indicator svg {
        width: 14px;
        height: 14px;
        color: var(--primary);
        margin-left: 1px;
    }

    .category-card:hover .play-indicator,
    .category-card:focus-visible .play-indicator {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.3);
    }

    .category-card.video-active .play-indicator {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.3);
    }

    /* ====== اسم القسم ====== */
    .card-title {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        color: white;
        font-size: clamp(0.9rem, 2vw, 1.1rem);
        font-weight: 800;
        z-index: 4;
        text-shadow: 0 2px 8px rgba(0,0,0,0.5);
        transition: transform 0.35s ease, padding 0.35s ease;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .category-card:hover .card-title,
    .category-card:focus-visible .card-title {
        transform: translateY(-3px);
        padding-bottom: 1.3rem;
    }

    /* ====== عداد المنتجات ====== */
    .product-badge {
        position: absolute;
        top: 0.6rem;
        right: 0.6rem;
        padding: 0.2rem 0.7rem;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 800;
        color: var(--primary);
        z-index: 4;
        box-shadow: 0 3px 10px rgba(0,0,0,0.06);
        border: 1px solid rgba(255,255,255,0.4);
        transition: all 0.35s ease;
        white-space: nowrap;
    }

    .category-card:hover .product-badge,
    .category-card:focus-visible .product-badge {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: scale(1.05);
    }

    /* ====== سهم ====== */
    .arrow-icon {
        position: absolute;
        top: 0.6rem;
        left: 0.6rem;
        width: 30px;
        height: 30px;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 4;
        opacity: 0;
        transform: translateX(-6px) rotate(-10deg);
        transition: all 0.35s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .arrow-icon svg {
        width: 12px;
        height: 12px;
        color: var(--primary);
        transition: transform 0.3s ease;
    }

    .category-card:hover .arrow-icon,
    .category-card:focus-visible .arrow-icon {
        opacity: 1;
        transform: translateX(0) rotate(0deg);
    }

    .category-card:hover .arrow-icon svg,
    .category-card:focus-visible .arrow-icon svg {
        transform: translateX(2px);
    }

    /* ====== وسم "جديد" ====== */
    .new-badge {
        position: absolute;
        top: 0.6rem;
        left: 50%;
        transform: translateX(-50%);
        padding: 2px 12px;
        background: var(--gold);
        color: #fff;
        font-size: 0.6rem;
        font-weight: 800;
        letter-spacing: 2px;
        border-radius: 50px;
        z-index: 5;
        text-transform: uppercase;
        box-shadow: 0 3px 10px rgba(200,150,62,0.4);
        animation: goldenPulse 2.5s ease-in-out infinite;
        white-space: nowrap;
    }

    /* ====== رسالة الصور المتعددة ====== */
    .images-count-badge {
        position: absolute;
        bottom: 0.6rem;
        right: 0.6rem;
        z-index: 4;
        padding: 3px 8px;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        border-radius: 6px;
        color: #fff;
        font-size: 0.6rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.2rem;
        transition: all 0.3s ease;
    }

    .images-count-badge svg {
        width: 10px;
        height: 10px;
    }

    .category-card:hover .images-count-badge,
    .category-card:focus-visible .images-count-badge {
        opacity: 0;
        transform: translateY(5px);
    }

    /* ====== فارغ ====== */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        animation: fadeInUp 0.6s ease forwards;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 1.8rem;
        animation: float 3s ease-in-out infinite;
    }

    .empty-state h3 {
        color: var(--dark);
        font-weight: 700;
        margin-bottom: 0.3rem;
    }

    .empty-state p {
        color: #ccc;
        font-size: 0.8rem;
    }

    /* ====== سكرول بار ====== */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #e0d5c5; border-radius: 10px; }

    /* =========================== */
    /* 📱 الموبايل                 */
    /* =========================== */
    @media (max-width: 480px) {
        :root {
            --card-min: 155px;
            --gap: 0.6rem;
            --radius: 14px;
        }

        .categories-grid {
            grid-template-columns: repeat(2, 1fr);
            max-width: 100%;
            padding: 0.5rem 0.5rem 3rem;
            margin: 0;
        }

        .hero {
            padding: 1.5rem 0.8rem 0.5rem;
        }

        .hero-badge {
            font-size: 0.58rem;
            padding: 0.25rem 0.8rem;
            letter-spacing: 1px;
        }

        .hero-title {
            font-size: 1.4rem !important;
        }

        .hero-desc {
            font-size: 0.7rem;
        }

        .media-box {
            aspect-ratio: 4/5;
        }

        .card-title {
            padding: 0.6rem;
            font-size: 0.75rem;
        }

        .product-badge {
            top: 0.4rem;
            right: 0.4rem;
            font-size: 0.58rem;
            padding: 0.15rem 0.5rem;
        }

        .arrow-icon {
            top: 0.4rem;
            left: 0.4rem;
            width: 24px;
            height: 24px;
            opacity: 0.75;
            transform: translateX(0) rotate(0deg);
            border-radius: 6px;
        }

        .arrow-icon svg {
            width: 10px;
            height: 10px;
        }

        .new-badge {
            top: 0.4rem;
            font-size: 0.52rem;
            padding: 1px 8px;
            letter-spacing: 1px;
        }

        .play-indicator {
            width: 30px;
            height: 30px;
        }

        .play-indicator svg {
            width: 10px;
            height: 10px;
        }

        .images-count-badge {
            bottom: 0.4rem;
            right: 0.4rem;
            font-size: 0.55rem;
            padding: 2px 6px;
        }
    }

    @media (max-width: 360px) {
        :root { --card-min: 140px; --gap: 0.4rem; }
        .card-title { font-size: 0.7rem; }
        .product-badge { font-size: 0.55rem; }
    }

    @media (min-width: 481px) and (max-width: 640px) {
        :root { --card-min: 170px; --gap: 0.7rem; }
        .categories-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (min-width: 641px) and (max-width: 900px) {
        :root { --card-min: 200px; --gap: 0.9rem; }
        .categories-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (min-width: 901px) and (max-width: 1200px) {
        :root { --card-min: 220px; }
        .categories-grid { grid-template-columns: repeat(4, 1fr); }
    }

    @media (min-width: 1201px) {
        :root { --card-min: 240px; }
    }

    @media (min-width: 1600px) {
        :root { --card-min: 270px; --gap: 1.4rem; }
    }

    /* ====== موبايل: اللمس ====== */
    @media (hover: none) and (pointer: coarse) {
        .category-card:hover {
            transform: none;
            box-shadow: var(--shadow);
        }

        .category-card:hover::before {
            opacity: 0;
        }

        .category-card:hover .media-box video,
        .category-card:focus-visible .media-box video {
            opacity: 0;
        }

        .category-card:hover .media-box img,
        .category-card:focus-visible .media-box img {
            opacity: 1;
            transform: none;
        }

        .category-card:hover .product-badge {
            background: rgba(255,255,255,0.95);
            color: var(--primary);
            border-color: rgba(255,255,255,0.4);
            transform: none;
        }

        .category-card:hover .card-title {
            transform: none;
            padding-bottom: 1rem;
        }

        .play-indicator {
            pointer-events: auto;
            cursor: pointer;
        }

        .category-card:active {
            transform: scale(0.95);
            transition: transform 0.1s ease;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<div class="categories-page min-h-screen">
    <div class="bg-luxury"></div>

    <!-- ====== وصف المنصة ====== -->
    <section class="hero">
        <div class="hero-ornament">
            <span class="line"></span>
            <span class="icon">◆</span>
            <span class="line"></span>
        </div>
        <div class="hero-badge">✦ هدايا فاخرة لمناسباتكم ✦</div>
        <h1 class="hero-title">
            نُهدي لحظاتكم<br>
            <span class="accent">لمسة من الفخامة</span>
        </h1>
        <div class="hero-line"></div>
        <p class="hero-desc">
            نصنع لكم صناديق هدايا استثنائية بتفاصيل دقيقة، لتكون شاهدة على أجمل لحظات حياتكم
        </p>
    </section>

    <!-- ====== الأقسام ====== -->
    @if($categories->count() == 0)
        <div class="empty-state">
            <div class="empty-icon">🎁</div>
            <h3>لا توجد أقسام حالياً</h3>
            <p>نعمل على تجهيز مجموعات مميزة لكم</p>
        </div>
    @else
        <div class="section-head">
            <p class="overline">المجموعات</p>
            <h2>اختر التصميم المثالي لمناسبتكم</h2>
        </div>

        <div class="categories-grid">
            @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat->id) }}" 
                   class="category-card"
                   style="animation-delay: {{ $loop->index * 0.08 }}s"
                   aria-label="تصفح قسم {{ $cat->name }} - {{ $cat->products_count ?? 0 }} منتج"
                   tabindex="0">

                    <div class="media-box">
                        <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}" loading="lazy">

                        @if($cat->video)
                            <video muted loop playsinline preload="none">
                                <source src="{{ asset('storage/'.$cat->video) }}" type="video/mp4">
                            </video>
                            <span class="play-indicator">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </span>
                        @endif

                        @if($cat->is_new ?? false)
                            <span class="new-badge">جديد</span>
                        @endif

                        <!-- عداد متعدد الصور -->
                        @if(($cat->images_count ?? 0) > 1)
                            <span class="images-count-badge">
                                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M4 5h13v7h2V5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v-2H4V5zm16 10h2v4h-2v-4zm-4-7H8v2h8V8zM8 12h8v2H8v-2zm7 8h2v-2h3v-2h-3v-2h-2v2h-2v2h2v2z"/></svg>
                                                                {{ $cat->images_count }}
                            </span>
                        @endif

                        <span class="product-badge">
                            {{ $cat->products_count ?? 0 }} منتج
                        </span>

                        <span class="arrow-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>

                        <span class="card-title">{{ $cat->name }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    
    const cards = document.querySelectorAll('.category-card');
    const isTouchDevice = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);

    cards.forEach(card => {
        const video = card.querySelector('video');
        const playIndicator = card.querySelector('.play-indicator');
        
        if (!video) return;

        if (!isTouchDevice) {
            
            card.addEventListener('mouseenter', () => {
                video.play().then(() => card.classList.add('video-active')).catch(() => {});
            });

            card.addEventListener('mouseleave', () => {
                video.pause();
                video.currentTime = 0;
                card.classList.remove('video-active');
            });

            card.addEventListener('focus', () => {
                video.play().then(() => card.classList.add('video-active')).catch(() => {});
            });

            card.addEventListener('blur', () => {
                video.pause();
                video.currentTime = 0;
                card.classList.remove('video-active');
            });

        } else {
            if (playIndicator) {
                playIndicator.style.pointerEvents = 'auto';
                playIndicator.style.cursor = 'pointer';
                
                playIndicator.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (card.classList.contains('video-active')) {
                        video.pause();
                        video.currentTime = 0;
                        card.classList.remove('video-active');
                    } else {
                        cards.forEach(c => {
                            if (c !== card) {
                                const v = c.querySelector('video');
                                if (v && !v.paused) {
                                    v.pause();
                                    v.currentTime = 0;
                                    c.classList.remove('video-active');
                                }
                            }
                        });
                        video.play().then(() => card.classList.add('video-active')).catch(() => {});
                    }
                });
            }
        }

        video.addEventListener('ended', () => {
            card.classList.remove('video-active');
            video.currentTime = 0;
        });

        new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting && !video.paused) {
                    video.pause();
                    video.currentTime = 0;
                    card.classList.remove('video-active');
                }
            });
        }, { threshold: 0.5 }).observe(card);
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            cards.forEach(card => {
                const v = card.querySelector('video');
                if (v && !v.paused) {
                    v.pause();
                    v.currentTime = 0;
                    card.classList.remove('video-active');
                }
            });
        }
    });
    
});
</script>
@endsection