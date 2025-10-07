<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем запись настроек, если её нет
        if (Setting::count() === 0) {
            Setting::create([
                'site_name' => 'Ameliq Landing',
                'site_title' => 'Ameliq Landing - Создание эффективных лендингов',
                'site_description' => 'Профессиональная разработка лендинг страниц с высокой конверсией',
                'site_keywords' => 'лендинг, landing page, разработка сайтов, веб-дизайн',
            ]);
        }
    }
}
