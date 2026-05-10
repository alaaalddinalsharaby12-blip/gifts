@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    .edit-page {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #eff6ff 100%);
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
    }

    .input-luxury {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-luxury:focus {
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .input-luxury:hover {
        border-color: #cbd5e1;
    }

    .image-card {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .image-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .image-card .delete-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(239, 68, 68, 0.9), rgba(239, 68, 68, 0.4));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .image-card:hover .delete-overlay {
        opacity: 1;
    }

    .upload-zone {
        background: linear-gradient(135deg, #dbeafe, #eff6ff);
        border: 2px dashed #3b82f6;
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
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.05), transparent);
        transition: left 0.7s;
    }

    .upload-zone:hover::before {
        left: 100%;
    }

    .upload-zone:hover {
        border-color: #2563eb;
        background: linear-gradient(135deg, #bfdbfe, #dbeafe);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.1);
    }

    .submit-btn {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
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
        box-shadow: 0 15px 40px rgba(59, 130, 246, 0.3);
    }

    .cancel-btn {
        transition: all 0.3s ease;
    }

    .cancel-btn:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
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
        background: #e2e8f0;
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
        background: linear-gradient(135deg, #3b82f6, #2563eb);
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
        background: linear-gradient(135deg, #3b82f6, #6366f1);
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

    .back-btn {
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        transform: translateX(-3px);
        background: linear-gradient(135deg, #dbeafe, #eff6ff);
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        right: 0;
        width: 40px;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6, #6366f1);
        border-radius: 2px;
        transition: width 0.4s ease;
    }

    .page-title:hover::after {
        width: 100%;
    }
</style>

<div class="edit-page py-12 px-4 relative">
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="max-w-5xl mx-auto relative z-10">

        <!-- الهيدر -->
        <div class="flex items-center gap-4 mb-10 animate-fade-in-up" style="animation-delay: 0.1s;">
            <a href="{{ route('admin.products.index') }}" class="back-btn p-3 bg-white rounded-2xl shadow-sm border border-gray-100">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="page-title relative inline-block text-3xl font-black text-gray-900">تعديل المنتج</h1>
                <p class="text-gray-500 text-sm mt-2">أنت تقوم بتعديل: <span class="text-blue-600 font-bold">{{ $product->name }}</span></p>
            </div>
        </div>

        <div class="luxury-form rounded-[2.5rem] shadow-xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s;">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-10 space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    
                    <!-- الجانب الأيمن: البيانات -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.25s;">
                            <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                اسم المنتج
                            </label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                   class="input-luxury w-full py-4 px-6 rounded-2xl font-bold text-lg">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.3s;">
                                <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    القسم
                                </label>
                                <select name="category_id" class="input-luxury w-full py-4 px-6 rounded-2xl font-bold text-center appearance-none cursor-pointer">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.35s;">
                                <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    المخزون المتوفر
                                </label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                       class="input-luxury text-center w-full py-4 px-6 rounded-2xl font-bold">
                            </div>
                        </div>

                        <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.4s;">
                            <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                حالة العرض
                            </label>
                            <div class="flex items-center justify-between px-6 py-4 bg-gray-50 rounded-2xl border-2 border-gray-200 hover:border-blue-300 transition-colors">
                                <span class="text-sm font-bold text-gray-700">نشط في المتجر</span>
                                <label class="toggle-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.45s;">
                            <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                وصف المنتج
                            </label>
                            <textarea name="description" rows="4" class="input-luxury w-full py-4 px-6 rounded-2xl font-bold resize-none">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>

                    <!-- الجانب الأيسر: الصور -->
                    <div class="space-y-6 animate-fade-in-up" style="animation-delay: 0.3s;">
                        <div class="bg-gradient-to-br from-gray-50 to-white p-6 rounded-[2rem] border border-gray-100 space-y-5">
                            <label class="block text-sm font-black text-gray-700 text-center flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                صور المنتج
                            </label>
                            
                            <!-- الصور الحالية -->
                            <div class="grid grid-cols-2 gap-3" id="existing-images">
                                @foreach($product->images as $img)
                                    <div class="image-card aspect-square" id="image-{{ $img->id }}">
                                        <img src="{{ asset('storage/'.$img->image) }}" class="w-full h-full object-cover">
                                        <button type="button" onclick="deleteImage({{ $img->id }})" class="delete-overlay cursor-pointer">
                                            <div class="text-white text-center">
                                                <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span class="text-xs font-bold">حذف</span>
                                            </div>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <!-- رفع صور جديدة -->
                            <div class="pt-4 border-t border-gray-200">
                                <div id="new-images-preview" class="grid grid-cols-3 gap-2 mb-3">
                                </div>
                                
                                <label class="upload-zone flex items-center justify-center w-full py-5 rounded-2xl cursor-pointer group">
                                    <div class="flex items-center gap-2 text-blue-600 font-bold text-sm">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        إضافة صور جديدة
                                    </div>
                                    <input type="file" name="images[]" id="new-product-images" multiple accept="image/*" class="hidden">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- أزرار التحكم -->
                <div class="flex flex-col md:flex-row gap-4 pt-8 border-t border-gray-100 animate-fade-in-up" style="animation-delay: 0.5s;">
                    <button type="submit" class="submit-btn flex-1 text-white font-black py-5 rounded-2xl shadow-xl text-lg flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                        حفظ التعديلات
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="cancel-btn md:w-1/3 text-center bg-gray-100 text-gray-600 font-bold py-5 rounded-2xl flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        إلغاء التغييرات
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('new-product-images').addEventListener('change', function(event) {
    const container = document.getElementById('new-images-preview');
    container.innerHTML = ''; 
    const files = event.target.files;
    
    for (let i = 0; i < files.length; i++) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'preview-img relative aspect-square rounded-lg overflow-hidden border-2 border-blue-200 shadow-sm';
            div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            container.appendChild(div);
        }
        reader.readAsDataURL(files[i]);
    }
});

function deleteImage(imageId) {
    if (!confirm('سيتم حذف الصورة نهائياً، هل أنت متأكد؟')) return;
    
    fetch(`/admin/products/images/${imageId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        if (response.ok) {
            const imgDiv = document.getElementById('image-' + imageId);
            imgDiv.style.transform = 'scale(0)';
            imgDiv.style.opacity = '0';
            setTimeout(() => imgDiv.remove(), 300);
        } else {
            alert('حدث خطأ أثناء محاولة الحذف');
        }
    })
    .catch(error => alert('فشل الاتصال بالسيرفر'));
}
</script>
@endsection