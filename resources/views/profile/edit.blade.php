@extends('layouts.app')

@section('title', 'حسابي - JUST FOR YOU')

@push('styles')
<style>
    /* تحسين شكل حقول الإدخال */
    .input-style:focus {
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
        border-color: #ec4899;
    }
    .input-style {
        background-color: #f9fafb; /* gray-50 */
        border-color: #e5e7eb; /* gray-200 */
        border-radius: 1rem; /* rounded-2xl */
        padding: 1rem;
        transition: all 0.2s;
        width: 100%;
        text-align: center;
    }
    .input-style:hover {
        background-color: #ffffff;
        border-color: #d1d5db;
    }
    /* تحسين الأزرار */
    .btn-submit {
        background: linear-gradient(to right, #ec4899, #db2777); /* pink-500 to pink-600 */
        color: #ffffff;
        border-radius: 1rem; /* rounded-2xl */
        font-weight: 900;
        padding: 1rem;
        transition: all 0.3s;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        border: none;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(236, 72, 153, 0.2);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center py-12 px-4">
    
    <div class="w-full max-w-3xl">
        
        <div class="text-center mb-10">
            <div class="mx-auto h-16 w-16 bg-black text-white rounded-3xl flex items-center justify-center mb-4 shadow-xl">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black text-gray-900">إعدادات حسابي</h2>
        </div>

        <div class="grid grid-cols-1 gap-6">
            
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 p-8 md:p-10 border border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2.5 bg-pink-50 text-pink-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900">البيانات الشخصية</h3>
                </div>
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 p-8 md:p-10 border border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2.5 bg-purple-50 text-purple-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900">أمان الحساب</h3>
                </div>
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 p-8 md:p-10 border border-red-50">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2.5 bg-red-50 text-red-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-red-600">منطقة الخطر</h3>
                </div>
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection