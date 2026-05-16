@extends('layouts.app')

@section('content')
@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
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
            position: relative;
        }

        .categories-page * {
            box-sizing: border-box;
            max-width: 100%;
        }

        /* ====== خلفية عامة ====== */
        .bg-pattern {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 3 L20 37 M3 20 L37 20' stroke='%23e8ddd0' stroke-width='0.3' opacity='0.4'/%3E%3Ccircle cx='20' cy='20' r='0.6' fill='%23d4af37' opacity='0.2'/%3E%3C/svg%3E");
            background-size: 40px 40px;
        }

        /* ====== 🌍 صور عائمة في كامل الصفحة ====== */
        .floating-bg {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
        }

        .floating-bg img {
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            object-fit: cover;
            opacity: 1.9;
            filter: blur(1px) grayscale(10%) brightness(1.0);
            will-change: transform;
        }

        .floating-bg .img-left {
            top: -15%;
            left: -8%;
            animation: floatLeft 25s ease-in-out infinite;
        }

        .floating-bg .img-right {
            bottom: -20%;
            right: -6%;
            animation: floatRight 30s ease-in-out infinite;
            animation-delay: -12s;
        }

        .floating-bg .img-bottom-left {
            bottom: -15%;
            left: 5%;
            animation: floatBottomLeft 28s ease-in-out infinite;
            animation-delay: -5s;
        }

        .floating-bg .img-top-right {
            top: -10%;
            right: -5%;
            animation: floatTopRight 32s ease-in-out infinite;
            animation-delay: -18s;
        }

        @keyframes floatLeft {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            25% { transform: translate(150px, 80px) rotate(8deg) scale(1.12); }
            50% { transform: translate(50px, 160px) rotate(-4deg) scale(0.94); }
            75% { transform: translate(-80px, 40px) rotate(12deg) scale(1.08); }
        }

        @keyframes floatRight {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            25% { transform: translate(-140px, -100px) rotate(-10deg) scale(1.1); }
            50% { transform: translate(-30px, -180px) rotate(6deg) scale(0.92); }
            75% { transform: translate(100px, -60px) rotate(-8deg) scale(1.06); }
        }

        @keyframes floatBottomLeft {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            25% { transform: translate(100px, -60px) rotate(-5deg) scale(1.08); }
            50% { transform: translate(60px, -120px) rotate(4deg) scale(0.95); }
            75% { transform: translate(-40px, -30px) rotate(-8deg) scale(1.05); }
        }

        @keyframes floatTopRight {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            25% { transform: translate(-80px, 70px) rotate(6deg) scale(1.1); }
            50% { transform: translate(-20px, 130px) rotate(-3deg) scale(0.93); }
            75% { transform: translate(50px, 40px) rotate(8deg) scale(1.07); }
        }

        /* تمويه على كامل الصفحة */
        .floating-overlay {
            position: fixed;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            background: 
                radial-gradient(ellipse at 15% 30%, rgba(253,248,245,0.92) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 70%, rgba(253,248,245,0.92) 0%, transparent 55%),
                radial-gradient(ellipse at 50% 50%, rgba(253,248,245,0.7) 0%, transparent 75%);
        }

        /* ====== 📌 سلايدر الهيدر (Swiper) ====== */
        .hero-slider {
            position: relative;
            z-index: 3;
            width: 100%;
            height: 80vh;
            min-height: 500px;
            max-height: 700px;
            overflow: hidden;
        }

        .hero-slider .swiper {
            width: 100%;
            height: 100%;
        }

        .hero-slider .swiper-slide {
            position: relative;
        }

        .hero-slider .slide-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.5;
            filter: brightness(0.6);
        }

        .hero-slider .slide-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(0,0,0,0.3) 0%,
                rgba(0,0,0,0.15) 40%,
                rgba(0,0,0,0.5) 80%,
                rgba(0,0,0,0.8) 100%
            );
            z-index: 1;
        }

        .hero-slider .slide-content {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes goldenPulse {
            0%, 100% { box-shadow: 0 4px 12px rgba(200,150,62,0.4); }
            50% { box-shadow: 0 4px 24px rgba(200,150,62,0.7); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }

        .hero-ornament {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
        }

        .hero-ornament .line {
            width: 50px;
            height: 1.5px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .hero-ornament .icon {
            color: var(--gold);
            font-size: 0.5rem;
            opacity: 0.9;
            animation: float 3s ease-in-out infinite;
        }

        .hero-badge {
            display: inline-block;
            padding: 0.4rem 1.5rem;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(214,51,132,0.2);
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 2px;
            margin-bottom: 1.2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .hero-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(214,51,132,0.1);
        }

        .hero-title {
            font-family: 'Playfair Display', 'Tajawal', serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.5;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 15px rgba(0,0,0,0.4);
        }

        .hero-line {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 0.8rem auto;
        }

        .hero-desc {
            color: rgba(255,255,255,0.95);
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto 0.8rem;
            line-height: 1.9;
            text-shadow: 0 1px 8px rgba(0,0,0,0.4);
        }

        .section-head {
        text-align: center;
        padding: 1.5rem 1rem 0.5rem;
        position: relative;
        z-index: 4;
        background: var(--bg);
    }

        .section-head h2 {
            font-family: 'Playfair Display', 'Tajawal', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gold);
            margin-top: 0.2rem;
        }

        /* ====== أزرار التنقل - مصلحة ====== */
        .hero-slider .swiper-button-next,
        .hero-slider .swiper-button-prev {
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1.5px solid rgba(214, 51, 132, 0.2);
            color: var(--primary);
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            box-shadow: 0 3px 14px rgba(0, 0, 0, 0.08);
            z-index: 10;
            margin: 0;
        }

        .hero-slider .swiper-button-next:hover,
        .hero-slider .swiper-button-prev:hover {
            background: #fff;
            border-color: var(--primary);
            box-shadow: 0 6px 24px rgba(214, 51, 132, 0.15);
            transform: translateY(-50%) scale(1.08) !important;
        }

        .hero-slider .swiper-button-next::after,
        .hero-slider .swiper-button-prev::after {
            font-size: 1rem;
            font-weight: bold;
        }

        .hero-slider .swiper-button-next {
            right: 20px !important;
            left: auto !important;
        }

        .hero-slider .swiper-button-prev {
            left: 20px !important;
            right: auto !important;
        }

        /* نقاط المؤشر */
        .hero-slider .swiper-pagination {
            bottom: 25px !important;
            z-index: 10;
        }

        .hero-slider .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
            background: rgba(255,255,255,0.5);
            opacity: 1;
            transition: all 0.4s ease;
            border: 2px solid transparent;
        }

        .hero-slider .swiper-pagination-bullet-active {
            background: var(--primary);
            border-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 0 12px rgba(214, 51, 132, 0.5);
            transform: scale(1.5);
        }

        /* ====== الشبكة ====== */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(var(--card-min), 1fr));
            gap: var(--gap);
            padding: 1.5rem var(--gap) 4rem;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 3;
        }

        /* ====== البطاقة ====== */
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

        .category-card:active {
            transform: scale(0.97);
            transition: transform 0.1s ease;
        }

        /* ====== حاوية الصورة/الفيديو ====== */
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

        .category-card:hover .media-box video,
        .category-card:focus-visible .media-box video {
            opacity: 1;
        }

        .category-card:hover .media-box img,
        .category-card:focus-visible .media-box img {
            opacity: 0;
        }

        .category-card:hover .media-box img,
        .category-card:focus-visible .media-box img,
        .category-card:hover .media-box video,
        .category-card:focus-visible .media-box video {
            transform: scale(1.05);
        }

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
            position: relative;
            z-index: 3;
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

            .floating-bg img {
                width: 200px;
                height: 200px;
            }

            .hero-slider {
                height: 70vh;
                min-height: 400px;
                max-height: 550px;
            }

            .hero-badge {
                font-size: 0.7rem;
                padding: 0.25rem 0.9rem;
                letter-spacing: 1px;
            }

            .hero-title {
                font-size: 1.3rem !important;
            }

            .hero-desc {
                font-size: 0.8rem;
                max-width: 300px;
            }

            .section-head h2 {
                font-size: 0.9rem;
                max-width: 280px;
            }

            .hero-slider .swiper-button-next,
            .hero-slider .swiper-button-prev {
                width: 34px;
                height: 34px;
            }

            .hero-slider .swiper-button-next::after,
            .hero-slider .swiper-button-prev::after {
                font-size: 0.75rem;
            }

            .hero-slider .swiper-button-next {
                right: 8px !important;
            }

            .hero-slider .swiper-button-prev {
                left: 8px !important;
            }

            .hero-slider .swiper-pagination {
                bottom: 15px !important;
            }

            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
                max-width: 100%;
                padding: 0.5rem 0.5rem 3rem;
                margin: 0;
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
@endpush

<div class="categories-page min-h-screen">
    {{-- خلفية عامة بنمط ناعم --}}
    <div class="bg-pattern"></div>

    {{-- ====== 🌍 صور عائمة في كامل الصفحة ====== --}}
        <div class="floating-bg">
            {{-- الصورة 1 - يسار --}}
            <img src="{{ Storage::disk(config('filesystems.default'))->url('images/bg-decoration-1.jpg') }}" 
                alt="" 
                class="img-left"
                aria-hidden="true"
                onerror="this.style.display='none'">
            
            {{-- الصورة 2 - يمين --}}
            <img src="{{ Storage::disk(config('filesystems.default'))->url('images/bg-decoration-2.jpg') }}" 
                alt="" 
                class="img-right"
                aria-hidden="true"
                onerror="this.style.display='none'">

            {{-- 🆕 الصورة 3 - يسار سفلي --}}
            <img src="{{ Storage::disk(config('filesystems.default'))->url('images/bg-decoration-7.jpg') }}" 
                alt="" 
                class="img-bottom-left"
                aria-hidden="true"
                onerror="this.style.display='none'">

            {{-- 🆕 الصورة 4 - يمين علوي --}}
            <img src="{{ Storage::disk(config('filesystems.default'))->url('images/bg-decoration-5.jpg') }}"
                alt="" 
                class="img-top-right"
                aria-hidden="true"
                onerror="this.style.display='none'">
        </div>

    {{-- تمويه على كامل الصفحة --}}
    <div class="floating-overlay"></div>

    {{-- ====== 📌 سلايدر الهيدر ====== --}}
    <section class="hero-slider">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                {{-- شريحة 1 --}}
                <div class="swiper-slide">
                    <img src="{{ Storage::disk(config('filesystems.default'))->url('images/bg-decoration-3.jpg') }}"
                         alt="" 
                         class="slide-image"
                         onerror="this.style.display='none'">
                    <div class="slide-overlay"></div>
                    <div class="slide-content">
                        <div class="hero-ornament">
                            <span class="line"></span>
                            <span class="icon">◆</span>
                            <span class="line"></span>
                        </div>
                        <div class="hero-badge">✦ JUST FOR YOU ✦</div>
                        <h1 class="hero-title">
                            نُخلد ذكرياتكم بلمسةٍ من الرقي والجمال
                        </h1>
                        <div class="hero-line"></div>
                        <p class="hero-desc">
                           لأن التفاصيل الجميلة هي من تُخلد للذكريات,
                           متجرنا يختصر عليك عناء البحث ويمنحك تفاصيل انيقة تليق بمناسبتك بكل رقي.
                        </p>
                        
                    </div>
                </div>

                {{-- شريحة 2 --}}
                <div class="swiper-slide">
                    <img src="{{ Storage::disk(config('filesystems.default'))->url('images/bg-decoration-4.jpg') }}"
                         alt="" 
                         class="slide-image"
                         onerror="this.style.display='none'">
                    <div class="slide-overlay"></div>
                    <div class="slide-content">
                        <div class="hero-ornament">
                            <span class="line"></span>
                            <span class="icon">◆</span>
                            <span class="line"></span>
                        </div>
                        <div class="hero-badge">✦ JUST FOR YOU ✦</div>
                        <h1 class="hero-title">
                            نُخلد ذكرياتكم بلمسةٍ من الرقي والجمال
                        </h1>
                        <div class="hero-line"></div>
                        <p class="hero-desc">
                           لأن التفاصيل الجميلة هي من تُخلد للذكريات,
                           متجرنا يختصر عليك عناء البحث ويمنحك تفاصيل انيقة تليق بمناسبتك بكل رقي.
                        </p>
                        
                    </div>
                </div>

                {{-- شريحة 3 --}}
                <div class="swiper-slide">
                    <img src="{{ Storage::disk(config('filesystems.default'))->url('images/bg-decoration-5.jpg') }}"
                         alt="" 
                         class="slide-image"
                         onerror="this.style.display='none'">
                    <div class="slide-overlay"></div>
                    <div class="slide-content">
                        <div class="hero-ornament">
                            <span class="line"></span>
                            <span class="icon">◆</span>
                            <span class="line"></span>
                        </div>
                        <div class="hero-badge">✦ JUST FOR YOU ✦</div>
                        <h1 class="hero-title">
                            نُخلد ذكرياتكم بلمسةٍ من الرقي والجمال
                        </h1>
                        <div class="hero-line"></div>
                        <p class="hero-desc">
                           لأن التفاصيل الجميلة هي من تُخلد للذكريات,
                           متجرنا يختصر عليك عناء البحث ويمنحك تفاصيل انيقة تليق بمناسبتك بكل رقي.
                        </p>
                    </div>
                </div>

                {{-- شريحة 4 --}}
                <div class="swiper-slide">
                    <img src="{{ Storage::disk(config('filesystems.default'))->url('images/bg-decoration-6.jpg') }}"
                         alt="" 
                         class="slide-image"
                         onerror="this.style.display='none'">
                    <div class="slide-overlay"></div>
                    <div class="slide-content">
                        <div class="hero-ornament">
                            <span class="line"></span>
                            <span class="icon">◆</span>
                            <span class="line"></span>
                        </div>
                        <div class="hero-badge">✦ JUST FOR YOU ✦</div>
                        <h1 class="hero-title">
                            نُخلد ذكرياتكم بلمسةٍ من الرقي والجمال
                        </h1>
                        <div class="hero-line"></div>
                        <p class="hero-desc">
                           لأن التفاصيل الجميلة هي من تُخلد للذكريات,
                           متجرنا يختصر عليك عناء البحث ويمنحك تفاصيل انيقة تليق بمناسبتك بكل رقي.
                        </p>
                    </div>
                </div>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
</section>
    <div class="section-head">
                            <h2>انتقِ بعناية... <br>
                                فكل قسم لدينا صيغ بذوق استثنائي, ليكون سبب حيرتك 
                            </h2>
                        </div>

    {{-- الأقسام --}}
    @if($categories->count() == 0)
        <div class="empty-state">
            <div class="empty-icon">🎁</div>
            <h3>لا توجد أقسام حالياً</h3>
            <p>نعمل على تجهيز مجموعات مميزة لكم</p>
        </div>
    @else
        <div class="categories-grid">
            @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat->id) }}" 
                   class="category-card"
                   style="animation-delay: {{ $loop->index * 0.08 }}s"
                   aria-label="تصفح قسم {{ $cat->name }} - {{ $cat->products_count ?? 0 }} منتج"
                   tabindex="0">

                    <div class="media-box">
                        <img src="{{ Storage::disk(config('filesystems.default'))->url($cat->image) }}"
                             alt="صورة قسم {{ $cat->name }}" 
                             loading="lazy"
                             onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';">

                        @if($cat->video)
                            <video muted loop playsinline preload="none"
                                   title="فيديو تعريفي لقسم {{ $cat->name }}"
                                   aria-label="فيديو تعريفي لقسم {{ $cat->name }}">
                                <source src="{{ Storage::disk(config('filesystems.default'))->url($cat->video) }}" type="video/mp4">
                            </video>
                            <span class="play-indicator" role="button" aria-label="تشغيل الفيديو">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </span>
                        @endif

                        @if($cat->is_new ?? false)
                            <span class="new-badge" role="status" aria-label="قسم جديد">جديد</span>
                        @endif

                        @if(($cat->images_count ?? 0) > 1)
                            <span class="images-count-badge" aria-label="عدد الصور {{ $cat->images_count }}">
                                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M4 5h13v7h2V5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v-2H4V5zm16 10h2v4h-2v-4zm-4-7H8v2h8V8zM8 12h8v2H8v-2zm7 8h2v-2h3v-2h-3v-2h-2v2h-2v2h2v2z"/></svg>
                                {{ $cat->images_count }}
                            </span>
                        @endif

                        <span class="product-badge" aria-label="عدد المنتجات {{ $cat->products_count ?? 0 }}">
                            {{ $cat->products_count ?? 0 }} منتج
                        </span>

                        <span class="arrow-icon" aria-hidden="true">
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

@once
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const swiper = new Swiper('.mySwiper', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true,
                },
                speed: 1000,
            });

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
    @endpush
@endonce
@endsection