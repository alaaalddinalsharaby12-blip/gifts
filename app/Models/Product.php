<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'stock',
        'is_active'
    ];

    protected $casts = [
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    // =========================
    // 📌 Scopes
    // =========================
    
    /**
     * المنتجات النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * المنتجات المعطلة
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * المنتجات المتوفرة (نشطة + مخزون > 0)
     */
    public function scopeAvailable($query)
    {
        return $query->active()->where('stock', '>', 0);
    }

    /**
     * المنتجات التي نفذت كميتها
     */
    public function scopeOutOfStock($query)
    {
        return $query->active()->where('stock', '<=', 0);
    }

    // =========================
    // 📌 Relationships
    // =========================

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_product')
            ->withPivot('value')
            ->withTimestamps();
    }

    // =========================
    // 📌 Helpers
    // =========================

    /**
     * الصورة الرئيسية
     */
    public function mainImage(): ?ProductImage
    {
        return $this->images()->first();
    }

    /**
     * هل يوجد صور؟
     */
    public function hasImages(): bool
    {
        return $this->images()->exists();
    }

    /**
     * هل المنتج متوفر؟
     */
    public function isAvailable(): bool
    {
        return $this->is_active && $this->stock > 0;
    }

    /**
     * هل المنتج معطل؟
     */
    public function isDisabled(): bool
    {
        return !$this->is_active;
    }

    /**
     * نص حالة المخزون
     */
    public function stockStatus(): string
    {
        if ($this->stock <= 0) {
            return 'نفذت الكمية';
        }
        if ($this->stock <= 5) {
            return 'باقي ' . $this->stock;
        }
        return 'متوفر';
    }

    /**
     * لون حالة المخزون
     */
    public function stockStatusColor(): string
    {
        if ($this->stock <= 0) {
            return 'red';
        }
        if ($this->stock <= 5) {
            return 'orange';
        }
        return 'green';
    }
}