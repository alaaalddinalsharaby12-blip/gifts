<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        // التحقق من الدور
        if (auth()->user()->role != 1) {
            return redirect('/')->with('error', 'ليس لديك صلاحية دخول هذه الصفحة');
        }

        // ✅ التحقق من حالة المستخدم (مفعل/موقوف)
        if (!Auth::user()->is_active) {
            Auth::logout();
            
            return redirect()->route('login')
                ->with('error', 'تم إيقاف حسابك. تواصل مع الإدارة.');
        }

        return $next($request);
    }
}