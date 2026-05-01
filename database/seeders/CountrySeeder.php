<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            // --- Arab Countries (22) ---
            ['name_ar' => 'مصر', 'name_en' => 'Egypt', 'name_zh' => '埃及', 'flag_code' => 'eg'],
            ['name_ar' => 'السعودية', 'name_en' => 'Saudi Arabia', 'name_zh' => '沙特阿拉伯', 'flag_code' => 'sa'],
            ['name_ar' => 'الإمارات العربية المتحدة', 'name_en' => 'United Arab Emirates', 'name_zh' => '阿拉伯联合酋长国', 'flag_code' => 'ae'],
            ['name_ar' => 'الكويت', 'name_en' => 'Kuwait', 'name_zh' => '科威特', 'flag_code' => 'kw'],
            ['name_ar' => 'قطر', 'name_en' => 'Qatar', 'name_zh' => '卡塔尔', 'flag_code' => 'qa'],
            ['name_ar' => 'عمان', 'name_en' => 'Oman', 'name_zh' => '阿曼', 'flag_code' => 'om'],
            ['name_ar' => 'البحرين', 'name_en' => 'Bahrain', 'name_zh' => '巴林', 'flag_code' => 'bh'],
            ['name_ar' => 'الأردن', 'name_en' => 'Jordan', 'name_zh' => '约旦', 'flag_code' => 'jo'],
            ['name_ar' => 'لبنان', 'name_en' => 'Lebanon', 'name_zh' => '黎巴嫩', 'flag_code' => 'lb'],
            ['name_ar' => 'فلسطين', 'name_en' => 'Palestine', 'name_zh' => '巴勒斯坦', 'flag_code' => 'ps'],
            ['name_ar' => 'العراق', 'name_en' => 'Iraq', 'name_zh' => '伊拉克', 'flag_code' => 'iq'],
            ['name_ar' => 'سوريا', 'name_en' => 'Syria', 'name_zh' => '叙利亚', 'flag_code' => 'sy'],
            ['name_ar' => 'اليمن', 'name_en' => 'Yemen', 'name_zh' => '也门', 'flag_code' => 'ye'],
            ['name_ar' => 'ليبيا', 'name_en' => 'Libya', 'name_zh' => '利比亚', 'flag_code' => 'ly'],
            ['name_ar' => 'تونس', 'name_en' => 'Tunisia', 'name_zh' => '突尼斯', 'flag_code' => 'tn'],
            ['name_ar' => 'الجزائر', 'name_en' => 'Algeria', 'name_zh' => '阿尔及利亚', 'flag_code' => 'dz'],
            ['name_ar' => 'المغرب', 'name_en' => 'Morocco', 'name_zh' => '摩洛哥', 'flag_code' => 'ma'],
            ['name_ar' => 'موريتانيا', 'name_en' => 'Mauritania', 'name_zh' => '毛里塔尼亚', 'flag_code' => 'mr'],
            ['name_ar' => 'السودان', 'name_en' => 'Sudan', 'name_zh' => '苏丹', 'flag_code' => 'sd'],
            ['name_ar' => 'جيبوتي', 'name_en' => 'Djibouti', 'name_zh' => '吉布提', 'flag_code' => 'dj'],
            ['name_ar' => 'الصومال', 'name_en' => 'Somalia', 'name_zh' => '索马里', 'flag_code' => 'so'],
            ['name_ar' => 'جزر القمر', 'name_en' => 'Comoros', 'name_zh' => '科摩罗', 'flag_code' => 'km'],

            // --- Additional African Countries ---
            ['name_ar' => 'نيجيريا', 'name_en' => 'Nigeria', 'name_zh' => '尼日利亚', 'flag_code' => 'ng'],
            ['name_ar' => 'إثيوبيا', 'name_en' => 'Ethiopia', 'name_zh' => '埃塞俄比亚', 'flag_code' => 'et'],
            ['name_ar' => 'جنوب أفريقيا', 'name_en' => 'South Africa', 'name_zh' => '南非', 'flag_code' => 'za'],
            ['name_ar' => 'كينيا', 'name_en' => 'Kenya', 'name_zh' => '肯尼亚', 'flag_code' => 'ke'],
            ['name_ar' => 'تنزانيا', 'name_en' => 'Tanzania', 'name_zh' => '坦桑尼亚', 'flag_code' => 'tz'],
            ['name_ar' => 'غانا', 'name_en' => 'Ghana', 'name_zh' => '加纳', 'flag_code' => 'gh'],
            ['name_ar' => 'أوغندا', 'name_en' => 'Uganda', 'name_zh' => '乌干达', 'flag_code' => 'ug'],
            ['name_ar' => 'السنغال', 'name_en' => 'Senegal', 'name_zh' => '塞内加尔', 'flag_code' => 'sn'],
            ['name_ar' => 'الكورديفوار', 'name_en' => 'Ivory Coast', 'name_zh' => '科特迪瓦', 'flag_code' => 'ci'],
            ['name_ar' => 'الكاميرون', 'name_en' => 'Cameroon', 'name_zh' => '喀麦隆', 'flag_code' => 'cm'],
            ['name_ar' => 'أنغولا', 'name_en' => 'Angola', 'name_zh' => '安哥拉', 'flag_code' => 'ao'],
            ['name_ar' => 'مالي', 'name_en' => 'Mali', 'name_zh' => '马里', 'flag_code' => 'ml'],
            ['name_ar' => 'زمبابوي', 'name_en' => 'Zimbabwe', 'name_zh' => '津巴布韦', 'flag_code' => 'zw'],
            ['name_ar' => 'زامبيا', 'name_en' => 'Zambia', 'name_zh' => '赞比亚', 'flag_code' => 'zm'],
            ['name_ar' => 'بوتسوانا', 'name_en' => 'Botswana', 'name_zh' => '博茨瓦纳', 'flag_code' => 'bw'],
            ['name_ar' => 'رواندا', 'name_en' => 'Rwanda', 'name_zh' => '卢旺达', 'flag_code' => 'rw'],
            ['name_ar' => 'بوركينا فاسو', 'name_en' => 'Burkina Faso', 'name_zh' => '布基纳法索', 'flag_code' => 'bf'],
            ['name_ar' => 'بنين', 'name_en' => 'Benin', 'name_zh' => '贝宁', 'flag_code' => 'bj'],
            ['name_ar' => 'توجو', 'name_en' => 'Togo', 'name_zh' => '多哥', 'flag_code' => 'tg'],
            ['name_ar' => 'غينيا', 'name_en' => 'Guinea', 'name_zh' => '几内亚', 'flag_code' => 'gn'],
            ['name_ar' => 'غينيا بيساو', 'name_en' => 'Guinea-Bissau', 'name_zh' => '几内亚比绍', 'flag_code' => 'gw'],
            ['name_ar' => 'ليبيريا', 'name_en' => 'Liberia', 'name_zh' => '利比里亚', 'flag_code' => 'lr'],
            ['name_ar' => 'سيراليون', 'name_en' => 'Sierra Leone', 'name_zh' => '塞拉利昂', 'flag_code' => 'sl'],
            ['name_ar' => 'الغابون', 'name_en' => 'Gabon', 'name_zh' => '加蓬', 'flag_code' => 'ga'],
            ['name_ar' => 'ناميبيا', 'name_en' => 'Namibia', 'name_zh' => '纳米比亚', 'flag_code' => 'na'],
            ['name_ar' => 'موريشيوس', 'name_en' => 'Mauritius', 'name_zh' => '毛里求斯', 'flag_code' => 'mu'],
            ['name_ar' => 'سيشل', 'name_en' => 'Seychelles', 'name_zh' => '塞舌尔', 'flag_code' => 'sc'],
            ['name_ar' => 'غامبيا', 'name_en' => 'Gambia', 'name_zh' => '冈比亚', 'flag_code' => 'gm'],
            ['name_ar' => 'مدغشقر', 'name_en' => 'Madagascar', 'name_zh' => '马达加斯加', 'flag_code' => 'mg'],
            ['name_ar' => 'ملاوي', 'name_en' => 'Malawi', 'name_zh' => '马拉维', 'flag_code' => 'mw'],
            ['name_ar' => 'موزمبيق', 'name_en' => 'Mozambique', 'name_zh' => '莫桑比克', 'flag_code' => 'mz'],
            ['name_ar' => 'ليصوتو', 'name_en' => 'Lesotho', 'name_zh' => '莱索托', 'flag_code' => 'ls'],

            // --- Asia ---
            ['name_ar' => 'الصين', 'name_en' => 'China', 'name_zh' => '中国', 'flag_code' => 'cn'],
            ['name_ar' => 'اليابان', 'name_en' => 'Japan', 'name_zh' => '日本', 'flag_code' => 'jp'],
            ['name_ar' => 'الهند', 'name_en' => 'India', 'name_zh' => '印度', 'flag_code' => 'in'],
            ['name_ar' => 'روسيا', 'name_en' => 'Russia', 'name_zh' => '俄罗斯', 'flag_code' => 'ru'],
            ['name_ar' => 'كوريا الجنوبية', 'name_en' => 'South Korea', 'name_zh' => '韩国', 'flag_code' => 'kr'],
            ['name_ar' => 'كوريا الشمالية', 'name_en' => 'North Korea', 'name_zh' => '朝鲜', 'flag_code' => 'kp'],
            ['name_ar' => 'إندونيسيا', 'name_en' => 'Indonesia', 'name_zh' => '印度尼西亚', 'flag_code' => 'id'],
            ['name_ar' => 'ماليزيا', 'name_en' => 'Malaysia', 'name_zh' => '马来西亚', 'flag_code' => 'my'],
            ['name_ar' => 'باكستان', 'name_en' => 'Pakistan', 'name_zh' => '巴基斯坦', 'flag_code' => 'pk'],
            ['name_ar' => 'بنغلاديش', 'name_en' => 'Bangladesh', 'name_zh' => '孟加拉国', 'flag_code' => 'bd'],
            ['name_ar' => 'فيتنام', 'name_en' => 'Vietnam', 'name_zh' => '越南', 'flag_code' => 'vn'],
            ['name_ar' => 'تايلاند', 'name_en' => 'Thailand', 'name_zh' => '泰国', 'flag_code' => 'th'],
            ['name_ar' => 'الفلبين', 'name_en' => 'Philippines', 'name_zh' => '菲律宾', 'flag_code' => 'ph'],
            ['name_ar' => 'إيران', 'name_en' => 'Iran', 'name_zh' => '伊朗', 'flag_code' => 'ir'],
            ['name_ar' => 'تركيا', 'name_en' => 'Turkey', 'name_zh' => '土耳其', 'flag_code' => 'tr'],
            ['name_ar' => 'سريلانكا', 'name_en' => 'Sri Lanka', 'name_zh' => '斯里兰卡', 'flag_code' => 'lk'],
            ['name_ar' => 'أفغانستان', 'name_en' => 'Afghanistan', 'name_zh' => '阿富汗', 'flag_code' => 'af'],
            ['name_ar' => 'كازاخستان', 'name_en' => 'Kazakhstan', 'name_zh' => '哈萨克斯坦', 'flag_code' => 'kz'],
            ['name_ar' => 'أوزبكستان', 'name_en' => 'Uzbekistan', 'name_zh' => '乌兹别克斯坦', 'flag_code' => 'uz'],
            ['name_ar' => 'المالديف', 'name_en' => 'Maldives', 'name_zh' => '马尔代夫', 'flag_code' => 'mv'],
            ['name_ar' => 'نيبال', 'name_en' => 'Nepal', 'name_zh' => '尼泊尔', 'flag_code' => 'np'],
            ['name_ar' => 'سنغافورة', 'name_en' => 'Singapore', 'name_zh' => '新加坡', 'flag_code' => 'sg'],

            // --- Europe ---
            ['name_ar' => 'المملكة المتحدة', 'name_en' => 'United Kingdom', 'name_zh' => '英国', 'flag_code' => 'gb'],
            ['name_ar' => 'ألمانيا', 'name_en' => 'Germany', 'name_zh' => '德国', 'flag_code' => 'de'],
            ['name_ar' => 'فرنسا', 'name_en' => 'France', 'name_zh' => '法国', 'flag_code' => 'fr'],
            ['name_ar' => 'إيطاليا', 'name_en' => 'Italy', 'name_zh' => '意大利', 'flag_code' => 'it'],
            ['name_ar' => 'إسبانيا', 'name_en' => 'Spain', 'name_zh' => '西班牙', 'flag_code' => 'es'],
            ['name_ar' => 'هولندا', 'name_en' => 'Netherlands', 'name_zh' => '荷兰', 'flag_code' => 'nl'],
            ['name_ar' => 'بلجيكا', 'name_en' => 'Belgium', 'name_zh' => '比利时', 'flag_code' => 'be'],
            ['name_ar' => 'سويسرا', 'name_en' => 'Switzerland', 'name_zh' => '瑞士', 'flag_code' => 'ch'],
            ['name_ar' => 'النمسا', 'name_en' => 'Austria', 'name_zh' => '奥地利', 'flag_code' => 'at'],
            ['name_ar' => 'السويد', 'name_en' => 'Sweden', 'name_zh' => '瑞典', 'flag_code' => 'se'],
            ['name_ar' => 'النرويج', 'name_en' => 'Norway', 'name_zh' => '挪威', 'flag_code' => 'no'],
            ['name_ar' => 'الدنمارك', 'name_en' => 'Denmark', 'name_zh' => '丹麦', 'flag_code' => 'dk'],
            ['name_ar' => 'فنلندا', 'name_en' => 'Finland', 'name_zh' => '芬兰', 'flag_code' => 'fi'],
            ['name_ar' => 'بولندا', 'name_en' => 'Poland', 'name_zh' => '波兰', 'flag_code' => 'pl'],
            ['name_ar' => 'البرتغال', 'name_en' => 'Portugal', 'name_zh' => '葡萄牙', 'flag_code' => 'pt'],
            ['name_ar' => 'اليونان', 'name_en' => 'Greece', 'name_zh' => '希腊', 'flag_code' => 'gr'],
            ['name_ar' => 'إيرلندا', 'name_en' => 'Ireland', 'name_zh' => '爱尔兰', 'flag_code' => 'ie'],
            ['name_ar' => 'رومانيا', 'name_en' => 'Romania', 'name_zh' => '罗马尼亚', 'flag_code' => 'ro'],
            ['name_ar' => 'المجر', 'name_en' => 'Hungary', 'name_zh' => '匈牙利', 'flag_code' => 'hu'],
            ['name_ar' => 'أوكرانيا', 'name_en' => 'Ukraine', 'name_zh' => '乌克兰', 'flag_code' => 'ua'],

            // --- Americas ---
            ['name_ar' => 'الولايات المتحدة', 'name_en' => 'United States', 'name_zh' => '美国', 'flag_code' => 'us'],
            ['name_ar' => 'كندا', 'name_en' => 'Canada', 'name_zh' => '加拿大', 'flag_code' => 'ca'],
            ['name_ar' => 'البرازيل', 'name_en' => 'Brazil', 'name_zh' => '巴西', 'flag_code' => 'br'],
            ['name_ar' => 'المكسيك', 'name_en' => 'Mexico', 'name_zh' => '墨西哥', 'flag_code' => 'mx'],
            ['name_ar' => 'الأرجنتين', 'name_en' => 'Argentina', 'name_zh' => '阿根廷', 'flag_code' => 'ar'],
            ['name_ar' => 'كولومبيا', 'name_en' => 'Colombia', 'name_zh' => '哥伦比亚', 'flag_code' => 'co'],
            ['name_ar' => 'تشيلي', 'name_en' => 'Chile', 'name_zh' => '智利', 'flag_code' => 'cl'],
            ['name_ar' => 'بيرو', 'name_en' => 'Peru', 'name_zh' => '秘鲁', 'flag_code' => 'pe'],
            ['name_ar' => 'فنزويلا', 'name_en' => 'Venezuela', 'name_zh' => '委内瑞拉', 'flag_code' => 've'],
            ['name_ar' => 'كوبا', 'name_en' => 'Cuba', 'name_zh' => '古巴', 'flag_code' => 'cu'],

            // --- Oceania ---
            ['name_ar' => 'أستراليا', 'name_en' => 'Australia', 'name_zh' => '澳大利亚', 'flag_code' => 'au'],
            ['name_ar' => 'نيوزيلندا', 'name_en' => 'New Zealand', 'name_zh' => '新西兰', 'flag_code' => 'nz'],
            ['name_ar' => 'فيجي', 'name_en' => 'Fiji', 'name_zh' => '斐济', 'flag_code' => 'fj'],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(['flag_code' => $country['flag_code']], $country);
        }
    }
}
