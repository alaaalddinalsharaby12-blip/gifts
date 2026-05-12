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

    .badge-count {
        background: linear-gradient(135deg, #f8d7e8, #fce7f3);
        color: #d63384;
        font-weight: 800;
    }

    .video-thumb {
        position: relative;
        width: 60px;
        height: 45px;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
    }

    .video-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .video-thumb .play-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .video-thumb:hover .play-overlay {
        opacity: 1;
    }

    .video-thumb .play-overlay svg {
        width: 16px;
        height: 16px;
        color: white;
    }

    /* مودال الفيديو */
    .video-modal {
        position: fixed;
        inset: 0;
        z-index: 50;
        background: rgba(0,0,0,0.9);
        backdrop-filter: blur(10px);
        display: none;
        align-items: center;
        justify-content: center;
    }

    .video-modal.active {
        display: flex;
    }

    .video-modal video {
        max-width: 90%;
        max-height: 80vh;
        border-radius: 20px;
    }

    .video-modal .close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .video-modal .close-btn:hover {
        color: #d63384;
        transform: rotate(90deg);
    }
</style>

<div class="container mx-auto py-10 px-4 max-w-6xl">

    <!-- الهيدر -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-gray-900">إدارة الأقسام </h2>
            <p class="text-gray-400 text-sm font-bold mt-1">إجمالي الأقسام: {{ $categories->count() }}</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary px-6 py-3 rounded-2xl font-black text-sm flex items-center gap-2 shadow-lg shadow-pink-200/50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
            </svg>
            إضافة قسم
        </a>
    </div>

    <!-- رسائل -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl mb-6 font-bold text-sm flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 font-bold text-sm flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">الصورة</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">الفيديو</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">الاسم</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">المحتوى</th>
                        <th class="px-6 py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">المنتجات</th>
                        <th class="px-6 py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-gray-400">{{ $category->id }}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 border border-gray-100">
                                @if($category->image)
                                    <img src="{{ asset('storage/'.$category->image) }}" class="w-full h-full object-cover" alt="{{ $category->name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($category->video)
                                <div class="video-thumb" onclick="openVideo('{{ asset('storage/'.$category->video) }}')">
                                    <img src="{{ asset('storage/'.$category->image) }}" alt="">
                                    <div class="play-overlay">
                                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                </div>
                            @else
                                <span class="text-xs text-gray-300 font-bold">—</span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-black text-gray-900">{{ $category->name }}</div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="text-xs text-gray-500 line-clamp-2 max-w-[180px] leading-relaxed">
                                {{ $category->contents ?? 'لا يوجد' }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="badge-count inline-flex items-center justify-center px-3 py-1 rounded-lg text-xs font-black">
                                {{ $category->products_count }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn-icon" title="تعديل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="حذف">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <span class="text-gray-400 font-bold text-sm">لا توجد أقسام</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- مودال الفيديو -->
<div id="videoModal" class="video-modal" onclick="closeVideo()">
    <div class="close-btn">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </div>
    <video id="modalVideo" controls onclick="event.stopPropagation()">
        <source src="" type="video/mp4">
    </video>
</div>

<script>
function openVideo(src) {
    const modal = document.getElementById('videoModal');
    const video = document.getElementById('modalVideo');
    video.src = src;
    modal.classList.add('active');
    video.play();
}

function closeVideo() {
    const modal = document.getElementById('videoModal');
    const video = document.getElementById('modalVideo');
    video.pause();
    video.src = '';
    modal.classList.remove('active');
}
</script>
@endsection