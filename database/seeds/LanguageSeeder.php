<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Language::forceCreate([
            'code' => 'en',
            'title' => 'English',
            'country_iso' => 'us',
        ]);

        \App\Model\Language::forceCreate([
            'code' => 'zh-CN',
            'title' => '简体中文',
            'country_iso' => 'cn',
        ]);
    }
}
