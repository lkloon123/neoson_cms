<?php

use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ENTranslationSeeder::class);
        $this->call(ZHCNTranslationSeeder::class);
    }
}
