<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'contents', 
        'video', 
    ];

    /**
     * سمات القسم
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * جميع منتجات القسم
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * ✅ المنتجات النشطة فقط
     */
    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    /**
     * ✅ عدد المنتجات النشطة
     */
    public function activeProductsCount(): int
    {
        return $this->activeProducts()->count();
    }
}