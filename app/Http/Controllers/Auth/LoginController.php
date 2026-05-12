<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * تسجيل الدخول باستخدام name أو email أو phone
     */
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string', // name أو email أو phone
            'password' => 'required|string',
        ]);

        // البحث بالاسم أو البريد أو الهاتف
        $user = User::where('name', $request->login)
                    ->orWhere('email', $request->login)
                    ->orWhere('phone', $request->login)
                    ->first();

        // التحقق من وجود المستخدم وكلمة المرور
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['بيانات تسجيل الدخول غير صحيحة.'],
            ]);
        }

        // التحقق من تفعيل الحساب
        if (!$user->isActive()) {
            throw ValidationException::withMessages([
                'login' => ['الحساب غير مفعل، تواصل مع الإدارة.'],
            ]);
        }

        // تسجيل الدخول
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // توجيه حسب الدور
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    /**
     * تسجيل الخروج
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}