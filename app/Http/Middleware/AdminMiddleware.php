<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // ✅ استخدام Methods من Model بدلاً من القيم المباشرة
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'ليس لديك صلاحية دخول هذه الصفحة');
        }

        // ✅ استخدام isActive() من Model
        if (!Auth::user()->isActive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'تم إيقاف حسابك. تواصل مع الإدارة.');
        }

        return $next($request);
    }
}