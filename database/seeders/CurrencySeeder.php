<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            // الدولار الأمريكي
            ['code' => 'USD', 'name_ar' => 'دولار أمريكي',         'name_en' => 'US Dollar',             'symbol' => '$'],
            // اليورو
            ['code' => 'EUR', 'name_ar' => 'يورو',                  'name_en' => 'Euro',                   'symbol' => '€'],
            // الجنيه الإسترليني
            ['code' => 'GBP', 'name_ar' => 'جنيه إسترليني',        'name_en' => 'British Pound',         'symbol' => '£'],
            // الين الياباني
            ['code' => 'JPY', 'name_ar' => 'ين ياباني',            'name_en' => 'Japanese Yen',           'symbol' => '¥'],
            // اليوان الصيني
            ['code' => 'CNY', 'name_ar' => 'يوان صيني',            'name_en' => 'Chinese Yuan',           'symbol' => '¥'],
            // الريال السعودي
            ['code' => 'SAR', 'name_ar' => 'ريال سعودي',           'name_en' => 'Saudi Riyal',            'symbol' => 'ر.س'],
            // الدرهم الإماراتي
            ['code' => 'AED', 'name_ar' => 'درهم إماراتي',         'name_en' => 'UAE Dirham',             'symbol' => 'د.إ'],
            // الدينار الكويتي
            ['code' => 'KWD', 'name_ar' => 'دينار كويتي',          'name_en' => 'Kuwaiti Dinar',          'symbol' => 'د.ك'],
            // الريال القطري
            ['code' => 'QAR', 'name_ar' => 'ريال قطري',            'name_en' => 'Qatari Riyal',           'symbol' => 'ر.ق'],
            // الدينار البحريني
            ['code' => 'BHD', 'name_ar' => 'دينار بحريني',         'name_en' => 'Bahraini Dinar',         'symbol' => 'د.ب'],
            // الريال العُماني
            ['code' => 'OMR', 'name_ar' => 'ريال عُماني',          'name_en' => 'Omani Rial',             'symbol' => 'ر.ع'],
            // الدينار الأردني
            ['code' => 'JOD', 'name_ar' => 'دينار أردني',          'name_en' => 'Jordanian Dinar',        'symbol' => 'د.أ'],
            // الجنيه المصري
            ['code' => 'EGP', 'name_ar' => 'جنيه مصري',           'name_en' => 'Egyptian Pound',         'symbol' => 'ج.م'],
            // الليرة التركية
            ['code' => 'TRY', 'name_ar' => 'ليرة تركية',           'name_en' => 'Turkish Lira',           'symbol' => '₺'],
            // الروبية الهندية
            ['code' => 'INR', 'name_ar' => 'روبية هندية',          'name_en' => 'Indian Rupee',           'symbol' => '₹'],
            // الروبل الروسي
            ['code' => 'RUB', 'name_ar' => 'روبل روسي',            'name_en' => 'Russian Ruble',          'symbol' => '₽'],
            // الدولار الكندي
            ['code' => 'CAD', 'name_ar' => 'دولار كندي',           'name_en' => 'Canadian Dollar',        'symbol' => 'C$'],
            // الدولار الأسترالي
            ['code' => 'AUD', 'name_ar' => 'دولار أسترالي',        'name_en' => 'Australian Dollar',      'symbol' => 'A$'],
            // الفرنك السويسري
            ['code' => 'CHF', 'name_ar' => 'فرنك سويسري',          'name_en' => 'Swiss Franc',            'symbol' => 'CHF'],
            // الكرون السويدي
            ['code' => 'SEK', 'name_ar' => 'كرون سويدي',           'name_en' => 'Swedish Krona',          'symbol' => 'kr'],
            // الكرون النرويجي
            ['code' => 'NOK', 'name_ar' => 'كرون نرويجي',          'name_en' => 'Norwegian Krone',        'symbol' => 'kr'],
            // الكرون الدنماركي
            ['code' => 'DKK', 'name_ar' => 'كرون دنماركي',         'name_en' => 'Danish Krone',           'symbol' => 'kr'],
            // الوون الكوري الجنوبي
            ['code' => 'KRW', 'name_ar' => 'وون كوري',             'name_en' => 'South Korean Won',       'symbol' => '₩'],
            // الدولار الهونغ كونغي
            ['code' => 'HKD', 'name_ar' => 'دولار هونغ كونغي',    'name_en' => 'Hong Kong Dollar',       'symbol' => 'HK$'],
            // الدولار السنغافوري
            ['code' => 'SGD', 'name_ar' => 'دولار سنغافوري',       'name_en' => 'Singapore Dollar',       'symbol' => 'S$'],
            // الرينغيت الماليزي
            ['code' => 'MYR', 'name_ar' => 'رينغيت ماليزي',        'name_en' => 'Malaysian Ringgit',      'symbol' => 'RM'],
            // الروبية الإندونيسية
            ['code' => 'IDR', 'name_ar' => 'روبية إندونيسية',      'name_en' => 'Indonesian Rupiah',      'symbol' => 'Rp'],
            // البات التايلاندي
            ['code' => 'THB', 'name_ar' => 'بات تايلاندي',         'name_en' => 'Thai Baht',              'symbol' => '฿'],
            // الوون الفلبيني
            ['code' => 'PHP', 'name_ar' => 'بيزو فلبيني',          'name_en' => 'Philippine Peso',        'symbol' => '₱'],
            // برازيلي ريال
            ['code' => 'BRL', 'name_ar' => 'ريال برازيلي',         'name_en' => 'Brazilian Real',         'symbol' => 'R$'],
            // البيزو المكسيكي
            ['code' => 'MXN', 'name_ar' => 'بيزو مكسيكي',          'name_en' => 'Mexican Peso',           'symbol' => '$'],
            // البيزو الأرجنتيني
            ['code' => 'ARS', 'name_ar' => 'بيزو أرجنتيني',        'name_en' => 'Argentine Peso',         'symbol' => '$'],
            // البيزو الكولومبي
            ['code' => 'COP', 'name_ar' => 'بيزو كولومبي',         'name_en' => 'Colombian Peso',         'symbol' => '$'],
            // الدولار النيوزيلندي
            ['code' => 'NZD', 'name_ar' => 'دولار نيوزيلندي',      'name_en' => 'New Zealand Dollar',     'symbol' => 'NZ$'],
            // الزلوتي البولندي
            ['code' => 'PLN', 'name_ar' => 'زلوتي بولندي',         'name_en' => 'Polish Zloty',           'symbol' => 'zł'],
            // الكورونا التشيكية
            ['code' => 'CZK', 'name_ar' => 'كورونا تشيكية',        'name_en' => 'Czech Koruna',           'symbol' => 'Kč'],
            // الفورنت الهنغاري
            ['code' => 'HUF', 'name_ar' => 'فورنت هنغاري',         'name_en' => 'Hungarian Forint',       'symbol' => 'Ft'],
            // الليو الروماني
            ['code' => 'RON', 'name_ar' => 'ليو روماني',           'name_en' => 'Romanian Leu',           'symbol' => 'lei'],
            // الليف البلغاري
            ['code' => 'BGN', 'name_ar' => 'ليف بلغاري',           'name_en' => 'Bulgarian Lev',          'symbol' => 'лв'],
            // الكونا الكرواتية
            ['code' => 'HRK', 'name_ar' => 'كونا كرواتية',         'name_en' => 'Croatian Kuna',          'symbol' => 'kn'],
            // الشيكل الإسرائيلي
            ['code' => 'ILS', 'name_ar' => 'شيكل إسرائيلي',        'name_en' => 'Israeli New Shekel',     'symbol' => '₪'],
            // الدينار الليبي
            ['code' => 'LYD', 'name_ar' => 'دينار ليبي',           'name_en' => 'Libyan Dinar',           'symbol' => 'ل.د'],
            // الدينار التونسي
            ['code' => 'TND', 'name_ar' => 'دينار تونسي',          'name_en' => 'Tunisian Dinar',         'symbol' => 'د.ت'],
            // الدرهم المغربي
            ['code' => 'MAD', 'name_ar' => 'درهم مغربي',           'name_en' => 'Moroccan Dirham',        'symbol' => 'د.م'],
            // الدينار الجزائري
            ['code' => 'DZD', 'name_ar' => 'دينار جزائري',         'name_en' => 'Algerian Dinar',         'symbol' => 'د.ج'],
            // الجنيه السوداني
            ['code' => 'SDG', 'name_ar' => 'جنيه سوداني',          'name_en' => 'Sudanese Pound',         'symbol' => 'ج.س'],
            // البر الإثيوبي
            ['code' => 'ETB', 'name_ar' => 'بِر إثيوبي',           'name_en' => 'Ethiopian Birr',         'symbol' => 'Br'],
            // الناييرا النيجيرية
            ['code' => 'NGN', 'name_ar' => 'نايرا نيجيرية',        'name_en' => 'Nigerian Naira',         'symbol' => '₦'],
            // الراند الجنوب أفريقي
            ['code' => 'ZAR', 'name_ar' => 'راند جنوب أفريقي',     'name_en' => 'South African Rand',     'symbol' => 'R'],
            // الشلن الكيني
            ['code' => 'KES', 'name_ar' => 'شلن كيني',             'name_en' => 'Kenyan Shilling',        'symbol' => 'KSh'],
            // الغانا سيدي
            ['code' => 'GHS', 'name_ar' => 'سيدي غاني',            'name_en' => 'Ghanaian Cedi',          'symbol' => '₵'],
            // التنزاني شلن
            ['code' => 'TZS', 'name_ar' => 'شلن تنزاني',           'name_en' => 'Tanzanian Shilling',     'symbol' => 'TSh'],
            // الكوردوبا النيكاراغوي
            ['code' => 'NIO', 'name_ar' => 'كوردوبا نيكاراغوي',    'name_en' => 'Nicaraguan Córdoba',     'symbol' => 'C$'],
            // الكولون الكوستاريكي
            ['code' => 'CRC', 'name_ar' => 'كولون كوستاريكي',      'name_en' => 'Costa Rican Colón',      'symbol' => '₡'],
            // الكيتزال الغواتيمالي
            ['code' => 'GTQ', 'name_ar' => 'كيتزال غواتيمالي',     'name_en' => 'Guatemalan Quetzal',     'symbol' => 'Q'],
            // الدولار الأمريكي للجزر الأمريكية
            ['code' => 'PAB', 'name_ar' => 'بالبوا بنامي',          'name_en' => 'Panamanian Balboa',      'symbol' => 'B/.'],
            // الغريفنيا الأوكرانية
            ['code' => 'UAH', 'name_ar' => 'غريفنيا أوكرانية',     'name_en' => 'Ukrainian Hryvnia',      'symbol' => '₴'],
            // التيفغير التشيلي
            ['code' => 'CLP', 'name_ar' => 'بيزو تشيلي',           'name_en' => 'Chilean Peso',           'symbol' => '$'],
            // الورانجي البيروفي
            ['code' => 'PEN', 'name_ar' => 'سول بيروفي',           'name_en' => 'Peruvian Sol',           'symbol' => 'S/'],
            // البوليفيانو البوليفي
            ['code' => 'BOB', 'name_ar' => 'بوليفيانو بوليفي',     'name_en' => 'Bolivian Boliviano',     'symbol' => 'Bs.'],
            // الغوراني الباراغوياني
            ['code' => 'PYG', 'name_ar' => 'غواراني باراغوياني',   'name_en' => 'Paraguayan Guaraní',     'symbol' => '₲'],
            // البيزو الأوروغوياني
            ['code' => 'UYU', 'name_ar' => 'بيزو أوروغواني',       'name_en' => 'Uruguayan Peso',         'symbol' => '$U'],
            // الدولار الفنزويلي
            ['code' => 'VES', 'name_ar' => 'بوليفار فنزويلي',      'name_en' => 'Venezuelan Bolívar',     'symbol' => 'Bs.S'],
            // الروبية الباكستانية
            ['code' => 'PKR', 'name_ar' => 'روبية باكستانية',      'name_en' => 'Pakistani Rupee',        'symbol' => '₨'],
            // الروبية البنغلاديشية
            ['code' => 'BDT', 'name_ar' => 'تاكا بنغلاديشي',       'name_en' => 'Bangladeshi Taka',       'symbol' => '৳'],
            // الروبية السريلانكية
            ['code' => 'LKR', 'name_ar' => 'روبية سريلانكية',      'name_en' => 'Sri Lankan Rupee',       'symbol' => 'Rs'],
            // التوغروغ المنغولي
            ['code' => 'MNT', 'name_ar' => 'توغروغ منغولي',        'name_en' => 'Mongolian Tögrög',       'symbol' => '₮'],
            // الكيب الكمبودي
            ['code' => 'KHR', 'name_ar' => 'رييل كمبودي',          'name_en' => 'Cambodian Riel',         'symbol' => '៛'],
            // الكيب لاوسي
            ['code' => 'LAK', 'name_ar' => 'كيب لاوسي',            'name_en' => 'Lao Kip',                'symbol' => '₭'],
            // الدونغ الفيتنامي
            ['code' => 'VND', 'name_ar' => 'دونغ فيتنامي',         'name_en' => 'Vietnamese Dong',        'symbol' => '₫'],
            // الممة المياني
            ['code' => 'MMK', 'name_ar' => 'كيات ميانماري',        'name_en' => 'Myanmar Kyat',           'symbol' => 'K'],
            // الدولار الفيجي
            ['code' => 'FJD', 'name_ar' => 'دولار فيجي',           'name_en' => 'Fijian Dollar',          'symbol' => 'FJ$'],
            // دولار بابوا غينيا الجديدة
            ['code' => 'PGK', 'name_ar' => 'كينا بابوا غيني',      'name_en' => 'Papua New Guinea Kina',  'symbol' => 'K'],
            // الدينار العراقي
            ['code' => 'IQD', 'name_ar' => 'دينار عراقي',          'name_en' => 'Iraqi Dinar',            'symbol' => 'ع.د'],
            // الريال الإيراني
            ['code' => 'IRR', 'name_ar' => 'ريال إيراني',          'name_en' => 'Iranian Rial',           'symbol' => '﷼'],
            // الليرة السورية
            ['code' => 'SYP', 'name_ar' => 'ليرة سورية',           'name_en' => 'Syrian Pound',           'symbol' => 'ل.س'],
            // الليرة اللبنانية
            ['code' => 'LBP', 'name_ar' => 'ليرة لبنانية',         'name_en' => 'Lebanese Pound',         'symbol' => 'ل.ل'],
            // الشلن الصومالي
            ['code' => 'SOS', 'name_ar' => 'شلن صومالي',           'name_en' => 'Somali Shilling',        'symbol' => 'Sh.So'],
            // الفرنك المالاغاشي
            ['code' => 'MGA', 'name_ar' => 'أرياري مدغشقري',       'name_en' => 'Malagasy Ariary',        'symbol' => 'Ar'],
            // الدولار الجيبوتي
            ['code' => 'DJF', 'name_ar' => 'فرنك جيبوتي',          'name_en' => 'Djiboutian Franc',       'symbol' => 'Fdj'],
            // الشلن الأوغندي
            ['code' => 'UGX', 'name_ar' => 'شلن أوغندي',           'name_en' => 'Ugandan Shilling',       'symbol' => 'USh'],
            // الشلن الرواندي
            ['code' => 'RWF', 'name_ar' => 'فرنك رواندي',          'name_en' => 'Rwandan Franc',          'symbol' => 'Fr'],
            // الينغي الموزمبيقي
            ['code' => 'MZN', 'name_ar' => 'متيكال موزمبيقي',      'name_en' => 'Mozambican Metical',     'symbol' => 'MT'],
            // الزامبي كواتشا
            ['code' => 'ZMW', 'name_ar' => 'كواتشا زامبي',         'name_en' => 'Zambian Kwacha',         'symbol' => 'ZK'],
            // الزيمبابوي دولار
            ['code' => 'ZWL', 'name_ar' => 'دولار زيمبابوي',       'name_en' => 'Zimbabwean Dollar',      'symbol' => 'Z$'],
            // البيتكوين (عملة رقمية شائعة)
            ['code' => 'BTC', 'name_ar' => 'بيتكوين',              'name_en' => 'Bitcoin',                'symbol' => '₿'],
        ];

        foreach ($currencies as $data) {
            Currency::updateOrCreate(
                ['code' => $data['code']],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}
