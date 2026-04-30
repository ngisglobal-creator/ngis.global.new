<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Sector;
use App\Models\Branch;
use App\Models\Category;

class SectorDetailSeeder extends Seeder
{
    public function run(): void
    {
        // تنظيف البيانات الحالية لتجنب التكرار
        Category::query()->delete();
        Branch::query()->delete();

        // 1. Vehicles & Spare Parts
        $this->seedVehicles();

        // 2. Construction Materials & Equipment
        $this->seedConstruction();

        // 3. Energy, Electrical & Solar Systems
        $this->seedEnergy();

        // 4. Prefabricated Buildings & Mobile Homes
        $this->seedPrefab();

        // 8. Furniture, Decor & Furnishings
        $this->seedFurniture();
    }

    private function seedVehicles()
    {
        $sector = Sector::where('name_en', 'Vehicles & Spare Parts')->first();
        if (!$sector) return;

        // 1. Passenger Cars (ICE)
        $branchICE = Branch::create(['sector_id' => $sector->id, 'name_ar' => 'سيارات الركوب (وقود)', 'name_en' => 'Passenger Cars (ICE)', 'name_zh' => '乘用车 (燃油)']);
        $subCats = [
            ['ar' => 'أوروبية', 'en' => 'European', 'zh' => '欧洲车'],
            ['ar' => 'يابانية', 'en' => 'Japanese', 'zh' => '日本车'],
            ['ar' => 'كورية', 'en' => 'Korean', 'zh' => '韩国车'],
            ['ar' => 'صينية', 'en' => 'Chinese', 'zh' => '中国车'],
            ['ar' => 'أمريكية', 'en' => 'American', 'zh' => '美国车'],
            ['ar' => 'كهربائية بالكامل', 'en' => 'Full Electric', 'zh' => '纯电动'],
            ['ar' => 'هجينة', 'en' => 'Hybrid', 'zh' => '混合动力'],
        ];

        foreach (['جديدة' => 'New', 'مستعملة' => 'Used'] as $ar => $en) {
            $parentCat = Category::create(['branch_id' => $branchICE->id, 'name_ar' => $ar, 'name_en' => $en, 'name_zh' => $en == 'New' ? '新车' : '二手车']);
            foreach ($subCats as $sub) {
                Category::create(['branch_id' => $branchICE->id, 'parent_id' => $parentCat->id, 'name_ar' => $sub['ar'], 'name_en' => $sub['en'], 'name_zh' => $sub['zh']]);
            }
        }

        // 2. Electric & Hybrid Vehicles
        $branchEV = Branch::create(['sector_id' => $sector->id, 'name_ar' => 'المركبات الكهربائية والهجينة', 'name_en' => 'Electric & Hybrid Vehicles', 'name_zh' => '电动及混合动力汽车']);
        $evCats = [
            ['ar' => 'سيارات كهربائية بالكامل', 'en' => 'Full Electric (BEV)', 'zh' => '纯电动汽车 (BEV)'],
            ['ar' => 'سيارات هجينة', 'en' => 'Hybrid (HEV/PHEV)', 'zh' => '混合动力汽车 (HEV/PHEV)'],
            ['ar' => 'شاحنات بضائع كهربائية', 'en' => 'Electric Cargo Trucks', 'zh' => '电动载货卡车'],
            ['ar' => 'حافلات نقل كهربائية', 'en' => 'Electric Buses', 'zh' => '电动巴士'],
            ['ar' => 'محطات وشواحن المركبات', 'en' => 'EV Charging Stations & Chargers', 'zh' => '电动汽车充电站及充电器'],
        ];
        foreach ($evCats as $c) Category::create(['branch_id' => $branchEV->id, 'name_ar' => $c['ar'], 'name_en' => $c['en'], 'name_zh' => $c['zh']]);

        // 3. SUVs & Light Trucks
        $branchSUV = Branch::create(['sector_id' => $sector->id, 'name_ar' => 'سيارات الدفع الرباعي والنقل الخفيف', 'name_en' => 'SUVs & Light Trucks', 'name_zh' => 'SUV 及轻型卡车']);
        $suvCats = [
            ['ar' => 'سيارات دفع رباعي (4x4)', 'en' => 'SUV Vehicles', 'zh' => 'SUV 越野车'],
            ['ar' => 'شاحنات بيك آب', 'en' => 'Pick-up Trucks', 'zh' => '皮卡'],
            ['ar' => 'فانات نقل بضائع', 'en' => 'Cargo Vans', 'zh' => '货运面包车'],
        ];
        foreach ($suvCats as $c) Category::create(['branch_id' => $branchSUV->id, 'name_ar' => $c['ar'], 'name_en' => $c['en'], 'name_zh' => $c['zh']]);

        // 4. Heavy Trucks, Trailers & Tankers
        $branchHeavy = Branch::create(['sector_id' => $sector->id, 'name_ar' => 'الشاحنات الثقيلة والمقطورات والصهاريج', 'name_en' => 'Heavy Trucks, Trailers & Tankers', 'name_zh' => '重型卡车、挂车及油罐车']);
        $heavyCats = [
            ['ar' => 'رؤوس شاحنات (قاطرات)', 'en' => 'Tractor Heads', 'zh' => '牵引头'],
            ['ar' => 'شاحنات قلاب', 'en' => 'Dump Trucks', 'zh' => '自卸车'],
            ['ar' => 'شاحنات خرسانة (مضخات وخلاطات)', 'en' => 'Concrete Pumps & Mixers', 'zh' => '混凝土泵车及搅拌车'],
            ['ar' => 'صهاريج الوقود والغاز', 'en' => 'Fuel & Gas Tankers', 'zh' => '燃油及燃气罐车'],
            ['ar' => 'صهاريج المياه والصرف', 'en' => 'Water & Sewage Tankers', 'zh' => '水罐及排污罐车'],
            ['ar' => 'مقطورات بضائع مسطحة', 'en' => 'Flatbed Trailers', 'zh' => '平板挂车'],
            ['ar' => 'مقطورات تبريد (ثلاجات)', 'en' => 'Refrigerated Trailers', 'zh' => '冷藏挂车'],
            ['ar' => 'مقطورات ستائر وجوانب', 'en' => 'Curtain Side & Box Trailers', 'zh' => '侧帘及厢式挂车'],
            ['ar' => 'ناقلات المركبات والسيارات', 'en' => 'Car Carrier Trailers', 'zh' => '轿运车'],
            ['ar' => 'مقطورات منخفضة للمعدات الثقيلة', 'en' => 'Low-bed Trailers', 'zh' => '低平板挂车'],
            ['ar' => 'شاحنات نقل نفايات وضواغط', 'en' => 'Garbage & Compactor Trucks', 'zh' => '垃圾及压缩车'],
        ];
        foreach ($heavyCats as $c) Category::create(['branch_id' => $branchHeavy->id, 'name_ar' => $c['ar'], 'name_en' => $c['en'], 'name_zh' => $c['zh']]);

        // 5. Construction, Lifting & Handling Equipment
        $branchConst = Branch::create(['sector_id' => $sector->id, 'name_ar' => 'معدات الإنشاء والرفع والمناولة', 'name_en' => 'Construction, Lifting & Handling Equipment', 'name_zh' => '建筑、起重及搬运设备']);
        $constCats = [
            ['ar' => 'جرافات (بلدوزر)', 'en' => 'Bulldozers', 'zh' => '推土机'],
            ['ar' => 'لوادر أمامية وخلفية', 'en' => 'Front & Backhoe Loaders', 'zh' => '装载机'],
            ['ar' => 'حفارات هيدروليكية (جنزير/كاوتش)', 'en' => 'Hydraulic Excavators', 'zh' => '液压挖掘机'],
            ['ar' => 'رافعات شوكية ديزل وكهرباء', 'en' => 'Forklifts (Diesel/Electric)', 'zh' => '叉车'],
            ['ar' => 'رافعات تلسكوبية', 'en' => 'Telehandlers', 'zh' => '伸缩臂叉装机'],
            ['ar' => 'رافعات برجية ومحمولة', 'en' => 'Tower & Mobile Cranes', 'zh' => '塔式及随车起重机'],
            ['ar' => 'مداحل ومكابس طرق', 'en' => 'Road Rollers & Compactors', 'zh' => '压路机及夯实机'],
            ['ar' => 'مسويات طرق (جريدر)', 'en' => 'Motor Graders', 'zh' => '平地机'],
            ['ar' => 'رافعات سلة (مقصية وتلسكوبية)', 'en' => 'Manlifts & Scissor Lifts', 'zh' => '高空作业平台'],
            ['ar' => 'معدات حفر الأنفاق والآبار', 'en' => 'Drilling & Tunnelling Equipment', 'zh' => '钻探及隧道设备'],
        ];
        foreach ($constCats as $c) Category::create(['branch_id' => $branchConst->id, 'name_ar' => $c['ar'], 'name_en' => $c['en'], 'name_zh' => $c['zh']]);

        // 6. Bicycles & Motorbikes
        $branchCycle = Branch::create(['sector_id' => $sector->id, 'name_ar' => 'الدراجات والمواتر', 'name_en' => 'Bicycles & Motorbikes', 'name_zh' => '自行车及摩托车']);
        $cycleCats = [
            ['ar' => 'دراجات نارية (وقود)', 'en' => 'Motorbikes', 'zh' => '摩托车'],
            ['ar' => 'دراجات وسكوتورات كهربائية', 'en' => 'E-Bikes & E-Scooters', 'zh' => '电动自行车及踏板车'],
            ['ar' => 'دراجات هوائية وجبلية', 'en' => 'Bicycles', 'zh' => '自行车'],
        ];
        foreach ($cycleCats as $c) Category::create(['branch_id' => $branchCycle->id, 'name_ar' => $c['ar'], 'name_en' => $c['en'], 'name_zh' => $c['zh']]);

        // 7. Spare Parts & Components
        $branchParts = Branch::create(['sector_id' => $sector->id, 'name_ar' => 'قطع الغيار والمكملات', 'name_en' => 'Spare Parts & Components', 'name_zh' => '零配件']);
        $partCats = [
            ['ar' => 'قطع المحرك والميكانيك', 'en' => 'Engine & Mechanical Parts', 'zh' => '发动机及机械零部件'],
            ['ar' => 'ناقلات الحركة والدوران', 'en' => 'Transmissions & Drivetrain', 'zh' => '变速箱及传动系统'],
            ['ar' => 'بطاريات وأنظمة كهربائية', 'en' => 'Batteries & Electrical Systems', 'zh' => '电池及电气系统'],
            ['ar' => 'أنظمة الفرامل والتعليق', 'en' => 'Brakes & Suspension Systems', 'zh' => '制动及悬 Mary 系统'],
            ['ar' => 'الإطارات والجنوط', 'en' => 'Tires & Rims', 'zh' => '轮胎及轮毂'],
            ['ar' => 'الإضاءة والمصابيح', 'en' => 'Lighting & Lamps', 'zh' => '灯具及照明'],
            ['ar' => 'قطع الهيكل والخارجية', 'en' => 'Body & Exterior Parts', 'zh' => '车身及外观件'],
            ['ar' => 'تجهيزات المقصورة والداخلية', 'en' => 'Interior Parts & Trim', 'zh' => '内饰件'],
            ['ar' => 'فلاتر ومواد استهلاكية', 'en' => 'Filters & Consumables', 'zh' => '滤清器及易损件'],
            ['ar' => 'زيوت وشحوم المحركات', 'en' => 'Engine Oils & Lubricants', 'zh' => '机油及润滑油'],
            ['ar' => 'إكسسوارات وتزيين السيارات', 'en' => 'Car Accessories & Tuning', 'zh' => '汽车配件及改装'],
            ['ar' => 'معدات الورش وأدوات الفحص', 'en' => 'Garage & Diagnostic Tools', 'zh' => '修理厂及诊断工具'],
        ];
        foreach ($partCats as $c) Category::create(['branch_id' => $branchParts->id, 'name_ar' => $c['ar'], 'name_en' => $c['en'], 'name_zh' => $c['zh']]);
    }

    private function seedConstruction()
    {
        $sector = Sector::where('name_en', 'Construction Materials & Equipment')->first();
        if (!$sector) return;

        $branches = [
            [
                'ar' => 'مواد البناء الأساسية', 'en' => 'Basic Construction Materials', 'zh' => '基础建材',
                'cats' => [
                    ['ar' => 'الأسمنت والجبس والنورة', 'en' => 'Cement, Gypsum & Lime', 'zh' => '水泥、石膏及石灰'],
                    ['ar' => 'الحديد والصلب والمعادن الإنشائية', 'en' => 'Construction Steel & Metals', 'zh' => '建筑用钢材及金属'],
                    ['ar' => 'الطوب والبلوك والخرسانة الجاهزة', 'en' => 'Bricks, Blocks & Ready-mix Concrete', 'zh' => '砖、砌块及预拌混凝土'],
                    ['ar' => 'الأخشاب الإنشائية والألواح', 'en' => 'Construction Timber & Panels', 'zh' => '建筑用木材及板材'],
                ]
            ],
            [
                'ar' => 'مواد الإكساء والتشطيب الداخلي', 'en' => 'Interior Finishing Materials', 'zh' => '室内装修材料',
                'cats' => [
                    ['ar' => 'الرخام والحجر والجرانيت والترازيتو', 'en' => 'Marble, Stone & Granite', 'zh' => '大理石、石材及花岗岩'],
                    ['ar' => 'السيراميك والبورسلان والأرضيات الخشبية', 'en' => 'Ceramics, Porcelain & Parquet', 'zh' => '陶瓷、瓷砖及木地板'],
                    ['ar' => 'الدهانات والطلاء ومواد التغليف', 'en' => 'Paints, Coatings & Wall Coverings', 'zh' => '油漆、涂料及墙面材料'],
                    ['ar' => 'الأسقف المستعارة والقواطع الجبسية', 'en' => 'False Ceilings & Gypsum Board', 'zh' => '吊顶及石膏板隔断'],
                ]
            ],
            [
                'ar' => 'مواد العزل والتسريب', 'en' => 'Insulation & Waterproofing Materials', 'zh' => '绝缘及防水材料',
                'cats' => [
                    ['ar' => 'العزل الحراري والصوتي', 'en' => 'Thermal & Acoustic Insulation', 'zh' => '隔热及隔音'],
                    ['ar' => 'عزل المياه والرطوبة (البتومين)', 'en' => 'Waterproofing & Bitumen', 'zh' => '防水及沥青'],
                    ['ar' => 'المواد الكيميائية للبناء والغراء', 'en' => 'Construction Chemicals & Adhesives', 'zh' => '建筑化学品及粘合剂'],
                ]
            ],
            [
                'ar' => 'الأنظمة الصحية والسباكة', 'en' => 'Sanitary & Plumbing Systems', 'zh' => '卫浴及管道系统',
                'cats' => [
                    ['ar' => 'أطقم الحمامات والمراحيض', 'en' => 'Bathroom Sets & Toilets', 'zh' => '卫浴套装及马桶'],
                    ['ar' => 'الأنابيب والمواسير والوصلات (PPR/PVC)', 'en' => 'Pipes & Fittings', 'zh' => '管道及配件'],
                    ['ar' => 'مضخات المياه والخزانات والسخانات', 'en' => 'Pumps, Tanks & Water Heaters', 'zh' => '水泵、水箱及热水器'],
                    ['ar' => 'الخلاطات والمحابس والإكسسوارات الصحية', 'en' => 'Faucets, Valves & Accessories', 'zh' => '水龙头、阀门及卫浴配件'],
                ]
            ],
            [
                'ar' => 'الأبواب والنوافذ والواجهات', 'en' => 'Doors, Windows & Facades', 'zh' => '门窗及幕墙',
                'cats' => [
                    ['ar' => 'الأبواب والبوابات المعدنية والخشبية', 'en' => 'Doors & Gates', 'zh' => '门及大门'],
                    ['ar' => 'نوافذ الألمنيوم والـ (UPVC) والمطابخ', 'en' => 'Aluminium & UPVC Windows', 'zh' => '铝合金及 UPVC 窗'],
                    ['ar' => 'الزجاج والواجهات والسواتر', 'en' => 'Glass, Facades & Shutters', 'zh' => '玻璃、幕墙及百叶窗'],
                    ['ar' => 'الأقفال والمقابض وإكسسوارات الأبواب', 'en' => 'Locks, Handles & Hardware', 'zh' => '门锁、把手及五金件'],
                ]
            ],
            [
                'ar' => 'الآلات والمعدات الإنشائية الثابتة', 'en' => 'Stationary Construction Machinery', 'zh' => '固定式建筑机械',
                'cats' => [
                    ['ar' => 'خلاطات الخرسانة والمولدات', 'en' => 'Concrete Mixers & Power Generators', 'zh' => '混凝土搅拌机及发电机'],
                    ['ar' => 'ماكينات قص الرخام والسيراميك', 'en' => 'Marble & Ceramic Cutting Machines', 'zh' => '石材及陶瓷切割机'],
                    ['ar' => 'معدات ضخ الخرسانة الثابتة', 'en' => 'Stationary Concrete Pumps', 'zh' => '固定式混凝土泵'],
                    ['ar' => 'معدات الحفر والثقب الأرضي', 'en' => 'Ground Drilling & Boring Equipment', 'zh' => '地面钻探及钻孔设备'],
                ]
            ],
            [
                'ar' => 'العدد والأدوات والمعدات الخفيفة', 'en' => 'Tools & Light Equipment', 'zh' => '工具及小型设备',
                'cats' => [
                    ['ar' => 'العدد الكهربائية (دريل، منشار، هيلتي)', 'en' => 'Power Tools (Drills, Saws, Hammers)', 'zh' => '电动工具 (钻、锯、锤)'],
                    ['ar' => 'العدد اليدوية للبناء والقياس', 'en' => 'Manual Tools & Measuring Devices', 'zh' => '手动工具及测量设备'],
                    ['ar' => 'معدات اللحام والقص والجلخ', 'en' => 'Welding, Cutting & Grinding Equipment', 'zh' => '焊接、切割及打磨设备'],
                    ['ar' => 'السقالات وأنظمة الدعم والقوالب', 'en' => 'Scaffolding, Shoring & Formwork', 'zh' => '脚手架、支撑及模板'],
                ]
            ],
            [
                'ar' => 'معدات الموقع والسلامة المهنية', 'en' => 'Site Equipment & Occupational Safety', 'zh' => '工地设备及职业安全',
                'cats' => [
                    ['ar' => 'حواجز وأسوار المواقع المؤقتة', 'en' => 'Site Fencing & Barriers', 'zh' => '工地围栏及障碍物'],
                    ['ar' => 'أبراج الإضاءة الموقعنية', 'en' => 'Mobile Light Towers', 'zh' => '移动灯塔'],
                    ['ar' => 'معدات السلامة الشخصية (خوذ، أحذية، أحزمة)', 'en' => 'PPE (Helmets, Boots, Harnesses)', 'zh' => '个人防护装备'],
                    ['ar' => 'صناديق العدة وتجهيزات الورش', 'en' => 'Tool Boxes & Workshop Setup', 'zh' => '工具箱及车间配套'],
                ]
            ],
        ];

        foreach ($branches as $b) {
            $branch = Branch::create(['sector_id' => $sector->id, 'name_ar' => $b['ar'], 'name_en' => $b['en'], 'name_zh' => $b['zh']]);
            foreach ($b['cats'] as $c) {
                Category::create(['branch_id' => $branch->id, 'name_ar' => $c['ar'], 'name_en' => $c['en'], 'name_zh' => $c['zh']]);
            }
        }
    }

    private function seedEnergy()
    {
        $sector = Sector::where('name_en', 'Energy & Electrical Systems')->first();
        if (!$sector) return;

        $branches = [
            [
                'ar' => 'الأنظمة والطاقة الشمسية', 'en' => 'Solar Energy Systems', 'zh' => '太阳能系统',
                'cats' => [
                    ['ar' => 'الألواح الشمسية (مونو وكريستال)', 'en' => 'Solar Panels', 'zh' => '太阳能电池板'],
                    ['ar' => 'المحولات الكهربائية (إنفيرتر)', 'en' => 'Solar Inverters', 'zh' => '太阳能逆变器'],
                    ['ar' => 'بطاريات تخزين الطاقة (ليثيوم/جيل)', 'en' => 'Solar Storage Batteries', 'zh' => '太阳能储能电池'],
                    ['ar' => 'هياكل وقواعد تثبيت الألواح', 'en' => 'Solar Mounting & Racking Systems', 'zh' => '太阳能支架系统'],
                    ['ar' => 'سخانات المياه الشمسية', 'en' => 'Solar Water Heaters', 'zh' => '太阳能热水器'],
                ]
            ],
            [
                'ar' => 'توليد الطاقة والمولدات', 'en' => 'Power Generation & Generators', 'zh' => '发电及发电机',
                'cats' => [
                    ['ar' => 'مولدات الديزل والبنزين', 'en' => 'Diesel & Gasoline Generators', 'zh' => '柴油及汽油发电机'],
                    ['ar' => 'مولدات الغاز والطاقة الصامتة', 'en' => 'Gas & Silent Generators', 'zh' => '气体及静音发电机'],
                    ['ar' => 'توربينات الرياح الصغيرة', 'en' => 'Small Wind Turbines', 'zh' => '小型风力发电机'],
                    ['ar' => 'مقطورات الطاقة والمولدات المتنقلة', 'en' => 'Mobile Power Units', 'zh' => '移动电源单元'],
                ]
            ],
            [
                'ar' => 'التوزيع والتحكم الكهربائي', 'en' => 'Electrical Distribution & Control', 'zh' => '配电及控制',
                'cats' => [
                    ['ar' => 'المحولات الكهربائية (توزيع وقدرة)', 'en' => 'Power Transformers', 'zh' => '变压器'],
                    ['ar' => 'لوحات التوزيع والقواطع (DB)', 'en' => 'Distribution Boards & Circuit Breakers', 'zh' => '配电板及断路器'],
                    ['ar' => 'كبائن التحكم والتشغيل', 'en' => 'Control Panels', 'zh' => '控制柜'],
                    ['ar' => 'المنظمات ومثبتات الجهد', 'en' => 'Voltage Stabilizers & Regulators', 'zh' => '稳压器'],
                ]
            ],
            [
                'ar' => 'الكابلات والأسلاك والتوصيلات', 'en' => 'Cables, Wires & Wiring', 'zh' => '电缆、电线及布线',
                'cats' => [
                    ['ar' => 'كابلات الضغط العالي والمتوسط', 'en' => 'High & Medium Voltage Cables', 'zh' => '高压及中压电缆'],
                    ['ar' => 'أسلاك البناء والتوصيلات المنزلية', 'en' => 'Building Wires & House Wiring', 'zh' => '建筑电线'],
                    ['ar' => 'كابلات الألياف البصرية والبيانات', 'en' => 'Fiber Optic & Data Cables', 'zh' => '光纤及数据电缆'],
                    ['ar' => 'حوامل الكابلات والمواسير الكهربائية', 'en' => 'Cable Trays & Conduits', 'zh' => '电缆桥架及导管'],
                ]
            ],
            [
                'ar' => 'الإضاءة والأنظمة الضوئية', 'en' => 'Lighting & Optical Systems', 'zh' => '照明系统',
                'cats' => [
                    ['ar' => 'إضاءة الشوارع والساحات (LED)', 'en' => 'Street & Area Lighting', 'zh' => '路灯及区域照明'],
                    ['ar' => 'الإضاءة الصناعية والمستودعات', 'en' => 'Industrial & Warehouse Lighting', 'zh' => '工业及仓库照明'],
                    ['ar' => 'كشافات الطاقة الشمسية', 'en' => 'Solar Flood Lights', 'zh' => '太阳能泛光灯'],
                    ['ar' => 'وحدات الإضاءة الداخلية والمعمارية', 'en' => 'Indoor & Architectural Lighting', 'zh' => '室内及建筑照明'],
                ]
            ],
            [
                'ar' => 'المفاتيح والمقابس والتأسيس', 'en' => 'Switches, Sockets & Installation', 'zh' => '开关、插座及安装',
                'cats' => [
                    ['ar' => 'المفاتيح والأفياش الجدارية', 'en' => 'Wall Switches & Sockets', 'zh' => '墙壁开关及插座'],
                    ['ar' => 'صناديق التأسيس والقسامات', 'en' => 'Junction Boxes & Wall Boxes', 'zh' => '接线盒'],
                    ['ar' => 'المقابس والتوصيلات الصناعية', 'en' => 'Industrial Plugs & Sockets', 'zh' => '工业插头及插座'],
                ]
            ],
            [
                'ar' => 'أنظمة الطاقة الاحتياطية', 'en' => 'Backup Power Systems', 'zh' => '备用电源系统',
                'cats' => [
                    ['ar' => 'أجهزة الـ (UPS) لانقطاع التيار', 'en' => 'Uninterruptible Power Supplies', 'zh' => '不间断电源'],
                    ['ar' => 'مخازن الطاقة والشواحن العملاقة', 'en' => 'Power Banks & Energy Storage', 'zh' => '储能电源'],
                    ['ar' => 'بطاريات الدورة العميقة للانظمة', 'en' => 'Deep Cycle Batteries', 'zh' => '深循环电池'],
                ]
            ],
            [
                'ar' => 'القياس والفحص والسلامة', 'en' => 'Measurement, Testing & Safety', 'zh' => '测量、测试及安全',
                'cats' => [
                    ['ar' => 'عدادات الكهرباء (ذكية وعادية)', 'en' => 'Electric Meters', 'zh' => '电表'],
                    ['ar' => 'أجهزة الفحص (ملتي ميتر)', 'en' => 'Electrical Test Equipment', 'zh' => '电气测试设备'],
                    ['ar' => 'أنظمة التأريض ومانعات الصواعق', 'en' => 'Grounding & Lightning Protection', 'zh' => '接地及防雷保护'],
                    ['ar' => 'ملابس ومعدات العزل الكهربائي', 'en' => 'Electrical Insulation Gear', 'zh' => '电气绝缘装备'],
                ]
            ],
        ];

        foreach ($branches as $b) {
            $branch = Branch::create(['sector_id' => $sector->id, 'name_ar' => $b['ar'], 'name_en' => $b['en'], 'name_zh' => $b['zh']]);
            foreach ($b['cats'] as $c) {
                Category::create(['branch_id' => $branch->id, 'name_ar' => $c['ar'], 'name_en' => $c['en'], 'name_zh' => $c['zh']]);
            }
        }
    }

    private function seedPrefab()
    {
        $sector = Sector::where('name_en', 'Prefabricated Buildings & Mobile Homes')->first();
        if (!$sector) return;

        $branches = [
            [
                'ar' => 'البيوت والفلل الجاهزة', 'en' => 'Prefabricated Houses & Villas', 'zh' => '预制房及别墅',
                'cats' => [
                    ['ar' => 'فلل الفولاذ الخفيف', 'en' => 'Light Steel Villas', 'zh' => '轻钢别墅'],
                    ['ar' => 'المنازل الخشبية والأكواخ', 'en' => 'Wooden Houses & Cottages', 'zh' => '木屋及小屋'],
                    ['ar' => 'المباني السكنية مسبقة الصب', 'en' => 'Precast Residential Buildings', 'zh' => '预制住宅楼'],
                ]
            ],
            [
                'ar' => 'الكرفانات والوحدات المتنقلة', 'en' => 'Caravans & Mobile Units', 'zh' => '大篷车及移动单元',
                'cats' => [
                    ['ar' => 'مكاتب موقع متنقلة', 'en' => 'Mobile Site Offices', 'zh' => '移动现场办公室'],
                    ['ar' => 'كرفانات السكن والمعيشة', 'en' => 'Living Caravans', 'zh' => '居住大篷车'],
                    ['ar' => 'وحدات سكن العمال والكامبات', 'en' => 'Labor Camp Units', 'zh' => '员工营地单元'],
                ]
            ],
            [
                'ar' => 'الحاويان المعدّلة (الكونتينر)', 'en' => 'Modified Containers', 'zh' => '改装集装箱',
                'cats' => [
                    ['ar' => 'مقاهي ومحلات الحاويات', 'en' => 'Container Cafes & Shops', 'zh' => '集装箱咖啡店及商店'],
                    ['ar' => 'حاويات سكنية ومكتبية', 'en' => 'Living & Office Containers', 'zh' => '居住及办公集装箱'],
                    ['ar' => 'حاويات التخزين والتبريد', 'en' => 'Storage & Reefer Containers', 'zh' => '存储及冷藏集装箱'],
                ]
            ],
            [
                'ar' => 'الكبسولات والوحدات الذكية', 'en' => 'Smart Pods & Capsules', 'zh' => '智能舱及胶囊房',
                'cats' => [
                    ['ar' => 'كبسولات النوم والإقامة الفندقية', 'en' => 'Sleeping Capsules', 'zh' => '睡眠胶囊'],
                    ['ar' => 'وحدات الإقامة الزجاجية (البانوراما)', 'en' => 'Panoramic Living Pods', 'zh' => '全景生活舱'],
                    ['ar' => 'كبائن الحدائق الذكية', 'en' => 'Smart Garden Pods', 'zh' => '智能花园舱'],
                ]
            ],
            [
                'ar' => 'الغرف والمباني الخدمية', 'en' => 'Service Buildings & Booths', 'zh' => '服务性建筑及岗亭',
                'cats' => [
                    ['ar' => 'غرف الحراسة والأمن', 'en' => 'Guard Rooms & Security Booths', 'zh' => '保安岗亭'],
                    ['ar' => 'دورات مياه متنقلة (فايبر/معدن)', 'en' => 'Portable Toilets', 'zh' => '移动厕所'],
                    ['ar' => 'مساجد وعيادات جاهزة', 'en' => 'Prefabricated Mosques & Clinics', 'zh' => '预制清真寺及诊所'],
                ]
            ],
            [
                'ar' => 'الهناجر والهياكل الصناعية', 'en' => 'Warehouses & Steel Structures', 'zh' => '仓库及钢结构',
                'cats' => [
                    ['ar' => 'هناجر التخزين العملاقة', 'en' => 'Large Storage Warehouses', 'zh' => '大型存储仓库'],
                    ['ar' => 'مظلات المواقف والهياكل الفراغية', 'en' => 'Car Shades & Space Frames', 'zh' => '车棚及空间网架'],
                    ['ar' => 'صالات العرض والمصانع الجاهزة', 'en' => 'Prefab Factories & Showrooms', 'zh' => '预制工厂及展厅'],
                ]
            ],
            [
                'ar' => 'الألواح والمواد التكميلية', 'en' => 'Panels & Component Materials', 'zh' => '板材及组件材料',
                'cats' => [
                    ['ar' => 'ألواح السندوتش بانل (EPS/PU/Rockwool)', 'en' => 'Sandwich Panels', 'zh' => '夹芯板'],
                    ['ar' => 'ألواح الفايبر سيمنت والبورد', 'en' => 'Fiber Cement & Boards', 'zh' => '纤维水泥板'],
                    ['ar' => 'هياكل الفولاذ المجلفن', 'en' => 'Galvanized Steel Frames', 'zh' => '镀锌钢架'],
                ]
            ],
            [
                'ar' => 'الخيام والسواتر الحديثة', 'en' => 'Modern Tents & Tensile Covers', 'zh' => '现代帐篷及张拉膜结构',
                'cats' => [
                    ['ar' => 'خيام المناسبات والقاعات المتنقلة', 'en' => 'Event Tents', 'zh' => '活动帐篷'],
                    ['ar' => 'خيام التخييم والرحلات الفاخرة (Glamping)', 'en' => 'Glamping Tents', 'zh' => '豪华露营帐篷'],
                    ['ar' => 'سواتر القماش والبي في سي', 'en' => 'PVC & Fabric Structures', 'zh' => 'PVC 及织物结构'],
                ]
            ],
        ];

        foreach ($branches as $b) {
            $branch = Branch::create(['sector_id' => $sector->id, 'name_ar' => $b['ar'], 'name_en' => $b['en'], 'name_zh' => $b['zh']]);
            foreach ($b['cats'] as $c) {
                Category::create(['branch_id' => $branch->id, 'name_ar' => $c['ar'], 'name_en' => $c['en'], 'name_zh' => $c['zh']]);
            }
        }
    }

    private function seedFurniture()
    {
        $sector = Sector::where('name_en', 'Interior Design & Furniture')->first();
        if (!$sector) return;

        $branches = [
            [
                'ar' => 'أثاث المنازل', 'en' => 'Home Furniture', 'zh' => '家居家具',
                'cats' => [
                    ['ar' => 'أطقم كنب وغرف معيشة', 'en' => 'Sofas & Living Room Sets', 'zh' => '沙发及客厅套装'],
                    ['ar' => 'غرف النوم والأسرة', 'en' => 'Bedroom Sets & Beds', 'zh' => '卧室套装及床'],
                    ['ar' => 'طاولات الطعام والكراسي', 'en' => 'Dining Tables & Chairs', 'zh' => '餐桌椅'],
                    ['ar' => 'خزائن الملابس والدواليب', 'en' => 'Wardrobes & Cabinets', 'zh' => '衣柜及厨柜'],
                ]
            ],
            [
                'ar' => 'أثاث المكاتب والشركات', 'en' => 'Office & Corporate Furniture', 'zh' => '办公及企业家具',
                'cats' => [
                    ['ar' => 'مكاتب وطاولات اجتماعات', 'en' => 'Office Desks & Meeting Tables', 'zh' => '办公桌及会议桌'],
                    ['ar' => 'كراسي مكتبية وطبية', 'en' => 'Office & Ergonomic Chairs', 'zh' => '办公椅'],
                    ['ar' => 'خزائن ملفات ووحدات تخزين', 'en' => 'Filing Cabinets & Storage Units', 'zh' => '文件柜及存储单元'],
                    ['ar' => 'قواطع ومكاتب مفتوحة', 'en' => 'Office Partitions & Workstations', 'zh' => '办公隔断及工作站'],
                ]
            ],
            [
                'ar' => 'أثاث المطابخ والحمامات', 'en' => 'Kitchen & Bathroom Furniture', 'zh' => '厨房及卫浴家具',
                'cats' => [
                    ['ar' => 'خزائن ومطابخ جاهزة', 'en' => 'Ready-made Kitchen Cabinets', 'zh' => '成品橱柜'],
                    ['ar' => 'طاولات وجزيرات المطبخ', 'en' => 'Kitchen Islands & Tables', 'zh' => '厨房中岛及桌子'],
                    ['ar' => 'خزائن وأرفف الحمامات', 'en' => 'Bathroom Cabinets & Shelving', 'zh' => '浴室柜及搁板'],
                ]
            ],
            [
                'ar' => 'الأثاث الخارجي وأثاث الحدائق', 'en' => 'Outdoor & Garden Furniture', 'zh' => '户外及花园家具',
                'cats' => [
                    ['ar' => 'أطقم جلوس للحدائق', 'en' => 'Garden Seating Sets', 'zh' => '花园休闲套装'],
                    ['ar' => 'مراجيح وكراسي استرخاء', 'en' => 'Swings & Loungers', 'zh' => '秋千及躺椅'],
                    ['ar' => 'طاولات ومظلات خارجية', 'en' => 'Outdoor Tables & Umbrellas', 'zh' => '户外桌子及遮阳伞'],
                ]
            ],
            [
                'ar' => 'المفروشات والمنسوجات', 'en' => 'Furnishings & Textiles', 'zh' => '软装及纺织品',
                'cats' => [
                    ['ar' => 'السجاد والموكيت', 'en' => 'Carpets & Rugs', 'zh' => '地毯'],
                    ['ar' => 'الستائر والبلاندز', 'en' => 'Curtains & Blinds', 'zh' => '窗帘'],
                    ['ar' => 'المفارش وأطقم الأسرة', 'en' => 'Bedding & Linen Sets', 'zh' => '床品套装'],
                    ['ar' => 'الوسائد والأغطية واللحف', 'en' => 'Cushions, Throws & Quilts', 'zh' => '靠垫及被子'],
                ]
            ],
            [
                'ar' => 'الديكورات والإكسسوارات المنزلية', 'en' => 'Home Decor & Accessories', 'zh' => '家居装饰及配件',
                'cats' => [
                    ['ar' => 'المرايا واللوحات الفنية', 'en' => 'Mirrors & Wall Art', 'zh' => '镜子及墙面艺术'],
                    ['ar' => 'التحف والفازات والشمعدانات', 'en' => 'Antiques, Vases & Candelabras', 'zh' => '古董、花瓶及烛台'],
                    ['ar' => 'نوافير وشلالات منزلية', 'en' => 'Indoor Fountains & Waterfalls', 'zh' => '室内喷泉及瀑布'],
                    ['ar' => 'ورق الجدران والملصقات', 'en' => 'Wallpaper & Wall Decals', 'zh' => '壁纸及墙贴'],
                ]
            ],
            [
                'ar' => 'أنظمة التخزين والأرفف', 'en' => 'Storage Systems & Shelving', 'zh' => '存储系统及搁板',
                'cats' => [
                    ['ar' => 'أرفف معدنية وخشبية', 'en' => 'Metal & Wooden Shelves', 'zh' => '金属及木制架子'],
                    ['ar' => 'صناديق ومنظمات التخزين', 'en' => 'Storage Boxes & Organizers', 'zh' => '储能箱及整理器'],
                    ['ar' => 'علايق ومنظمات الأحذية', 'en' => 'Shoe Racks & Organizers', 'zh' => '鞋架'],
                ]
            ],
            [
                'ar' => 'أثاث الفنادق والمطاعم (HORECA)', 'en' => 'Hotel & Restaurant Furniture', 'zh' => '酒店及餐厅家具',
                'cats' => [
                    ['ar' => 'أثاث غرف الفنادق والأجنحة', 'en' => 'Hotel Room & Suite Furniture', 'zh' => '酒店客房家具'],
                    ['ar' => 'طاولات وكراسي المطاعم والكافيهات', 'en' => 'Restaurant & Cafe Seating', 'zh' => '餐厅及咖啡厅座椅'],
                    ['ar' => 'كاونترات استقبال وبارات', 'en' => 'Reception Counters & Bar Stools', 'zh' => '接待柜台及吧台凳'],
                ]
            ],
        ];

        foreach ($branches as $b) {
            $branch = Branch::create(['sector_id' => $sector->id, 'name_ar' => $b['ar'], 'name_en' => $b['en'], 'name_zh' => $b['zh']]);
            foreach ($b['cats'] as $c) {
                Category::create(['branch_id' => $branch->id, 'name_ar' => $c['ar'], 'name_en' => $c['en'], 'name_zh' => $c['zh']]);
            }
        }
    }
}
