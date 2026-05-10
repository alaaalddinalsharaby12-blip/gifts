<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/* =========================
   FRONTEND CONTROLLERS
   ========================= */
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\OrderController as FrontendOrderController;

/* =========================
   ADMIN CONTROLLERS
   ========================= */
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/* =========================
   🏠 FRONTEND ROUTES
   ========================= */

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');

// عرض التصنيف
Route::get('/category/{id}', [HomeController::class, 'showCategory'])->name('category.show');

// عرض المنتج
Route::get('/product/{id}', [FrontendProductController::class, 'show'])->name('product.show');

// ✅ مسارات الطلبات (تحتاج تسجيل دخول) - مجموعة واحدة فقط
Route::middleware('auth')->group(function () {
    Route::get('/order/create/{product}', [FrontendOrderController::class, 'create'])->name('order.create');
    Route::post('/order/store', [FrontendOrderController::class, 'store'])->name('order.store');
    Route::get('/orders', [FrontendOrderController::class, 'index'])->name('orders.index');
});


/* =========================
   👤 DASHBOARD REDIRECT
   ========================= */
Route::get('/dashboard', function () {
    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

/* =========================
   👨‍💼 ADMIN ROUTES
   ========================= */
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // لوحة التحكم
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // التصنيفات
        Route::resource('categories', CategoryController::class);

        // المنتجات
        Route::resource('products', AdminProductController::class);

        // السمات (Attributes)
        Route::resource('attributes', AttributeController::class);

        // الطلبات
        Route::resource('orders', AdminOrderController::class);
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        // المستخدمين
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle', [UserController::class, 'toggle'])
            ->name('users.toggle');

        Route::delete('/products/images/{image}', [AdminProductController::class, 'deleteImage'])
            ->name('products.deleteImage');

        Route::patch('/products/{product}/toggle', [AdminProductController::class, 'toggleStatus'])
            ->name('products.toggleStatus');

        // جلب سمات التصنيف (API)
        Route::get('/categories/{id}/attributes', [CategoryController::class, 'attributes'])
            ->name('categories.attributes');
    });

/* =========================
   🔐 AUTH ROUTES
   ========================= */
require __DIR__.'/auth.php';