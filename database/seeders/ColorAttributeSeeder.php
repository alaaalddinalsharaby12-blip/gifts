<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\AttributeOption;

class ColorAttributeSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء سمة اللون
        $colorAttr = Attribute::create([
            'category_id' => 1, // اختر القسم المناسب
            'name' => 'اللون',
            'type' => 'color',
        ]);

        // إضافة الخيارات بالعربي
        $colors = [
            ['value' => '#FF0000', 'label_ar' => 'احمر'],
            ['value' => '#00FF00', 'label_ar' => 'اخضر'],
            ['value' => '#0000FF', 'label_ar' => 'ازرق'],
            ['value' => '#FFD700', 'label_ar' => 'ذهبي'],
            ['value' => '#FFFFFF', 'label_ar' => 'ابيض'],
            ['value' => '#000000', 'label_ar' => 'اسود'],
            ['value' => '#FFC0CB', 'label_ar' => 'وردي'],
            ['value' => '#800080', 'label_ar' => 'بنفسجي'],
            ['value' => '#FFA500', 'label_ar' => 'برتقالي'],
            ['value' => '#A52A2A', 'label_ar' => 'بني'],
        ];

        foreach ($colors as $color) {
            AttributeOption::create([
                'attribute_id' => $colorAttr->id,
                'value' => $color['value'],
                'label_ar' => $color['label_ar'],
            ]);
        }
    }
}