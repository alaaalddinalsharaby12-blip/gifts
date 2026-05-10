<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    protected $fillable = ['category_id', 'name', 'type'];

    public function options(): HasMany
    {
        return $this->hasMany(AttributeOption::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // ✅ العلاقة الصحيحة
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'attribute_product')
            ->withPivot('value')
            ->withTimestamps();
    }
}