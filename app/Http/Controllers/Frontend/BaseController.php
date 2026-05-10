<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;

class BaseController extends Controller
{
    protected function shareData($data = [])
    {
        return array_merge($data, [
            'navCategories' => Category::all()
        ]);
    }
}