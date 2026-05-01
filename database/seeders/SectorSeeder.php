<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Sector;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = [
            ['ar' => 'السيارات والمركبات وقطع الغيار', 'en' => 'Vehicles & Spare Parts', 'zh' => '汽车、车辆及零配件'],
            ['ar' => 'مواد ومعدات البناء', 'en' => 'Construction Materials & Equipment', 'zh' => '建筑材料及设备'],
            ['ar' => 'الطاقة والكهرباء والأنظمة الشمسية', 'en' => 'Energy & Electrical Systems', 'zh' => '能源、电力及太阳能系统'],
            ['ar' => 'البناء الجاهز والبيوت المتنقلة', 'en' => 'Prefabricated Buildings & Mobile Homes', 'zh' => '预制建筑及活动板房'],
            ['ar' => 'الأجهزة والإلكترونيات الاستهلاكية', 'en' => 'Electronics & Appliances', 'zh' => '消费电子及家电'],
            ['ar' => 'المعدات المكتبية والتقنية', 'en' => 'Office & IT Equipment', 'zh' => '办公及IT设备'],
            ['ar' => 'الأدوات المنزلية والمطبخ', 'en' => 'Home & Kitchen Appliances', 'zh' => '家用及厨房电器'],
            ['ar' => 'الديكور والأثاث والتصميم الداخلي', 'en' => 'Interior Design & Furniture', 'zh' => '室内设计及家具'],
            ['ar' => 'المستلزمات الشخصية والصحية', 'en' => 'Personal & Health Care', 'zh' => '个人及健康护理'],
            ['ar' => 'الملابس والأحذية والمنسوجات', 'en' => 'Apparel & Footwear', 'zh' => '服装、鞋类及纺织品'],
            ['ar' => 'الألعاب النارية وألعاب الأطفال', 'en' => 'Fireworks & Kids Toys', 'zh' => '烟花及儿童玩具'],
            ['ar' => 'مستلزمات الأم والطفل', 'en' => 'Mother & Baby Products', 'zh' => '母婴产品'],
            ['ar' => 'الأدوات واللوازم الصناعية والآلات', 'en' => 'Industrial Tools & Machinery', 'zh' => '工业工具及机械'],
            ['ar' => 'الأدوات الزراعية ومعدات الري', 'en' => 'Agricultural Tools & Equipment', 'zh' => '农具及灌溉设备'],
            ['ar' => 'المستلزمات الرياضية واللياقة', 'en' => 'Sports & Fitness Equipment', 'zh' => '运动及健身器材'],
            ['ar' => 'المنتجات الغذائية والمشروبات', 'en' => 'Food & Beverages', 'zh' => '食品及饮料'],
            ['ar' => 'الأدوات الطبية ومستلزمات المختبرات', 'en' => 'Medical & Laboratory Equipment', 'zh' => '医疗及实验室设备'],
            ['ar' => 'الإكسسوارات والهدايا والمجوهرات', 'en' => 'Accessories & Gifts', 'zh' => '配饰、礼品及珠宝'],
            ['ar' => 'الحيوانات الأليفة ومستلزماتها', 'en' => 'Pet Supplies', 'zh' => '宠物用品'],
            ['ar' => 'مستلزمات الضيافة والفنادق', 'en' => 'Hospitality Supplies', 'zh' => '酒店及招待用品'],
            ['ar' => 'الأدوات والمعدات العسكرية والأمنية', 'en' => 'Military & Security Equipment', 'zh' => '军用及安保设备'],
            ['ar' => 'معدات السلامة لشركات النفط والغاز', 'en' => 'Safety Equipment for Oil & Gas', 'zh' => '石油和天然气公司安全设备'],
            ['ar' => 'التعبئة والتغليف والطباعة', 'en' => 'Packaging & Printing', 'zh' => '包装及印刷'],
            ['ar' => 'المواد الكيميائية والبلاستيك', 'en' => 'Chemicals & Plastics', 'zh' => '化学品及塑料'],
        ];

        foreach ($sectors as $sector) {
            Sector::updateOrCreate(
                ['name_en' => $sector['en']],
                [
                    'name_ar' => $sector['ar'],
                    'name_zh' => $sector['zh'],
                ]
            );
        }
    }
}
