<footer class="relative overflow-hidden mt-auto" dir="rtl">
<style>
    .footer-lux {
        background: linear-gradient(180deg, rgba(248,250,252,0.98) 0%, rgba(255,255,255,0.95) 100%);
        backdrop-filter: blur(20px);
        border-top: 1px solid rgba(139, 92, 246, 0.08);
        position: relative;
    }

    .footer-lux::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #8b5cf6, #f59e0b, #8b5cf6);
        background-size: 200% 100%;
        animation: footer-shimmer 4s infinite;
    }

    @keyframes footer-shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .footer-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(100px);
        opacity: 0.4;
        pointer-events: none;
    }

    .footer-orb-1 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, rgba(139,92,246,0.3), rgba(124,58,237,0.1));
        top: -50%;
        left: 5%;
        animation: footer-float 20s ease-in-out infinite;
    }

    .footer-orb-2 {
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, rgba(245,158,11,0.2), rgba(217,119,6,0.1));
        top: -30%;
        right: 10%;
        animation: footer-float 25s ease-in-out infinite reverse;
    }

    @keyframes footer-float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(20px, -30px) scale(1.1); }
        66% { transform: translate(-15px, 15px) scale(0.9); }
    }

    .lux-footer-logo {
        transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        cursor: pointer;
    }

    .lux-footer-logo:hover {
        transform: translateY(-3px);
    }

    .lux-footer-logo-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 30px rgba(139, 92, 246, 0.25);
        transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .lux-footer-logo:hover .lux-footer-logo-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 40px rgba(139, 92, 246, 0.35);
    }

    .lux-footer-link {
        position: relative;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        padding: 0.5rem 0;
    }

    .lux-footer-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #8b5cf6, #f59e0b);
        border-radius: 2px;
        transition: width 0.4s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .lux-footer-link:hover {
        color: #8b5cf6;
        transform: translateY(-2px);
    }

    .lux-footer-link:hover::after {
        width: 100%;
    }

    .lux-footer-link svg {
        width: 16px;
        height: 16px;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateX(5px);
    }

    .lux-footer-link:hover svg {
        opacity: 1;
        transform: translateX(0);
        color: #8b5cf6;
    }

    .lux-social {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #94a3b8;
        transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        border: 1px solid transparent;
    }

    .lux-social:hover {
        background: linear-gradient(135deg, rgba(139,92,246,0.1), rgba(245,158,11,0.08));
        color: #8b5cf6;
        border-color: rgba(139, 92, 246, 0.2);
        transform: translateY(-4px) scale(1.1);
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);
    }

    .lux-social svg {
        width: 18px;
        height: 18px;
    }

    .lux-footer-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }

    .lux-copyright {
        font-size: 0.7rem;
        font-weight: 800;
        color: #94a3b8;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    /* استجابة */
    @media (max-width: 768px) {
        .lux-footer-grid {
            flex-direction: column;
            text-align: center;
            gap: 2rem;
        }

        .lux-footer-links {
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .lux-footer-social {
            justify-content: center;
        }
    }
</style>

    <!-- Orbs -->
    <div class="footer-orb footer-orb-1"></div>
    <div class="footer-orb footer-orb-2"></div>

    <div class="footer-lux relative z-10 py-10 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lux-footer-grid flex flex-col md:flex-row items-center justify-between gap-8 md:gap-12">

                <!-- Logo -->
                <div class="lux-footer-logo flex items-center gap-3" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                    <div class="lux-footer-logo-icon">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black bg-gradient-to-r from-gray-900 to-violet-600 bg-clip-text text-transparent">مناسباتي</h3>
                        <p class="text-[11px] text-gray-400 font-bold">نُضفي لمسة سحر على مناسباتك</p>
                    </div>
                </div>

                <!-- Links -->
                <nav class="lux-footer-links flex items-center gap-6 md:gap-8">
                    <a href="{{ route('home') }}" class="lux-footer-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        الرئيسية
                    </a>
                    <a href="{{ route('orders.index') }}" class="lux-footer-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        طلباتي
                    </a>
                    <a href="https://wa.me/966775122732" target="_blank" class="lux-footer-link" style="color: #10b981;">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        تواصل معنا
                    </a>
                </nav>

                <!-- Social & Copyright -->
                <div class="flex flex-col items-center md:items-end gap-4">
                    <div class="lux-footer-social flex items-center gap-2">
                        <a href="#" class="lux-social" aria-label="Twitter">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="lux-social" aria-label="Instagram">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://wa.me/966775122732" target="_blank" class="lux-social" aria-label="WhatsApp" style="color: #10b981;">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                    <p class="lux-copyright hidden md:block">&copy; {{ date('Y') }} مناسباتي</p>
                </div>
            </div>

            <!-- Mobile Copyright -->
            <div class="md:hidden mt-8 pt-6 lux-footer-divider text-center">
                <p class="lux-copyright">&copy; {{ date('Y') }} مناسباتي</p>
            </div>
        </div>
    </div>
</footer>