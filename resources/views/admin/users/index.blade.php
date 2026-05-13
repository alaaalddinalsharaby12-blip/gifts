@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

    body {
        font-family: 'Tajawal', sans-serif;
        background: linear-gradient(135deg, #faf7f2 0%, #f5f0e8 100%);
    }

    .users-page {
        font-family: 'Tajawal', sans-serif;
    }

    /* ✅ زر الرجوع لـ Dashboard */
    .back-dashboard-btn {
        background: white;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }

    .back-dashboard-btn:hover {
        border-color: #3b82f6;
        background: #eff6ff;
        box-shadow: 0 6px 20px rgba(59,130,246,0.12);
    }

    .back-dashboard-btn:hover svg {
        color: #2563eb;
        transform: translateX(-3px);
    }

    .back-dashboard-btn:hover span {
        color: #1d4ed8;
    }

    .card {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid #f0f0f0;
    }

    .btn-add {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59,130,246,0.3);
    }

    .action-btn {
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        transform: scale(1.1);
    }

    .table-row {
        transition: all 0.3s ease;
    }

    .table-row:hover {
        background: #f8fafc;
    }

    /* 📱 تحسينات الموبايل */
    @media (max-width: 768px) {
        .container {
            padding: 1rem 0.5rem !important;
        }

        .back-dashboard-btn {
            padding: 0.5rem 0.8rem !important;
            border-radius: 1rem !important;
            margin-bottom: 1rem !important;
        }

        .back-dashboard-btn svg {
            width: 16px !important;
            height: 16px !important;
        }

        .back-dashboard-btn span {
            font-size: 0.7rem !important;
        }

        h2 {
            font-size: 1.25rem !important;
        }

        .btn-add {
            padding: 0.6rem 0.8rem !important;
            font-size: 0.7rem !important;
        }

        .btn-add svg {
            width: 14px !important;
            height: 14px !important;
        }

        .card {
            border-radius: 1.25rem !important;
        }

        table {
            font-size: 0.7rem !important;
        }

        th, td {
            padding: 0.6rem 0.5rem !important;
        }

        th {
            font-size: 0.6rem !important;
        }

        .action-btn {
            padding: 0.4rem !important;
        }

        .action-btn svg {
            width: 14px !important;
            height: 14px !important;
        }

        .user-avatar {
            width: 32px !important;
            height: 32px !important;
        }

        .user-avatar svg {
            width: 16px !important;
            height: 16px !important;
        }

        .badge {
            padding: 0.2rem 0.4rem !important;
            font-size: 0.6rem !important;
        }
    }

    @media (max-width: 360px) {
        .back-dashboard-btn {
            padding: 0.4rem 0.6rem !important;
        }

        .back-dashboard-btn span {
            font-size: 0.65rem !important;
        }

        h2 {
            font-size: 1.1rem !important;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .back-dashboard-btn {
            padding: 0.7rem 1rem !important;
        }
    }
</style>

<div class="users-page container mx-auto py-6 md:py-8 px-3 md:px-4">
    
    {{-- 🔙 زر الرجوع إلى لوحة التحكم (مناسب لجميع الشاشات) --}}
    <a href="{{ route('admin.dashboard') }}" 
       class="back-dashboard-btn inline-flex items-center gap-2 px-3 sm:px-5 py-2 sm:py-3 rounded-2xl mb-5 md:mb-6">
        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 transition-all duration-300" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" 
                  d="M15 19l-7-7 7-7"/>
        </svg>
        <span class="text-sm font-bold text-gray-600 transition-colors duration-300">
            <span class="hidden sm:inline">العودة للوحة التحكم</span>
            <span class="sm:hidden">لوحة التحكم</span>
        </span>
    </a>

    {{-- عنوان + عداد + زر الإضافة --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-5 md:mb-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">إدارة المستخدمين</h2>
            <p class="text-gray-500 text-xs sm:text-sm mt-1">إجمالي المسجلين: {{ $users->count() }} مستخدم</p>
        </div>
        
        <a href="{{ route('admin.users.create') }}" 
           class="btn-add inline-flex items-center text-white font-bold py-2 sm:py-2.5 px-3 sm:px-4 rounded-xl shadow-md transition duration-200 text-xs sm:text-sm w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-1 sm:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            إضافة مستخدم جديد
        </a>
    </div>

    {{-- رسائل التنبيه --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl mb-4 shadow-sm flex items-center text-xs sm:text-sm">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl mb-4 shadow-sm flex items-center text-xs sm:text-sm">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- جدول المستخدمين --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-right text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">المستخدم</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-right text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider hidden sm:table-cell">الدور</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    
                    @foreach($users as $user)
                    <tr class="table-row group">
                        {{-- الاسم والإيميل مع أيقونة رمزية --}}
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="user-avatar flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 group-hover:bg-blue-100 group-hover:text-blue-600 transition duration-300">
                                    <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div class="mr-3 sm:mr-4 text-right">
                                    <div class="text-xs sm:text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- الدور --}}
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                            @if($user->role == 1)
                                <span class="badge inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-md text-[10px] sm:text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">
                                    <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"></path></svg>
                                    مدير نظام
                                </span>
                            @else
                                <span class="badge inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-md text-[10px] sm:text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                    <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                    مستخدم
                                </span>
                            @endif
                        </td>

                        {{-- الحالة --}}
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-center">
                            @if($user->is_active)
                                <span class="badge px-2 sm:px-3 py-0.5 sm:py-1 inline-flex text-[10px] sm:text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                                    نشط
                                </span>
                            @else
                                <span class="badge px-2 sm:px-3 py-0.5 sm:py-1 inline-flex text-[10px] sm:text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                    موقوف
                                </span>
                            @endif
                        </td>

                        {{-- الإجراءات --}}
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center items-center gap-1 sm:gap-2">
                                
                                {{-- زر التعديل --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   class="action-btn p-1.5 sm:p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="تعديل">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                {{-- زر التفعيل/التوقيف --}}
                                <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" 
                                            class="action-btn p-1.5 sm:p-2 {{ $user->is_active ? 'text-amber-500 hover:bg-amber-50' : 'text-emerald-500 hover:bg-emerald-50' }} rounded-lg transition" 
                                            title="{{ $user->is_active ? 'توقيف' : 'تفعيل' }}">
                                        @if($user->is_active)
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        @else
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </button>
                                </form>

                                {{-- زر الحذف --}}
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn p-1.5 sm:p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="حذف">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection