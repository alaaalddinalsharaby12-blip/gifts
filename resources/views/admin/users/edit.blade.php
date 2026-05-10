@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4 max-w-2xl">

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.users.index') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-3xl font-black text-gray-800">تعديل مستخدم</h2>
            <p class="text-gray-500 text-sm">تعديل بيانات المستخدم #{{ $user->id }}</p>
        </div>
    </div>

    {{-- عرض الأخطاء --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-100/50 border border-gray-100 overflow-hidden">
        <form id="editUserForm"
              action="{{ route('admin.users.update', $user->id) }}"
              method="POST"
              class="p-8 md:p-10 space-y-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- الاسم --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 mr-2">الاسم الكامل <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $user->name) }}"
                               class="text-center w-full bg-gray-50 border-2 border-gray-200 focus:border-blue-500 focus:ring-0 pr-12 py-4 rounded-2xl transition"
                               placeholder="الاسم الكامل" required>
                    </div>
                    <p class="text-red-500 text-xs hidden" id="nameError"></p>
                    @error('name') <p class="text-red-500 text-xs mt-1 mr-2">{{ $message }}</p> @enderror
                </div>

                {{-- الهاتف --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 mr-2">رقم الهاتف <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </span>
                        <input type="text" name="phone" id="phone"
                               value="{{ old('phone', $user->phone) }}"
                               class="text-center w-full bg-gray-50 border-2 border-gray-200 focus:border-blue-500 focus:ring-0 pr-12 py-4 rounded-2xl transition text-left"
                               placeholder="7xxxxxxxx" dir="ltr" required>
                    </div>
                    <p class="text-red-500 text-xs hidden" id="phoneError"></p>
                    @error('phone') <p class="text-red-500 text-xs mt-1 mr-2">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- الإيميل --}}
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 mr-2">البريد الإلكتروني <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <input type="email" name="email" id="email"
                           value="{{ old('email', $user->email) }}"
                           class="text-center w-full bg-gray-50 border-2 border-gray-200 focus:border-blue-500 focus:ring-0 pr-12 py-4 rounded-2xl transition text-left"
                           placeholder="example@mail.com" dir="ltr" required>
                </div>
                <p class="text-red-500 text-xs hidden" id="emailError"></p>
                @error('email') <p class="text-red-500 text-xs mt-1 mr-2">{{ $message }}</p> @enderror
            </div>

            {{-- كلمة المرور --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 mr-2">كلمة المرور الجديدة</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input type="password" name="password"
                            class="w-full bg-gray-50 border-2 border-gray-200 focus:border-blue-500 focus:ring-0 pr-12 py-4 rounded-2xl text-center transition text-left"
                            placeholder="••••••••" dir="ltr" autocomplete="new-password">
                    </div>
                    <p class="text-sm text-gray-500 mt-1">اتركها فارغة إذا لا تريد تغيير كلمة المرور</p>
                    @error('password') <p class="text-red-500 text-xs mt-1 mr-2">{{ $message }}</p> @enderror
                </div>

                {{-- ✅ تأكيد كلمة المرور --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 mr-2">تأكيد كلمة المرور</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        <input type="password" name="password_confirmation"
                            class="w-full bg-gray-50 border-2 border-gray-200 focus:border-blue-500 focus:ring-0 pr-12 py-4 rounded-2xl text-center transition text-left"
                            placeholder="••••••••" dir="ltr" autocomplete="new-password">
                    </div>
                </div>
            </div>

            {{-- الدور --}}
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 mr-2">صلاحية المستخدم <span class="text-red-500">*</span></label>
                <select name="role" id="role"
                        class="w-full bg-gray-50 border-2 border-gray-200 focus:border-blue-500 focus:ring-0 px-4 py-4 rounded-2xl transition appearance-none font-bold" required>
                    <option value="0" {{ old('role', $user->role) == 0 ? 'selected' : '' }}>عميل (User)</option>
                    <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>مدير (Admin)</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1 mr-2">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="w-full bg-black text-white font-black py-5 rounded-2xl shadow-xl shadow-black/10 hover:bg-gray-800 hover:-translate-y-1 transition duration-300 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    تحديث المستخدم
                </button>
            </div>
        </form>
    </div>

</div>

<style>
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: left 1rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }
</style>

{{-- ================= JS VALIDATION ================= --}}
<script>
document.getElementById('editUserForm').addEventListener('submit', function(e) {
    let isValid = true;

    // reset errors
    document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

    let name = document.getElementById('name');
    let email = document.getElementById('email');
    let phone = document.getElementById('phone');

    // NAME
    if (name.value.trim().length < 3) {
        document.getElementById('nameError').innerText = "الاسم يجب أن يكون 3 أحرف على الأقل";
        document.getElementById('nameError').classList.remove('hidden');
        isValid = false;
    }

    // EMAIL
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value)) {
        document.getElementById('emailError').innerText = "الإيميل غير صحيح";
        document.getElementById('emailError').classList.remove('hidden');
        isValid = false;
    }

    // PHONE
    let phonePattern = /^[0-9]{6,15}$/;
    if (!phonePattern.test(phone.value)) {
        document.getElementById('phoneError').innerText = "رقم الهاتف غير صحيح (6-15 رقم)";
        document.getElementById('phoneError').classList.remove('hidden');
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
    }
});
</script>
@endsection