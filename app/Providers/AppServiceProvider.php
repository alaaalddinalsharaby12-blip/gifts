<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ✅ إجبار HTTPS في بيئة الإنتاج
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // ✅ تعريب Carbon
        Carbon::setLocale('ar');

        // ✅ عرض التصنيفات في الـ nav فقط إذا كان الاتصال متاح
        try {
            DB::connection()->getPdo();

            if (Schema::hasTable('categories')) {
                $categories = \App\Models\Category::all();
                View::share('navCategories', $categories);
            }
        } catch (\Exception $e) {
            // قاعدة البيانات غير متصلة، تجاهل
            View::share('navCategories', collect());
        }
    }
}