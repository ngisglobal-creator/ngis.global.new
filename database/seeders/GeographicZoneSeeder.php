<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\GeographicZone;
use Illuminate\Database\Seeder;

class GeographicZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            [
                'name_ar'  => 'ليبيا (بنغازي)',
                'name_en'  => 'Libya (Benghazi)',
                'name_zh'  => '利比亚（班加西）',
                'image'    => 'vendor/flag-icons/flags/4x3/ly.svg',
                'countries'=> ['ly', 'dz', 'ae', 'jo', 'lb', 'ps', 'sy', 'ye', 'mr', 'so', 'dj', 'km', 'bh'],
            ],
            [
                'name_ar'  => 'السعودية (الرياض)',
                'name_en'  => 'Saudi Arabia (Riyadh)',
                'name_zh'  => '沙特阿拉伯（利雅得）',
                'image'    => 'vendor/flag-icons/flags/4x3/sa.svg',
                'countries'=> ['sa', 'kw', 'qa', 'om', 'iq'],
            ],
            [
                'name_ar'  => 'مصر (القاهرة)',
                'name_en'  => 'Egypt (Cairo)',
                'name_zh'  => '埃及（开罗）',
                'image'    => 'vendor/flag-icons/flags/4x3/eg.svg',
                'countries'=> ['eg', 'sd', 'ma', 'tn'],
            ],
            [
                'name_ar'  => 'نيجيريا (أبوجا)',
                'name_en'  => 'Nigeria (Abuja)',
                'name_zh'  => '尼日利亚（阿布贾）',
                'image'    => 'vendor/flag-icons/flags/4x3/ng.svg',
                'countries'=> ['ng', 'gh', 'ci', 'bj'],
            ],
            [
                'name_ar'  => 'جنوب أفريقيا (جوهانسبرغ)',
                'name_en'  => 'South Africa (Johannesburg)',
                'name_zh'  => '南非（约翰内斯堡）',
                'image'    => 'vendor/flag-icons/flags/4x3/za.svg',
                'countries'=> ['za', 'na', 'bw', 'zw'],
            ],
            [
                'name_ar'  => 'كينيا (نيروبي)',
                'name_en'  => 'Kenya (Nairobi)',
                'name_zh'  => '肯尼亚（内罗毕）',
                'image'    => 'vendor/flag-icons/flags/4x3/ke.svg',
                'countries'=> ['ke', 'et', 'tz', 'ug', 'ss', 'td'],
            ],
        ];

        foreach ($zones as $zoneData) {
            $countryCodes = $zoneData['countries'];
            unset($zoneData['countries']);

            $zone = GeographicZone::updateOrCreate(
                ['name_en' => $zoneData['name_en']],
                $zoneData
            );

            $countryIds = Country::whereIn('flag_code', $countryCodes)->pluck('id')->toArray();
            $zone->countries()->sync($countryIds);
        }
    }
}
