<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeOption extends Model
{
    protected $fillable = [
        'attribute_id', 
        'value',        // قيمة اللون (مثل: #FF0000)
        'label_ar',     // الاسم العربي (مثل: أحمر)
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}