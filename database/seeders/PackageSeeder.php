<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate existing packages to avoid duplicates
        Package::truncate();

        $levels = [
            [
                'slug' => 'bronze',
                'ar' => 'برونزية',
                'en' => 'Bronze',
                'zh' => '青铜级',
                'desc_ar' => 'الميزات الأساسية للمستخدمين المبتدئين مع إمكانات وصول محدودة.',
                'desc_en' => 'Basic features for beginners with limited access capabilities.',
                'desc_zh' => '适合初学者的基本功能，访问权限有限。'
            ],
            [
                'slug' => 'silver',
                'ar' => 'فضية',
                'en' => 'Silver',
                'zh' => '白银级',
                'desc_ar' => 'تحسين الميزات مع دعم فني أسرع وإحصائيات بسيطة.',
                'desc_en' => 'Enhanced features with faster technical support and basic statistics.',
                'desc_zh' => '增强功能，提供更快的技术支持和基本统计。'
            ],
            [
                'slug' => 'gold',
                'ar' => 'ذهبية',
                'en' => 'Gold',
                'zh' => '黄金级',
                'desc_ar' => 'ميزات متقدمة ووصول ذو أولوية لجميع الخدمات المتاحة.',
                'desc_en' => 'Advanced features and priority access to all available services.',
                'desc_zh' => '高级功能和优先访问所有可用服务。'
            ],
            [
                'slug' => 'platinum',
                'ar' => 'بلاتينية',
                'en' => 'Platinum',
                'zh' => '铂金级',
                'desc_ar' => 'أدوات أعمال متميزة، حسابات مخصصة، وتقارير تحليلية عميقة.',
                'desc_en' => 'Premium business tools, dedicated accounts, and deep analytical reports.',
                'desc_zh' => '优质商务工具、专用账户和深度分析报告。'
            ],
            [
                'slug' => 'diamond',
                'ar' => 'ماسية',
                'en' => 'Diamond',
                'zh' => '钻石级',
                'desc_ar' => 'وصول كامل وحصري مع مزايا تسويقية عالمية ودعم VIP.',
                'desc_en' => 'Full and exclusive access with global marketing benefits and VIP support.',
                'desc_zh' => '全权独家访问，享有全球营销权益和VIP支持。'
            ],
            [
                'slug' => 'green_diamond',
                'ar' => 'ماسية خضراء',
                'en' => 'Green Diamond',
                'zh' => '绿钻级',
                'desc_ar' => 'حلول مؤسسية احترافية بحدود قصوى ومميزات استثنائية.',
                'desc_en' => 'Professional enterprise solutions with maximum limits and exceptional features.',
                'desc_zh' => '具有极限限制和卓越功能的专业企业解决方案。'
            ],
        ];

        $types = [
            'client' => ['ar' => '', 'en' => ' (Client)', 'zh' => ' (客户)'],
            'factory' => ['ar' => ' للمصانع', 'en' => ' (Factory)', 'zh' => ' (工厂)'],
            'company' => ['ar' => ' للشركات', 'en' => ' (Company)', 'zh' => ' (公司)'],
        ];

        $imageMap = [
            'client' => [
                'packages/client_bronze.png',
                'packages/client_silver.png',
                'packages/client_gold.png',
                'packages/client_platinum.png',
                'packages/client_diamond.png',
                'packages/client_green_diamond.png',
            ],
            'factory' => [
                'packages/factory_bronze.jpg',
                'packages/factory_silver.jpg',
                'packages/factory_gold.jpg',
                null, // Platinum skipped
                'packages/factory_diamond.jpg',
                'packages/factory_green_diamond.jpg',
            ],
            'company' => [
                'packages/company_bronze.png',
                'packages/company_silver.png',
                'packages/company_gold.png',
                null, // Platinum skipped
                'packages/company_diamond.png',
                'packages/company_green_diamond.png',
            ]
        ];

        foreach ($types as $typeKey => $typeLabels) {
            foreach ($levels as $index => $level) {
                // Skip Platinum for factories and companies
                if (($typeKey === 'factory' || $typeKey === 'company') && $level['slug'] === 'platinum') {
                    continue;
                }

                Package::create([
                    'type' => $typeKey,
                    'title_ar' => $level['ar'] . $typeLabels['ar'],
                    'title_en' => $level['en'] . $typeLabels['en'],
                    'title_zh' => $level['zh'] . $typeLabels['zh'],
                    'description_ar' => $level['desc_ar'],
                    'description_en' => $level['desc_en'],
                    'description_zh' => $level['desc_zh'],
                    'image' => $imageMap[$typeKey][$index] ?? null,
                ]);
            }
        }
    }
}
