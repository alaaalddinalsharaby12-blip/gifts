<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // =========================
    // 📌 عرض المستخدمين (مع الترقيم)
    // =========================
    public function index()
    {
        $users = User::latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    // =========================
    // 📌 صفحة إضافة مستخدم
    // =========================
    public function create()
    {
        return view('admin.users.create');
    }

    // =========================
    // 📌 حفظ المستخدم
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:3|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|digits_between:6,15|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:0,1',
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'role'       => $request->role,
            'is_active'  => true,
            'password'   => $request->password,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم إضافة المستخدم بنجاح');
    }

    // =========================
    // 📌 عرض مستخدم واحد
    // =========================
    public function show(User $user)
    {
        $user->load(['orders' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.users.show', compact('user'));
    }

    // =========================
    // 📌 صفحة التعديل
    // =========================
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // =========================
    // 📌 تحديث المستخدم
    // =========================
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|min:3|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'required|string|digits_between:6,15|unique:users,phone,' . $user->id,
            'role'     => 'required|in:0,1',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    // =========================
    // 📌 حذف المستخدم
    // =========================
    public function destroy(User $user)
    {
        // لا يمكن حذف المستخدم نفسه
        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حذف حسابك');
        }

        // لا يمكن حذف آخر أدمن
        if ($user->role === 1 && User::where('role', 1)->count() <= 1) {
            return back()->with('error', 'لا يمكن حذف آخر مدير');
        }

        $user->delete();

        return back()->with('success', 'تم حذف المستخدم بنجاح');
    }

    // =========================
    // 📌 تفعيل / تعطيل المستخدم
    // =========================
    public function toggle(User $user)
    {
        // لا يمكن تعطيل حسابك
        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك تعطيل حسابك');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'تفعيل' : 'تعطيل';
        return back()->with('success', "تم {$status} المستخدم بنجاح");
    }
}