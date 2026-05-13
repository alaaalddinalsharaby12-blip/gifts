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

    .btn-primary {
        background: linear-gradient(135deg, #d63384 0%, #a61e63 100%);
        color: white;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(214, 51, 132, 0.3);
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        background: #f5f5f5;
        color: #666;
    }

    .btn-icon:hover {
        background: #f8d7e8;
        color: #d63384;
        transform: scale(1.1);
    }

    .btn-icon.delete:hover {
        background: #fee2e2;
        color: #ef4444;
    }

    .table-row {
        transition: all 0.3s ease;
    }

    .table-row:hover {
        background: rgba(214, 51, 132, 0.03);
    }

    .badge-type {
        background: linear-gradient(135deg, #f8d7e8, #fce7f3);
        color: #d63384;
        font-weight: 800;
    }

    .badge-type.text {
        background: linear-gradient(135deg, #dbeafe, #eff6ff);
        color: #2563eb;
    }

    .badge-type.select {
        background: linear-gradient(135deg, #f3e8ff, #faf5ff);
        color: #9333ea;
    }

    .badge-type.color {
        background: linear-gradient(135deg, #fce7f3, #fdf2f8);
        color: #db2777;
    }

    .option-badge {
        background: #f5f5f5;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }

    .option-badge:hover {
        background: #f8d7e8;
        transform: translateY(-1px);
    }

    .color-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .pagination-container nav {
        background: rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    /* ✅ زر الرجوع لـ Dashboard */
    .back-dashboard-btn {
        background: white;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }

    .back-dashboard-btn:hover {
        border-color: #d63384;
        background: #fdf2f8;
        box-shadow: 0 4px 15px rgba(214,51,132,0.1);
    }

    .back-dashboard-btn:hover svg {
        color: #d63384;
        transform: translateX(-3px);
    }

    .back-dashboard-btn:hover span {
        color: #a61e63;
    }

    /* 📱 تحسينات الموبايل */
    @media (max-width: 768px) {
        .container {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        
        .admin-card {
            border-radius: 1.5rem;
        }

        .btn-primary {
            padding: 0.75rem 1rem !important;
            font-size: 0.75rem !important;
            border-radius: 1rem !important;
        }

        .btn-primary svg {
            width: 1rem !important;
            height: 1rem !important;
        }

        .btn-icon {
            width: 32px !important;
            height: 32px !important;
        }

        .btn-icon svg {
            width: 14px !important;
            height: 14px !important;
        }

        table {
            font-size: 0.75rem;
        }

        th, td {
            padding: 0.75rem 0.5rem !important;
        }

        h2 {
            font-size: 1.25rem !important;
        }

        .badge-type {
            padding: 0.25rem 0.5rem !important;
            font-size: 0.65rem !important;
        }

        .option-badge {
            padding: 0.2rem 0.4rem !important;
            font-size: 0.65rem !important;
        }

        /* ✅ زر Dashboard في الموبايل */
        .back-dashboard-btn {
            padding: 0.6rem 0.9rem !important;
            border-radius: 1rem !important;
        }

        .back-dashboard-btn svg {
            width: 18px !important;
            height: 18px !important;
        }

        .back-dashboard-btn span {
            font-size: 0.75rem !important;
        }
    }

    /* 📱 موبايل صغير جداً */
    @media (max-width: 360px) {
        .back-dashboard-btn {
            padding: 0.5rem 0.7rem !important;
        }

        .back-dashboard-btn svg {
            width: 16px !important;
            height: 16px !important;
        }

        .back-dashboard-btn span {
            font-size: 0.7rem !important;
        }

        h2 {
            font-size: 1.1rem !important;
        }
    }

    /* 🖥️ تابلت */
    @media (min-width: 769px) and (max-width: 1024px) {
        .back-dashboard-btn {
            padding: 0.7rem 1rem !important;
        }
    }
</style>

<div class="container mx-auto py-6 md:py-10 px-3 md:px-4 max-w-6xl">

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

    <!-- الهيدر -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 md:mb-8">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-gray-900">السمات (Attributes)</h2>
            <p class="text-gray-400 text-xs sm:text-sm font-bold mt-1">إجمالي السمات: {{ $attributes->count() }}</p>
        </div>
        <a href="{{ route('admin.attributes.create') }}" 
           class="btn-primary px-4 sm:px-6 py-2.5 sm:py-3 rounded-2xl font-black text-xs sm:text-sm flex items-center gap-2 shadow-lg shadow-pink-200/50 w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
            </svg>
            إضافة سمة
        </a>
    </div>

    <!-- رسائل -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 sm:px-5 py-3 sm:py-4 rounded-2xl mb-5 md:mb-6 font-bold text-xs sm:text-sm flex items-center gap-2 sm:gap-3">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 sm:px-5 py-3 sm:py-4 rounded-2xl mb-5 md:mb-6 font-bold text-xs sm:text-sm flex items-center gap-2 sm:gap-3">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- الجدول -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">#</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">الاسم</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">النوع</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider hidden sm:table-cell">القسم</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider hidden md:table-cell">الخيارات</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($attributes as $attr)
                    <tr class="table-row">
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-black text-gray-400">{{ $attr->id }}</td>
                        
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm font-black text-gray-900">{{ $attr->name }}</div>
                        </td>
                        
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-center">
                            @php
                                $typeLabels = [
                                    'text' => 'نص',
                                    'select' => 'قائمة',
                                    'color' => 'لون',
                                ];
                            @endphp
                            <span class="badge-type {{ $attr->type }} inline-flex items-center justify-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-lg text-[10px] sm:text-xs font-black">
                                {{ $typeLabels[$attr->type] ?? $attr->type }}
                            </span>
                        </td>
                        
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                            <div class="text-xs sm:text-sm font-bold text-gray-700">
                                {{ $attr->category->name ?? 'غير محدد' }}
                            </div>
                        </td>
                        
                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden md:table-cell">
                            @if($attr->options && $attr->options->count() > 0)
                                <div class="flex flex-wrap gap-1 sm:gap-1.5 max-w-[400px]">
                                    @foreach($attr->options as $opt)
                                        <span class="option-badge inline-flex items-center gap-1 sm:gap-1.5 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-lg text-[10px] sm:text-xs font-bold">
                                            @if($attr->type == 'color')
                                                <span class="color-dot" style="background: {{ $opt->value }}"></span>
                                            @endif
                                            {{ $opt->label_ar ?? $opt->value }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-gray-300 font-bold">—</span>
                            @endif
                        </td>
                        
                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center items-center gap-1 sm:gap-2">
                                <a href="{{ route('admin.attributes.edit', $attr) }}" class="btn-icon" title="تعديل">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.attributes.destroy', $attr) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه السمة؟');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="حذف">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 sm:py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span class="text-gray-400 font-bold text-sm">لا توجد سمات حالياً</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- الترقيم -->
    @if($attributes->hasPages())
        <div class="pagination-container">
            {{ $attributes->links() }}
        </div>
    @endif
</div>
@endsection