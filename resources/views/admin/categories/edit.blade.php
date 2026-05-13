@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    body {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #faf7f2 0%, #f5f0e8 100%);
    }

    .admin-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
        border-radius: 2rem;
    }

    .input-luxury {
        background: #fafafa;
        border: 2px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .input-luxury:focus {
        border-color: #d63384;
        background: white;
        box-shadow: 0 0 0 4px rgba(214, 51, 132, 0.1);
        outline: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #d63384 0%, #a61e63 100%);
        color: white;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(214, 51, 132, 0.3);
    }

    .upload-box {
        border: 2px dashed #e8e8e8;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-box:hover {
        border-color: #d63384;
        background: rgba(214, 51, 132, 0.02);
    }

    .upload-box.has-file {
        border-color: #d63384;
        background: rgba(214, 51, 132, 0.05);
    }

    .preview-circle {
        width: 100px;
        height: 100px;
        border-radius: 1.5rem;
        overflow: hidden;
        border: 2px dashed #e8e8e8;
        background: #fafafa;
    }

    /* تحسينات الموبايل */
    @media (max-width: 768px) {
        .container {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        
        .admin-card {
            border-radius: 1.5rem;
            padding: 1.25rem !important;
        }

        h2 {
            font-size: 1.25rem !important;
        }
    }
</style>

<div class="container mx-auto py-10 px-4 max-w-lg">

    <!-- الهيدر -->
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm hover:shadow-md transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-black text-gray-900">تعديل قسم</h2>
            <p class="text-gray-400 text-sm font-bold">{{ $category->name }}</p>
        </div>
    </div>

    <!-- الأخطاء -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-2xl mb-6 font-bold text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- الفورم -->
    <div class="admin-card p-6 md:p-8">
        <form id="categoryForm" action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- معاينة الصورة -->
            <div class="flex justify-center">
                <div class="preview-circle flex items-center justify-center relative">
                    @if($category->image)
                        <img id="previewImg" src="{{ asset('storage/'.$category->image) }}" class="w-full h-full object-cover absolute inset-0">
                        <svg id="placeholderIcon" class="hidden w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @else
                        <svg id="placeholderIcon" class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <img id="previewImg" class="hidden w-full h-full object-cover absolute inset-0">
                    @endif
                </div>
            </div>

            <!-- اسم القسم -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700">اسم القسم <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" placeholder="مثال: صناديق الخطوبة"
                       class="input-luxury w-full py-3.5 px-4 rounded-xl font-bold text-sm text-center">
                <p id="nameError" class="text-red-500 text-xs font-bold hidden text-center"></p>
            </div>

            <!-- المحتوى -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700">ما يحتويه القسم <span class="text-gray-400 text-xs font-normal">(يظهر للعميل)</span></label>
                <textarea name="contents" rows="4" 
                        class="input-luxury w-full py-3.5 px-4 rounded-xl font-bold text-sm resize-none"
                        placeholder="ورد طبيعي، شوكولاتة فاخرة، بالونات...">{{ old('contents', $category->contents) }}</textarea>
            </div>

            <!-- رفع الصورة -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700">صورة الغلاف <span class="text-gray-400 text-xs font-normal">(اتركه فارغاً للاحتفاظ بالحالية)</span></label>
                <label id="imageUploadBox" class="upload-box flex items-center justify-center w-full py-4 rounded-xl">
                    <div class="flex items-center gap-2 text-gray-400 font-bold text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span id="imageFileName">تغيير الصورة</span>
                    </div>
                    <input type="file" name="image" id="image" accept="image/*" class="hidden">
                </label>
            </div>

            <!-- الفيديو -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700">فيديو القسم</label>
                
                <!-- الفيديو الحالي -->
                @if($category->video)
                    <div class="rounded-xl overflow-hidden bg-gray-100 mb-3">
                        <video controls class="w-full h-40 object-cover">
                            <source src="{{ asset('storage/'.$category->video) }}" type="video/mp4">
                        </video>
                    </div>
                    <p class="text-xs text-gray-400 font-bold mb-2">الفيديو الحالي - اختر ملفاً جديداً للاستبدال</p>
                @else
                    <p class="text-xs text-gray-400 font-bold mb-2">لا يوجد فيديو</p>
                @endif

                <!-- رفع جديد -->
                <div id="videoPreviewBox" class="hidden rounded-xl overflow-hidden mb-3 bg-gray-100">
                    <video id="videoPreview" muted loop playsinline class="w-full h-40 object-cover"></video>
                </div>

                <label id="videoUploadBox" class="upload-box flex items-center justify-center w-full py-4 rounded-xl">
                    <div class="flex items-center gap-2 text-gray-400 font-bold text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span id="videoFileName">{{ $category->video ? 'تغيير الفيديو' : 'اختيار فيديو' }}</span>
                    </div>
                    <input type="file" name="video" id="video" accept="video/*" class="hidden">
                </label>
                <p class="text-xs text-gray-400 font-bold">MP4, WebM - الحد الأقصى 10 ميجا</p>
            </div>

            <!-- الزر -->
            <button type="submit" class="btn-primary w-full py-4 rounded-xl font-black text-sm flex items-center justify-center gap-2 mt-8">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
                حفظ التعديلات
            </button>

        </form>
    </div>
</div>

<script>
// معاينة الصورة
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(event) {
        document.getElementById('previewImg').src = event.target.result;
        document.getElementById('previewImg').classList.remove('hidden');
        document.getElementById('placeholderIcon').classList.add('hidden');
    };
    reader.readAsDataURL(file);

    document.getElementById('imageFileName').textContent = file.name;
    document.getElementById('imageUploadBox').classList.add('has-file');
});

// معاينة الفيديو الجديد
document.getElementById('video').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const url = URL.createObjectURL(file);
    document.getElementById('videoPreview').src = url;
    document.getElementById('videoPreviewBox').classList.remove('hidden');
    
    document.getElementById('videoFileName').textContent = file.name;
    document.getElementById('videoUploadBox').classList.add('has-file');
});

// التحقق
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    let valid = true;
    const name = document.getElementById('name');
    document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

    if (name.value.trim().length < 3) {
        document.getElementById('nameError').textContent = "الاسم قصير جداً";
        document.getElementById('nameError').classList.remove('hidden');
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>
@endsection