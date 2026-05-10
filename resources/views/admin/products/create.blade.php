@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    .create-page {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0fdf4 100%);
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

    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }

    .luxury-form {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.7);
        transition: all 0.4s ease;
    }

    .input-luxury {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-luxury:focus {
        border-color: #10b981;
        background: white;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    .input-luxury:hover {
        border-color: #d1d5db;
    }

    .upload-zone {
        background: linear-gradient(135deg, #ecfdf5, #f0fdf4);
        border: 2px dashed #10b981;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .upload-zone::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.05), transparent);
        transition: left 0.7s;
    }

    .upload-zone:hover::before {
        left: 100%;
    }

    .upload-zone:hover {
        border-color: #059669;
        background: linear-gradient(135deg, #d1fae5, #ecfdf5);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.1);
    }

    .submit-btn {
        background: linear-gradient(135deg, #059669, #10b981);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .submit-btn::before {
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

    .submit-btn:hover::before {
        width: 400px;
        height: 400px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(16, 185, 129, 0.3);
    }

    .toggle-switch {
        position: relative;
        width: 56px;
        height: 28px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background: #e5e7eb;
        border-radius: 28px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .toggle-slider::before {
        content: '';
        position: absolute;
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background: white;
        border-radius: 50%;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    input:checked + .toggle-slider {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    input:checked + .toggle-slider::before {
        transform: translateX(28px);
    }

    .preview-img {
        animation: fadeInUp 0.3s ease-out;
        transition: all 0.3s ease;
    }

    .preview-img:hover {
        transform: scale(1.05);
    }

    .bg-blob {
        position: fixed;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.08;
        pointer-events: none;
        z-index: 0;
    }

    .blob-1 {
        width: 600px;
        height: 600px;
        background: linear-gradient(135deg, #10b981, #34d399);
        top: -15%;
        right: -15%;
        animation: float 10s ease-in-out infinite;
    }

    .blob-2 {
        width: 500px;
        height: 500px;
        background: linear-gradient(135deg, #059669, #047857);
        bottom: -15%;
        left: -15%;
        animation: float 12s ease-in-out infinite reverse;
    }

    .back-btn {
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        transform: translateX(-3px);
        background: linear-gradient(135deg, #d1fae5, #ecfdf5);
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        right: 0;
        width: 40px;
        height: 4px;
        background: linear-gradient(90deg, #10b981, #34d399);
        border-radius: 2px;
        transition: width 0.4s ease;
    }

    .page-title:hover::after {
        width: 100%;
    }
</style>

<div class="create-page py-12 px-4 relative">
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="max-w-2xl mx-auto relative z-10">

        <!-- الهيدر -->
        <div class="flex items-center gap-4 mb-10 animate-fade-in-up" style="animation-delay: 0.1s;">
            <a href="{{ route('admin.products.index') }}" class="back-btn p-3 bg-white rounded-2xl shadow-sm border border-gray-100">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="page-title relative inline-block text-3xl font-black text-gray-900">إضافة منتج جديد</h1>
                <p class="text-gray-500 text-sm mt-2">أدخل تفاصيل المنتج والصور لعرضه في المتجر</p>
            </div>
        </div>

        @if($errors->any())
            <div class="animate-fade-in-up mb-6" style="animation-delay: 0.15s;">
                <div class="bg-gradient-to-r from-red-50 to-rose-50 border-r-4 border-red-500 text-red-700 px-6 py-4 rounded-2xl shadow-lg">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-bold">يرجى تصحيح الأخطاء التالية:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm font-bold space-y-1 mr-6">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="luxury-form rounded-[2.5rem] shadow-xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s;">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-10 space-y-8">
                @csrf

                <!-- اسم المنتج -->
                <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.25s;">
                    <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        اسم المنتج <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="مثال: ساعة ذكية أصلية" required
                           class="input-luxury text-center w-full py-4 px-6 rounded-2xl font-bold text-lg">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- القسم -->
                    <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.3s;">
                        <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            القسم <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" required
                                class="input-luxury w-full py-4 px-6 rounded-2xl font-bold text-center appearance-none cursor-pointer">
                            <option value="">اختر القسم</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- المخزون -->
                    <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.35s;">
                        <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            الكمية المتوفرة <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" placeholder="0" required
                               class="input-luxury text-center w-full py-4 px-6 rounded-2xl font-bold">
                    </div>
                </div>

                <!-- الحالة -->
                <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.4s;">
                    <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        حالة العرض
                    </label>
                    <div class="flex items-center justify-between px-6 py-4 bg-gray-50 rounded-2xl border-2 border-gray-200 hover:border-emerald-300 transition-colors">
                        <span class="text-sm font-bold text-gray-700">تفعيل المنتج فوراً</span>
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- الوصف -->
                <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.45s;">
                    <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        وصف المنتج
                    </label>
                    <textarea name="description" rows="4" placeholder="اكتب تفاصيل المنتج هنا..."
                              class="input-luxury w-full py-4 px-6 rounded-2xl font-bold resize-none">{{ old('description') }}</textarea>
                </div>

                <!-- رفع الصور -->
                <div class="space-y-4 animate-fade-in-up" style="animation-delay: 0.5s;">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-black text-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            صور المنتج
                        </label>
                        <span class="text-[10px] bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full font-bold">يمكن اختيار متعدد</span>
                    </div>

                    <div id="image-preview-container" class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                    </div>

                    <div class="relative">
                        <label class="upload-zone flex items-center justify-center w-full py-6 rounded-2xl cursor-pointer group">
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-white rounded-xl shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-black text-emerald-700 block">إضافة صور للمنتج</span>
                                    <span class="text-xs text-emerald-500">اسحب الصور هنا أو انقر للاختيار</span>
                                </div>
                            </div>
                            <input type="file" name="images[]" id="product-images" multiple accept="image/*" class="hidden" />
                        </label>
                    </div>
                </div>

                <div class="pt-4 animate-fade-in-up" style="animation-delay: 0.55s;">
                    <button type="submit" class="submit-btn w-full text-white font-black py-5 rounded-2xl shadow-xl text-lg flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                        تأكيد وحفظ المنتج
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('product-images').addEventListener('change', function(event) {
        const container = document.getElementById('image-preview-container');
        container.innerHTML = ''; 
        
        const files = event.target.files;
        if(files.length > 0) {
            container.classList.add('mb-4');
        }
        
        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-img relative aspect-square rounded-xl overflow-hidden border-2 border-white shadow-md ring-1 ring-gray-100';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/0 hover:bg-black/10 transition-colors"></div>
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(files[i]);
        }
    });
</script>
@endsection