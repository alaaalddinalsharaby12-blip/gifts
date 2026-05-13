@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    body {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #faf7f2 0%, #f5f0e8 100%);
    }

    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: left 1rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }

    .back-btn {
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background: #e5e7eb;
        transform: translateX(-3px);
    }

    .form-card {
        background: white;
        border-radius: 2.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f0f0;
    }

    .input-field {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .input-field:focus {
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .submit-btn {
        background: linear-gradient(135deg, #1f2937, #111827);
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    /* 📱 تحسينات الموبايل */
    @media (max-width: 768px) {
        .container {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }

        .back-btn {
            padding: 0.5rem !important;
        }

        .back-btn svg {
            width: 18px !important;
            height: 18px !important;
        }

        h2 {
            font-size: 1.25rem !important;
        }

        .text-sm {
            font-size: 0.75rem !important;
        }

        .form-card {
            border-radius: 1.5rem !important;
        }

        .form-card form {
            padding: 1.25rem !important;
        }

        .input-field {
            padding: 0.75rem 1rem !important;
            font-size: 0.8rem !important;
            border-radius: 1rem !important;
        }

        .input-field.pr-12 {
            padding-right: 3rem !important;
        }

        select.input-field {
            padding: 0.75rem 1rem !important;
            font-size: 0.8rem !important;
        }

        .submit-btn {
            padding: 0.85rem !important;
            font-size: 0.85rem !important;
            border-radius: 1rem !important;
        }

        .submit-btn svg {
            width: 18px !important;
            height: 18px !important;
        }

        .space-y-6 > * + * {
            margin-top: 1rem !important;
        }

        .gap-6 {
            gap: 1rem !important;
        }

        label {
            font-size: 0.75rem !important;
        }

        .text-xs {
            font-size: 0.65rem !important;
        }
    }

    @media (max-width: 360px) {
        h2 {
            font-size: 1.1rem !important;
        }

        .back-btn {
            padding: 0.4rem !important;
        }

        .back-btn svg {
            width: 16px !important;
            height: 16px !important;
        }

        .form-card form {
            padding: 1rem !important;
        }

        .input-field {
            padding: 0.65rem 0.75rem !important;
            font-size: 0.75rem !important;
        }

        .submit-btn {
            padding: 0.75rem !important;
            font-size: 0.8rem !important;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .max-w-2xl {
            max-width: 90% !important;
        }
    }
</style>

<div class="container mx-auto py-6 md:py-12 px-3 md:px-4 max-w-2xl">

    {{-- الهيدر مع زر الرجوع --}}
    <div class="flex items-center gap-3 sm:gap-4 mb-6 md:mb-8">
        <a href="{{ route('admin.users.index') }}" class="back-btn p-2 sm:p-2.5 bg-gray-100 rounded-xl transition">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="text-xl sm:text-3xl font-black text-gray-800">إضافة عضو جديد</h2>
            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">قم بتعبئة البيانات لإنشاء حساب جديد في النظام</p>
        </div>
    </div>

    {{-- عرض الأخطاء --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl mb-5 md:mb-6 text-xs sm:text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card overflow-hidden">
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-5 sm:p-8 md:p-10 space-y-4 sm:space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                {{-- الاسم --}}
                <div class="space-y-1.5 sm:space-y-2">
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mr-2">الاسم الكامل <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 sm:pr-4 text-gray-400">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="الاسم الكامل" required
                               class="input-field text-center w-full pr-10 sm:pr-12 py-3 sm:py-4 rounded-2xl transition">
                    </div>
                    @error('name') <p class="text-red-500 text-[10px] sm:text-xs mt-1 mr-2">{{ $message }}</p> @enderror
                </div>

                {{-- الهاتف --}}
                <div class="space-y-1.5 sm:space-y-2">
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mr-2">رقم الهاتف <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 sm:pr-4 text-gray-400">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="7xxxxxxxx" required
                               class="input-field text-center w-full pr-10 sm:pr-12 py-3 sm:py-4 rounded-2xl transition text-left" dir="ltr">
                    </div>
                    @error('phone') <p class="text-red-500 text-[10px] sm:text-xs mt-1 mr-2">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- الإيميل --}}
            <div class="space-y-1.5 sm:space-y-2">
                <label class="block text-xs sm:text-sm font-bold text-gray-700 mr-2">البريد الإلكتروني <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 sm:pr-4 text-gray-400">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" autocomplete="off" placeholder="example@mail.com" required
                           class="input-field text-center w-full pr-10 sm:pr-12 py-3 sm:py-4 rounded-2xl transition text-left" dir="ltr">
                </div>
                @error('email') <p class="text-red-500 text-[10px] sm:text-xs mt-1 mr-2">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                {{-- كلمة المرور --}}
                <div class="space-y-1.5 sm:space-y-2">
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mr-2">كلمة المرور <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 sm:pr-4 text-gray-400">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input type="password" name="password" placeholder="••••••••" required
                               autocomplete="new-password" class="input-field w-full pr-10 sm:pr-12 py-3 sm:py-4 rounded-2xl text-center transition text-left" dir="ltr">
                    </div>
                    @error('password') <p class="text-red-500 text-[10px] sm:text-xs mt-1 mr-2">{{ $message }}</p> @enderror
                </div>

                {{-- تأكيد كلمة المرور --}}
                <div class="space-y-1.5 sm:space-y-2">
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mr-2">تأكيد كلمة المرور <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 sm:pr-4 text-gray-400">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <input type="password" name="password_confirmation" placeholder="••••••••" required
                               autocomplete="new-password" class="input-field w-full pr-10 sm:pr-12 py-3 sm:py-4 rounded-2xl text-center transition text-left" dir="ltr">
                    </div>
                </div>
            </div>

            {{-- الدور --}}
            <div class="space-y-1.5 sm:space-y-2">
                <label class="block text-xs sm:text-sm font-bold text-gray-700 mr-2">صلاحية المستخدم <span class="text-red-500">*</span></label>
                <select name="role" class="input-field w-full px-4 py-3 sm:py-4 rounded-2xl transition appearance-none font-bold text-xs sm:text-sm" required>
                    <option value="0" {{ old('role') == 0 ? 'selected' : '' }}>عميل (User)</option>
                    <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>مدير (Admin)</option>
                </select>
                @error('role') <p class="text-red-500 text-[10px] sm:text-xs mt-1 mr-2">{{ $message }}</p> @enderror
            </div>

            <div class="pt-2 sm:pt-4">
                <button type="submit" class="submit-btn w-full text-white font-black py-3.5 sm:py-5 rounded-2xl shadow-xl text-base sm:text-lg flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    تأكيد وإضافة المستخدم
                </button>
            </div>
        </form>
    </div>

</div>
@endsection