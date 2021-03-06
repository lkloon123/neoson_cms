<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FormComponentSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(TranslationSeeder::class);
    }
}
