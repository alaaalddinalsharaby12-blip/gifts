@extends('layouts.app')

@section('title', 'إنشاء حساب جديد - مناسباتي')

@push('styles')
<style>
    .input-focus:focus {
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
    }
    .btn-shine {
        position: relative;
        overflow: hidden;
    }
    .btn-shine::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%);
        transform: rotate(30deg);
        transition: all 0.6s;
        opacity: 0;
    }
    .btn-shine:hover::after {
        opacity: 1;
        left: 100%;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-pink-50 via-white to-gray-100 relative overflow-hidden py-12">
    
    <div class="absolute top-20 left-10 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float"></div>
    <div class="absolute bottom-20 right-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float" style="animation-delay: 1s;"></div>

    <div class="max-w-md w-full relative z-10 px-4">
        
        <div class="bg-white/80 backdrop-blur-lg rounded-[2.5rem] shadow-2xl p-8 border border-white/50">
            
            <div class="text-center mb-8">
                <div class="mx-auto h-20 w-20 bg-gradient-to-br from-pink-400 to-pink-600 rounded-2xl flex items-center justify-center mb-4 shadow-xl shadow-pink-200 transform hover:scale-105 transition duration-300">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-black text-gray-900 mb-2">حساب جديد</h2>
                <p class="text-gray-500 text-sm">انضم إلينا اليوم وابدأ بتنظيم مناسباتك</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 mr-1">الاسم الكامل</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus placeholder="أدخل اسمك الثلاثي"
                           class="input-focus block w-full px-4 py-3.5 border-2 border-gray-100 rounded-2xl focus:ring-0 focus:border-pink-500 text-right transition bg-gray-50/50 hover:bg-white">
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 mr-1">البريد الإلكتروني</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="example@mail.com"
                           class="input-focus block w-full px-4 py-3.5 border-2 border-gray-100 rounded-2xl focus:ring-0 focus:border-pink-500 text-right transition bg-gray-50/50 hover:bg-white">
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 mr-1">رقم الهاتف</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required placeholder="05xxxxxxxx"
                           class="input-focus block w-full px-4 py-3.5 border-2 border-gray-100 rounded-2xl focus:ring-0 focus:border-pink-500 text-right transition bg-gray-50/50 hover:bg-white">
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1 mr-1">كلمة المرور</label>
                        <input id="password" name="password" type="password" required placeholder="••••••••"
                               class="input-focus block w-full px-4 py-3.5 border-2 border-gray-100 rounded-2xl focus:ring-0 focus:border-pink-500 text-right transition bg-gray-50/50 hover:bg-white">
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1 mr-1">تأكيد كلمة المرور</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="••••••••"
                               class="input-focus block w-full px-4 py-3.5 border-2 border-gray-100 rounded-2xl focus:ring-0 focus:border-pink-500 text-right transition bg-gray-50/50 hover:bg-white">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="btn-shine w-full py-4 px-4 border-0 rounded-2xl text-white bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 transition-all duration-300 shadow-lg shadow-pink-200 font-black text-lg">
                        إنشاء الحساب
                    </button>
                </div>
            </form>

            <div class="text-center mt-6">
                <p class="text-gray-500 text-sm">
                    لديك حساب بالفعل؟
                    <a href="{{ route('login') }}" class="font-black text-pink-600 hover:text-pink-700 transition">
                        سجل دخولك
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection