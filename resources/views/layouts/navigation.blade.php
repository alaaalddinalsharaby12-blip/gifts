<nav class="fixed top-0 left-0 right-0 z-50" x-data="{ mobileMenu: false, userMenu: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     dir="rtl">
    <style>
        [x-cloak] { display: none !important; }

        .nav-luxury {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(139, 92, 246, 0.08);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .nav-luxury.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 8px 40px rgba(139, 92, 246, 0.1);
            border-bottom-color: rgba(139, 92, 246, 0.15);
        }

        .lux-link {
            position: relative;
            transition: all 0.3s ease;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            font-size: 0.85rem;
            font-weight: 800;
            color: #64748b;
        }

        .lux-link::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(139,92,246,0.1), rgba(245,158,11,0.05));
            border-radius: 1rem;
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .lux-link:hover, .lux-link.active {
            color: #8b5cf6 !important;
        }

        .lux-link:hover::before, .lux-link.active::before {
            opacity: 1;
            transform: scale(1);
        }

        .lux-link span, .lux-link svg {
            position: relative;
            z-index: 1;
        }

        .lux-btn-gold {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2);
            font-weight: 800;
        }

        .lux-btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.35);
            filter: brightness(1.1);
        }

        .lux-btn-outline {
            border: 2px solid #e2e8f0;
            color: #64748b;
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            background: white;
            font-weight: 800;
        }

        .lux-btn-outline:hover {
            border-color: #8b5cf6;
            color: #8b5cf6;
            background: rgba(139, 92, 246, 0.05);
            transform: translateY(-2px);
        }

        .lux-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 900;
            font-size: 0.9rem;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.25);
            transition: all 0.3s ease;
            border: 2px solid white;
            flex-shrink: 0;
        }

        .lux-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.35);
        }

        .lux-dropdown {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(139, 92, 246, 0.1);
            box-shadow: 0 25px 50px -12px rgba(139, 92, 246, 0.15);
            border-radius: 1.5rem;
            min-width: 280px;
            overflow: hidden;
        }

        .lux-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #475569;
            transition: all 0.3s ease;
            border-radius: 0.75rem;
            margin: 0.25rem;
        }

        .lux-dropdown-item:hover {
            background: linear-gradient(135deg, rgba(139,92,246,0.08), rgba(245,158,11,0.04));
            color: #8b5cf6;
            transform: translateX(-3px);
        }

        .lux-dropdown-item svg {
            width: 18px;
            height: 18px;
            opacity: 0.5;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .lux-dropdown-item:hover svg {
            opacity: 1;
            color: #8b5cf6;
            transform: scale(1.1);
        }

        .lux-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 0.5rem 1rem;
        }

        .lux-logout {
            color: #ef4444 !important;
        }

        .lux-logout:hover {
            background: linear-gradient(135deg, rgba(239,68,68,0.08), rgba(239,68,68,0.04)) !important;
            color: #dc2626 !important;
        }

        .lux-mobile {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(139, 92, 246, 0.1);
            box-shadow: 0 -10px 40px rgba(0,0,0,0.05);
        }

        .lux-mobile-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 800;
            color: #475569;
            border-radius: 1rem;
            transition: all 0.3s ease;
            margin: 0.25rem 0;
        }

        .lux-mobile-item:hover, .lux-mobile-item.active {
            background: linear-gradient(135deg, rgba(139,92,246,0.1), rgba(245,158,11,0.05));
            color: #8b5cf6;
        }

        .lux-mobile-item svg {
            width: 20px;
            height: 20px;
            opacity: 0.6;
            flex-shrink: 0;
        }

        .lux-mobile-item.active svg, .lux-mobile-item:hover svg {
            opacity: 1;
            color: #8b5cf6;
        }

        .lux-hamburger {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .lux-hamburger:hover {
            background: rgba(139, 92, 246, 0.08);
            color: #8b5cf6;
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { scrollbar-width: none; }

        .lux-logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            flex-shrink: 0;
        }

        .lux-logo-icon:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 12px 35px rgba(139, 92, 246, 0.4);
        }

        .lux-logo-text {
            font-size: 1.1rem;
            font-weight: 900;
            background: linear-gradient(135deg, #1e293b, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @media (max-width: 640px) {
            .lux-link {
                padding: 0.5rem 0.8rem;
                font-size: 0.75rem;
            }

            .lux-btn-gold,
            .lux-btn-outline {
                padding: 0.6rem 1rem;
                font-size: 0.75rem;
            }

            .lux-dropdown {
                min-width: 240px;
                right: 0;
                left: auto;
            }
        }

        @media (min-width: 1024px) {
            .lux-hamburger {
                display: none !important;
            }
        }
    </style>

    <div class="nav-luxury" :class="{ 'scrolled': scrolled }">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14 sm:h-16 lg:h-18">
                
                <div class="flex items-center gap-3 sm:gap-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-2.5 group shrink-0">
                        <div class="lux-logo-icon w-9 h-9 sm:w-10 sm:h-10">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="lux-logo-text text-sm sm:text-lg">مناسباتي</span>
                    </a>

                    <div class="hidden lg:flex items-center gap-1 border-r border-gray-100 pr-3 sm:pr-4">
                        <a href="{{ route('home') }}" class="lux-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>الرئيسية</span>
                        </a>

                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="lux-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                    </svg>
                                    <span class="hidden xl:inline">لوحة التحكم</span>
                                    <span class="xl:hidden">التحكم</span>
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="lux-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <span class="hidden xl:inline">المستخدمين</span>
                                    <span class="xl:hidden">المستخدم</span>
                                </a>
                            @endif
                            <a href="{{ route('orders.index') }}" class="lux-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span>{{ auth()->user()->isAdmin() ? 'الطلبات' : 'طلباتي' }}</span>
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    @auth
                        <div class="relative hidden lg:block" @click.away="userMenu = false">
                            <button @click="userMenu = !userMenu" class="flex items-center gap-2 sm:gap-3 p-1 sm:p-1.5 rounded-2xl hover:bg-gray-50 transition focus:outline-none">
                                <div class="text-right hidden xl:block">
                                    <p class="text-[9px] sm:text-[10px] text-gray-400 font-bold leading-none mb-1">مرحباً بك</p>
                                    <p class="text-[10px] sm:text-xs font-black text-gray-700 leading-none">{{ auth()->user()->name }}</p>
                                </div>
                                <div class="lux-avatar w-8 h-8 sm:w-[38px] sm:h-[38px] text-xs sm:text-sm">
                                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': userMenu }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="userMenu" x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 class="lux-dropdown absolute left-0 mt-3 z-50">
                                
                                <div class="px-4 sm:px-5 py-3 sm:py-4 border-b border-gray-100">
                                    <p class="text-xs sm:text-sm font-black text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] sm:text-xs text-gray-400 mt-1 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <div class="p-2">
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="lux-dropdown-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                            لوحة التحكم
                                        </a>
                                    @endif
                                    <a href="{{ route('orders.index') }}" class="lux-dropdown-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                        {{ auth()->user()->isAdmin() ? 'إدارة الطلبات' : 'طلباتي' }}
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="lux-dropdown-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        إعدادات الملف الشخصي
                                    </a>
                                    <div class="lux-divider"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="lux-dropdown-item lux-logout w-full text-right">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            تسجيل الخروج
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <button @click="mobileMenu = !mobileMenu" 
                                class="block lg:hidden lux-hamburger text-gray-600 focus:outline-none w-9 h-9 sm:w-10 sm:h-10">
                            <svg x-show="!mobileMenu" class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg x-show="mobileMenu" x-cloak class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                    @else
                        <div class="hidden lg:flex items-center gap-2">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="lux-btn-outline px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl font-bold text-xs sm:text-sm">إنشاء حساب</a>
                            @endif
                            <a href="{{ route('login') }}" class="lux-btn-gold px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl font-bold text-xs sm:text-sm">تسجيل الدخول</a>
                        </div>
                        
                        <button @click="mobileMenu = !mobileMenu" class="lux-hamburger lg:hidden text-gray-600 w-9 h-9 sm:w-10 sm:h-10">
                            <svg x-show="!mobileMenu" class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg x-show="mobileMenu" class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div x-show="mobileMenu" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="lux-mobile lg:hidden max-h-[85vh] overflow-y-auto no-scrollbar">

        <div class="p-3 sm:p-4 space-y-1">
            @auth
                <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 mb-2 sm:mb-3 bg-gradient-to-r from-violet-50 to-amber-50 rounded-2xl border border-violet-100">
                    <div class="lux-avatar w-8 h-8 sm:w-[38px] sm:h-[38px] text-xs sm:text-sm shrink-0">{{ mb_substr(auth()->user()->name, 0, 1) }}</div>
                    <div>
                        <p class="text-xs sm:text-sm font-black text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            @endauth

            <a href="{{ route('home') }}" class="lux-mobile-item text-sm sm:text-base {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                الرئيسية
            </a>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="lux-mobile-item text-sm sm:text-base {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        لوحة التحكم
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="lux-mobile-item text-sm sm:text-base {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        المستخدمين
                    </a>
                @endif
                <a href="{{ route('orders.index') }}" class="lux-mobile-item text-sm sm:text-base {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    {{ auth()->user()->isAdmin() ? 'إدارة الطلبات' : 'طلباتي' }}
                </a>
                <a href="{{ route('profile.edit') }}" class="lux-mobile-item text-sm sm:text-base">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    تعديل الملف الشخصي
                </a>

                <div class="lux-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="lux-mobile-item text-sm sm:text-base text-red-500 hover:bg-red-50 w-full text-right">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        تسجيل الخروج
                    </button>
                </form>
            @else
                <div class="pt-2 space-y-2">
                    <a href="{{ route('login') }}" class="lux-btn-gold block text-center py-3 rounded-xl font-bold text-sm">تسجيل الدخول</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="lux-btn-outline block text-center py-3 rounded-xl font-bold text-sm">إنشاء حساب جديد</a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
