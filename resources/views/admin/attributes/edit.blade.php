@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    body {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0fdf4 100%);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
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

    .input-luxury.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
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

    .add-option-btn {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        transition: all 0.3s ease;
    }

    .add-option-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    }

    .option-row {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .option-row:hover {
        border-color: #10b981;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.08);
    }

    .remove-btn {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        background: #fee2e2;
        color: #ef4444;
    }

    .remove-btn:hover {
        background: #ef4444;
        color: white;
        transform: scale(1.1);
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

    .error-msg {
        background: linear-gradient(135deg, #fee2e2, #fef2f2);
        border-right: 4px solid #ef4444;
        color: #dc2626;
    }
</style>

<div class="py-12 px-4 relative">
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="max-w-2xl mx-auto relative z-10">

        <!-- الهيدر -->
        <div class="flex items-center gap-4 mb-10 animate-fade-in-up" style="animation-delay: 0.1s;">
            <a href="{{ route('admin.attributes.index') }}" class="back-btn p-3 bg-white rounded-2xl shadow-sm border border-gray-100">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="page-title relative inline-block text-3xl font-black text-gray-900">تعديل الصفة</h1>
                <p class="text-gray-500 text-sm mt-2">تحديث بيانات الصفة: <span class="text-emerald-600 font-bold">{{ $attribute->name }}</span></p>
            </div>
        </div>

        <!-- أخطاء التحقق -->
        @if($errors->any())
            <div class="animate-fade-in-up mb-6" style="animation-delay: 0.15s;">
                <div class="error-msg px-6 py-4 rounded-2xl shadow-lg">
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
            <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST" class="p-8 md:p-10 space-y-8">
                @csrf
                @method('PUT')

                <!-- القسم -->
                <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.25s;">
                    <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        القسم
                    </label>
                    <select name="category_id" class="input-luxury w-full py-4 px-6 rounded-2xl font-bold text-center appearance-none cursor-pointer">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $attribute->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- اسم الصفة -->
                <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        اسم الصفة (مثلاً: اللون، المقاس)
                    </label>
                    <input type="text" name="name" value="{{ old('name', $attribute->name) }}" 
                           class="input-luxury text-center w-full py-4 px-6 rounded-2xl font-bold text-lg">
                </div>

                <!-- نوع المدخل -->
                <div class="space-y-3 animate-fade-in-up" style="animation-delay: 0.35s;">
                    <label class="block text-sm font-black text-gray-700 mr-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        نوع الاختيار
                    </label>
                    <select name="type" id="type" onchange="toggleOptionsBox()"
                            class="input-luxury w-full py-4 px-6 rounded-2xl font-bold text-center appearance-none cursor-pointer">
                        <option value="text" {{ $attribute->type == 'text' ? 'selected' : '' }}>نص (Text)</option>
                        <option value="select" {{ $attribute->type == 'select' ? 'selected' : '' }}>قائمة منسدلة (Select)</option>
                        <option value="color" {{ $attribute->type == 'color' ? 'selected' : '' }}>اختيار لون (Color)</option>
                    </select>
                </div>

                <!-- ✅ خيارات (للـ select و color فقط) -->
                <div id="optionsBox" class="{{ $attribute->type == 'text' ? 'hidden' : '' }} space-y-4 animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-black text-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            الخيارات
                        </label>
                        <span class="text-[10px] bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full font-bold">يمكنك إضافة أو حذف الخيارات</span>
                    </div>

                    <div id="optionsContainer" class="space-y-3">
                        @forelse($attribute->options as $index => $option)
                            <div class="option-row flex gap-3 items-center">
                                @if($attribute->type == 'color')
                                    <div class="flex-shrink-0">
                                        <input type="color" name="options[{{ $index }}][value]" 
                                               value="{{ $option->value }}" 
                                               class="w-14 h-14 rounded-xl border-2 border-gray-200 cursor-pointer bg-white p-1" required>
                                    </div>
                                    <input type="text" name="options[{{ $index }}][label_ar]" 
                                           value="{{ $option->label_ar }}" 
                                           placeholder="الاسم العربي" 
                                           class="input-luxury flex-1 py-3 px-4 rounded-xl font-bold text-center" required>
                                @else
                                    {{-- ✅ hidden value + label_ar فقط --}}
                                    <input type="hidden" name="options[{{ $index }}][value]" value="{{ $option->value }}">
                                    <input type="text" name="options[{{ $index }}][label_ar]" 
                                           value="{{ $option->label_ar }}" 
                                           placeholder="الاسم العربي" 
                                           class="input-luxury flex-1 py-3 px-4 rounded-xl font-bold text-center"
                                           oninput="this.previousElementSibling.value = this.value" required>
                                @endif
                                <button type="button" onclick="removeRow(this)" class="remove-btn flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @empty
                            {{-- لا توجد خيارات --}}
                        @endforelse
                    </div>

                    <button type="button" onclick="addOptionRow()" 
                            class="add-option-btn text-white px-6 py-3 rounded-2xl font-black text-sm flex items-center justify-center gap-2 shadow-lg shadow-blue-200/50 w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                        </svg>
                        إضافة خيار جديد
                    </button>
                </div>

                <!-- زر الحفظ -->
                <div class="pt-4 animate-fade-in-up" style="animation-delay: 0.55s;">
                    <button type="submit" class="submit-btn w-full text-white font-black py-5 rounded-2xl shadow-xl text-lg flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let optionIndex = {{ $attribute->options->count() }};

function toggleOptionsBox() {
    let type = document.getElementById('type').value;
    let box = document.getElementById('optionsBox');

    if (type === 'select' || type === 'color') {
        box.classList.remove('hidden');
        if (document.getElementById('optionsContainer').children.length === 0) {
            addOptionRow();
        }
    } else {
        box.classList.add('hidden');
    }
}

function addOptionRow() {
    const container = document.getElementById('optionsContainer');
    const type = document.getElementById('type').value;
    
    const div = document.createElement('div');
    div.className = 'option-row flex gap-3 items-center';
    
    if (type === 'color') {
        div.innerHTML = `
            <div class="flex-shrink-0">
                <input type="color" name="options[${optionIndex}][value]" 
                       class="w-14 h-14 rounded-xl border-2 border-gray-200 cursor-pointer bg-white p-1" required>
            </div>
            <input type="text" name="options[${optionIndex}][label_ar]" 
                   placeholder="الاسم العربي (مثال: أحمر)" 
                   class="input-luxury flex-1 py-3 px-4 rounded-xl font-bold text-center" required>
            <button type="button" onclick="removeRow(this)" class="remove-btn flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
    } else {
        // ✅ قائمة: hidden value + label_ar فقط
        div.innerHTML = `
            <input type="hidden" name="options[${optionIndex}][value]" class="option-value-hidden">
            <input type="text" name="options[${optionIndex}][label_ar]" 
                   placeholder="الاسم العربي (مثال: كبير جداً)" 
                   class="input-luxury flex-1 py-3 px-4 rounded-xl font-bold text-center"
                   oninput="this.previousElementSibling.value = this.value" required>
            <button type="button" onclick="removeRow(this)" class="remove-btn flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
    }
    
    container.appendChild(div);
    optionIndex++;
}

function removeRow(btn) {
    btn.closest('.option-row').remove();
}
</script>
@endsection