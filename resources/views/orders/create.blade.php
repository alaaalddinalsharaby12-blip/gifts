@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #faf7f2 0%, #f5f0e8 100%);
        overflow-x: hidden;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(2deg); }
    }

    @keyframes pulse-ring {
        0% { transform: scale(0.8); opacity: 0.5; }
        100% { transform: scale(1.3); opacity: 0; }
    }

    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
        opacity: 0;
    }

    /* ====== Blobs خلفية ====== */
    .bg-blob {
        position: fixed;
        border-radius: 50%;
        filter: blur(100px);
        opacity: 0.06;
        pointer-events: none;
        z-index: 0;
    }

    .blob-1 {
        width: 500px;
        height: 500px;
        background: linear-gradient(135deg, #d63384, #f472b6);
        top: -10%;
        right: -10%;
        animation: float 12s ease-in-out infinite;
    }

    .blob-2 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, #a61e63, #db2777);
        bottom: -10%;
        left: -10%;
        animation: float 15s ease-in-out infinite reverse;
    }

    .blob-3 {
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, #f472b6, #fbcfe8);
        top: 40%;
        left: -5%;
        animation: float 18s ease-in-out infinite;
    }

    /* ====== الهيدر ====== */
    .page-header {
        text-align: center;
        padding: 2rem 1rem 1.5rem;
        position: relative;
        z-index: 10;
    }

    .header-icon-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .header-icon {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #fce7f3, #f8d7e8);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 15px 40px rgba(214, 51, 132, 0.15);
        position: relative;
        z-index: 2;
        transition: all 0.4s ease;
    }

    .header-icon-wrapper:hover .header-icon {
        transform: scale(1.1) rotate(-5deg);
        box-shadow: 0 20px 50px rgba(214, 51, 132, 0.25);
    }

    .header-pulse {
        position: absolute;
        inset: -8px;
        border-radius: 32px;
        background: linear-gradient(135deg, #d63384, #f472b6);
        opacity: 0.2;
        animation: pulse-ring 2s ease-out infinite;
        z-index: 1;
    }

    .header-icon svg {
        width: 32px;
        height: 32px;
        color: #d63384;
    }

    .page-title {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 900;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .page-subtitle {
        color: #a1a1aa;
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        font-weight: 500;
    }

    /* ====== البطاقة الرئيسية ====== */
    .luxury-form {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.06), 0 10px 30px rgba(214, 51, 132, 0.04);
        border-radius: 2rem;
        padding: clamp(1.25rem, 4vw, 2.5rem);
        position: relative;
        z-index: 10;
        transition: all 0.4s ease;
    }

    /* ====== خطوات التقدم ====== */
    .progress-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .progress-step {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .step-dot {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f4f4f5;
        color: #a1a1aa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 0.85rem;
        transition: all 0.4s ease;
        border: 2px solid transparent;
    }

    .step-dot.active {
        background: linear-gradient(135deg, #d63384, #a61e63);
        color: white;
        box-shadow: 0 4px 15px rgba(214, 51, 132, 0.3);
    }

    .step-dot.completed {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .step-line {
        width: 30px;
        height: 2px;
        background: #e4e4e7;
        border-radius: 1px;
        transition: all 0.4s ease;
    }

    .step-line.active {
        background: linear-gradient(90deg, #d63384, #a61e63);
    }

    .step-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #a1a1aa;
        text-align: center;
        margin-top: 0.25rem;
    }

    /* ====== عنوان القسم ====== */
    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f4f4f5;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #fce7f3, #fdf2f8);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .section-icon svg {
        width: 20px;
        height: 20px;
        color: #d63384;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 900;
        color: #1a1a1a;
    }

    .section-desc {
        font-size: 0.75rem;
        color: #a1a1aa;
        font-weight: 700;
    }

    /* ====== مجموعة الإدخال ====== */
    .input-group {
        background: #fafafa;
        border-radius: 1.25rem;
        padding: clamp(1rem, 3vw, 1.5rem);
        border: 2px solid #f4f4f5;
        transition: all 0.3s ease;
    }

    .input-group:hover {
        border-color: #fce7f3;
        box-shadow: 0 4px 20px rgba(214, 51, 132, 0.06);
    }

    .input-group:focus-within {
        border-color: #f8d7e8;
        box-shadow: 0 4px 20px rgba(214, 51, 132, 0.1);
    }

    .attr-label {
        font-size: 0.85rem;
        font-weight: 800;
        color: #3f3f46;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-bottom: 0.875rem;
    }

    .attr-label .required {
        color: #ef4444;
        font-size: 1.1em;
    }

    /* ====== ألوان ====== */
    .color-options {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
        gap: 1rem;
    }

    .color-option {
        position: relative;
        cursor: pointer;
        text-align: center;
    }

    .color-option input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .color-circle {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 3px 12px rgba(0,0,0,0.12);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        margin: 0 auto;
    }

    .color-option:hover .color-circle {
        transform: scale(1.15);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .color-option input:checked + .color-circle {
        transform: scale(1.2);
        box-shadow: 0 0 0 4px #d63384, 0 8px 25px rgba(214,51,132,0.35);
    }

    .color-option input:checked + .color-circle::after {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white' stroke-width='3.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M5 13l4 4L19 7'/%3E%3C/svg%3E") center/22px no-repeat;
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));
    }

    .color-label {
        margin-top: 0.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #71717a;
        transition: all 0.3s ease;
    }

    .color-option:hover .color-label {
        color: #d63384;
    }

    .color-option input:checked ~ .color-label {
        color: #d63384;
        font-weight: 900;
    }

    .color-tooltip {
        position: absolute;
        top: -38px;
        left: 50%;
        transform: translateX(-50%) scale(0);
        background: #18181b;
        color: white;
        padding: 0.4rem 0.9rem;
        border-radius: 10px;
        font-size: 0.72rem;
        font-weight: 800;
        white-space: nowrap;
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
        z-index: 20;
    }

    .color-tooltip::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #18181b;
    }

    .color-option:hover .color-tooltip {
        transform: translateX(-50%) scale(1);
        opacity: 1;
    }

    /* ====== Select ====== */
    .select-wrapper {
        position: relative;
    }

    .select-wrapper::after {
        content: '';
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #a1a1aa;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .select-wrapper:focus-within::after {
        border-top-color: #d63384;
        transform: translateY(-50%) rotate(180deg);
    }

    .input-luxury {
        width: 100%;
        background: white;
        border: 2px solid #e4e4e7;
        padding: 1rem 1.25rem;
        border-radius: 1rem;
        font-weight: 700;
        font-size: 0.9rem;
        color: #18181b;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        appearance: none;
    }

    .input-luxury:focus {
        border-color: #d63384;
        background: white;
        box-shadow: 0 0 0 4px rgba(214, 51, 132, 0.1);
        outline: none;
    }

    .input-luxury:hover {
        border-color: #d4d4d8;
    }

    .input-luxury::placeholder {
        color: #a1a1aa;
        font-weight: 500;
    }

    /* ====== الكمية ====== */
    .qty-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .qty-box {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        border-radius: 1.25rem;
        padding: 0.5rem;
        border: 2px solid #e4e4e7;
    }

    .qty-btn {
        width: 44px;
        height: 44px;
        background: #f4f4f5;
        border: none;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #52525b;
    }

    .qty-btn:hover {
        background: linear-gradient(135deg, #d63384, #a61e63);
        color: white;
        transform: scale(1.08);
        box-shadow: 0 6px 20px rgba(214, 51, 132, 0.3);
    }

    .qty-btn:active {
        transform: scale(0.95);
    }

    .qty-btn svg {
        width: 18px;
        height: 18px;
    }

    .qty-input {
        width: 60px;
        text-align: center;
        font-size: 1.35rem;
        font-weight: 900;
        color: #18181b;
        background: transparent;
        border: none;
        -moz-appearance: textfield;
    }

    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .stock-info {
        text-align: left;
    }

    .stock-bar-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stock-bar {
        width: 100px;
        height: 5px;
        background: #f4f4f5;
        border-radius: 10px;
        overflow: hidden;
    }

    .stock-fill {
        height: 100%;
        background: linear-gradient(90deg, #d63384, #f472b6);
        border-radius: 10px;
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stock-text {
        font-size: 0.75rem;
        color: #a1a1aa;
        font-weight: 700;
        margin-top: 0.35rem;
    }

    /* ====== Textarea ====== */
    .textarea-luxury {
        width: 100%;
        background: white;
        border: 2px solid #e4e4e7;
        padding: 1.25rem;
        border-radius: 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        resize: vertical;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: 120px;
        font-family: 'Tajawal', sans-serif;
    }

    .textarea-luxury:focus {
        border-color: #d63384;
        box-shadow: 0 0 0 4px rgba(214, 51, 132, 0.1);
        outline: none;
    }

    .textarea-luxury::placeholder {
        color: #a1a1aa;
    }

    /* ====== زر الإرسال ====== */
    .btn-submit {
        width: 100%;
        padding: 1.15rem 1.5rem;
        background: linear-gradient(135deg, #d63384 0%, #a61e63 100%);
        color: white;
        border: none;
        border-radius: 1.25rem;
        font-size: 1rem;
        font-weight: 900;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(214, 51, 132, 0.25);
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        transform: translate(-50%, -50%);
        transition: width 0.7s, height 0.7s;
    }

    .btn-submit:hover::before {
        width: 500px;
        height: 500px;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 50px rgba(214, 51, 132, 0.35);
    }

    .btn-submit:active {
        transform: translateY(-1px);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-submit svg {
        width: 22px;
        height: 22px;
        transition: transform 0.4s ease;
        position: relative;
        z-index: 2;
    }

    .btn-submit:hover svg {
        transform: translateX(-4px) rotate(-10deg);
    }

    .btn-text {
        position: relative;
        z-index: 2;
    }

    /* ====== Divider ====== */
    .divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e4e4e7, transparent);
        margin: 1.75rem 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 8px;
        height: 8px;
        background: #e4e4e7;
        border-radius: 50%;
    }

    /* ====== Grid للسمات ====== */
    .attributes-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    @media (min-width: 640px) {
        .attributes-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .attributes-grid .input-group:has(.color-options) {
            grid-column: 1 / -1;
        }
    }

    /* ====== Responsive ====== */
    @media (max-width: 480px) {
        .luxury-form {
            border-radius: 1.5rem;
            padding: 1.25rem;
        }

        .color-options {
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            gap: 0.75rem;
        }

        .color-circle {
            width: 44px;
            height: 44px;
        }

        .qty-section {
            flex-direction: column;
            align-items: stretch;
        }

        .stock-info {
            text-align: center;
        }

        .stock-bar-wrapper {
            justify-content: center;
        }

        .progress-steps {
            gap: 0.25rem;
        }

        .step-line {
            width: 15px;
        }

        .step-label {
            font-size: 0.6rem;
        }
    }

    @media (min-width: 768px) {
        .page-header {
            padding: 3rem 1rem 2rem;
        }
    }

    /* ====== تأثيرات إضافية ====== */
    .glow-text {
        background: linear-gradient(90deg, #d63384, #a61e63, #d63384);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 3s linear infinite;
    }
</style>

<div class="min-h-screen py-8 md:py-12 px-4 relative" dir="rtl">
    <!-- Blobs -->
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>
    <div class="bg-blob blob-3"></div>

    <div class="max-w-2xl mx-auto relative z-10">

        <!-- الهيدر -->
        <div class="page-header animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="header-icon-wrapper">
                <div class="header-pulse"></div>
                <div class="header-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
            <h1 class="page-title">إتمام الطلب</h1>
            <p class="page-subtitle">اختر المواصفات المطلوبة لطلبك بعناية</p>
        </div>

        <!-- خطوات التقدم -->
        <div class="progress-steps animate-fade-in-up" style="animation-delay: 0.15s;">
            <div class="progress-step">
                <div class="step-dot active" id="step1-dot">1</div>
                <div class="step-label">المواصفات</div>
            </div>
            <div class="step-line active" id="line1"></div>
            <div class="progress-step">
                <div class="step-dot" id="step2-dot">2</div>
                <div class="step-label">الكمية</div>
            </div>
            <div class="step-line" id="line2"></div>
            <div class="progress-step">
                <div class="step-dot" id="step3-dot">3</div>
                <div class="step-label">الملاحظات</div>
            </div>
        </div>

        <!-- الفورم -->
        <div class="luxury-form animate-fade-in-up" style="animation-delay: 0.2s;">
            <form id="whatsappOrderForm" class="space-y-6">

                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <!-- ✅ السمات - ترتيب محسّن -->
                @if($attributes && $attributes->count() > 0)
                    <div class="animate-fade-in-up" style="animation-delay: 0.25s;">
                        <div class="section-header">
                            <div class="section-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                </svg>
                            </div>
                            <div>
                                <div class="section-title">مواصفات المنتج</div>
                                <div class="section-desc">اختر كل المواصفات المطلوبة</div>
                            </div>
                        </div>

                        <div class="attributes-grid">
                            @foreach($attributes as $attr)
                                <div class="input-group" data-attribute-id="{{ $attr->id }}">
                                    <label class="attr-label">
                                        {{ $attr->name }}
                                        <span class="required">*</span>
                                    </label>

                                    @if($attr->type == 'color')
                                        <!-- ألوان: عرض شبكي -->
                                        <div class="color-options">
                                            @foreach($attr->options as $option)
                                                <label class="color-option">
                                                    <div class="color-tooltip">{{ $option->label_ar ?? $option->value }}</div>
                                                    <input type="radio" name="attributes[{{ $attr->id }}]" value="{{ $option->value }}" required onchange="updateProgress()">
                                                    <div class="color-circle" style="background-color: {{ $option->value }};"></div>
                                                    <div class="color-label">
                                                        {{ $option->label_ar ?? $option->value }}
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>

                                    @elseif($attr->type == 'select')
                                        <!-- قائمة منسدلة -->
                                        <div class="select-wrapper">
                                            <select name="attributes[{{ $attr->id }}]" required class="input-luxury cursor-pointer" onchange="updateProgress()">
                                                <option value="" disabled selected>اختر {{ $attr->name }}</option>
                                                @foreach($attr->options as $option)
                                                    <option value="{{ $option->value }}">
                                                        {{ $option->label_ar ?? $option->value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    @else
                                        <!-- نص -->
                                        <input type="text" name="attributes[{{ $attr->id }}]" required
                                               value="{{ old('attributes.'.$attr->id) }}"
                                               class="input-luxury"
                                               placeholder="اكتب {{ $attr->name }} هنا..."
                                               oninput="updateProgress()">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="divider"></div>
                @endif

                <!-- ✅ الكمية -->
                <div class="animate-fade-in-up" style="animation-delay: 0.35s;">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div>
                            <div class="section-title">الكمية المطلوبة</div>
                            <div class="section-desc">الحد الأقصى: {{ $product->stock }} وحدة</div>
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="qty-section">
                            <div class="qty-box">
                                <button type="button" onclick="decrement()" class="qty-btn" aria-label="تقليل الكمية">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"/>
                                    </svg>
                                </button>

                                <input type="number" name="quantity" id="qty-input" value="1" min="1" max="{{ $product->stock }}"
                                       class="qty-input" readonly aria-label="الكمية">

                                <button type="button" onclick="increment()" class="qty-btn" aria-label="زيادة الكمية">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="stock-info">
                                <div class="stock-bar-wrapper">
                                    <div class="stock-bar">
                                        <div id="stock-bar" class="stock-fill" style="width: {{ min(100, (1 / max($product->stock, 1)) * 100) }}%"></div>
                                    </div>
                                </div>
                                <div class="stock-text">المخزون المتاح: {{ $product->stock }} وحدة</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- ✅ الملاحظات -->
                <div class="animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="section-title">ملاحظات إضافية</div>
                            <div class="section-desc">اختياري — اكتب أي طلبات خاصة</div>
                        </div>
                    </div>

                    <textarea name="notes" rows="4" class="textarea-luxury"
                              placeholder="مثال: أرغب في تغليف المنتج كهدية...">{{ old('notes') }}</textarea>
                </div>

                <!-- ✅ زر الإرسال -->
                <div class="animate-fade-in-up" style="animation-delay: 0.45s;">
                    <button type="button" id="submitBtn" onclick="sendOrder()" class="btn-submit">
                        <span class="btn-text" id="btnText">إرسال الطلب الآن</span>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const maxStock = {{ $product->stock }};
    const qtyInput = document.getElementById('qty-input');
    const stockBar = document.getElementById('stock-bar');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');

    // تحديث شريط التقدم
    function updateProgress() {
        const form = document.getElementById('whatsappOrderForm');
        const requiredInputs = form.querySelectorAll('input[required], select[required]');
        let filled = 0;
        let total = 0;

        requiredInputs.forEach(field => {
            total++;
            if (field.tagName === 'SELECT' && field.value) filled++;
            else if (field.type === 'radio') {
                const checked = form.querySelector(`input[name="${field.name}"]:checked`);
                if (checked) filled++;
            } else if (field.type === 'text' && field.value.trim()) filled++;
        });

        // تحديث النقاط
        const step1 = document.getElementById('step1-dot');
        const step2 = document.getElementById('step2-dot');
        const line1 = document.getElementById('line1');

        if (filled >= total && total > 0) {
            step1.classList.add('completed');
            step1.innerHTML = '✓';
            line1.classList.add('active');
            step2.classList.add('active');
        } else if (filled > 0) {
            step1.classList.add('active');
        }
    }

    function increment() {
        let current = parseInt(qtyInput.value);
        if (current < maxStock) {
            qtyInput.value = current + 1;
            updateStockBar();
            updateProgress();
        }
    }

    function decrement() {
        let current = parseInt(qtyInput.value);
        if (current > 1) {
            qtyInput.value = current - 1;
            updateStockBar();
        }
    }

    function updateStockBar() {
        if (stockBar) {
            const percentage = Math.min(100, (parseInt(qtyInput.value) / Math.max(maxStock, 1)) * 100);
            stockBar.style.width = percentage + '%';
        }
    }

    function sendOrder() {
        const form = document.getElementById('whatsappOrderForm');

        const requiredInputs = form.querySelectorAll('input[required], select[required]');
        let missingFields = [];

        requiredInputs.forEach(field => {
            if (field.tagName === 'SELECT') {
                if (!field.value) {
                    const label = field.closest('[data-attribute-id]')?.querySelector('label')?.innerText.replace('*', '').trim() || 'حقل مطلوب';
                    if (!missingFields.includes(label)) missingFields.push(label);
                }
            } else if (field.type === 'radio') {
                const groupName = field.name;
                const checked = form.querySelector(`input[name="${groupName}"]:checked`);
                if (!checked) {
                    const label = field.closest('[data-attribute-id]')?.querySelector('label')?.innerText.replace('*', '').trim() || 'حقل مطلوب';
                    if (!missingFields.includes(label)) missingFields.push(label);
                }
            } else if (field.tagName === 'INPUT' && field.type === 'text') {
                if (!field.value.trim()) {
                    const label = field.closest('[data-attribute-id]')?.querySelector('label')?.innerText.replace('*', '').trim() || 'حقل مطلوب';
                    if (!missingFields.includes(label)) missingFields.push(label);
                }
            }
        });

        if (missingFields.length > 0) {
            alert('الرجاء اختيار/كتابة: ' + missingFields.join('، '));
            const firstEmpty = form.querySelector('input:invalid, select:invalid');
            if (firstEmpty) firstEmpty.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        submitBtn.disabled = true;
        btnText.innerText = "جاري الإرسال...";

        fetch("{{ route('order.store') }}", {
            method: "POST",
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(err => { throw err; });
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message || "تم استلام طلبك بنجاح!");
                window.location.href = "{{ route('orders.index') }}";
            } else {
                throw new Error(data.message || 'حدث خطأ غير معروف');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert(err.message || "حدث خطأ أثناء إرسال الطلب. حاول مرة أخرى.");
            submitBtn.disabled = false;
            btnText.innerText = "إرسال الطلب الآن";
        });
    }

    // تشغيل عند التحميل
    document.addEventListener('DOMContentLoaded', function() {
        updateProgress();
    });
</script>
@endsection