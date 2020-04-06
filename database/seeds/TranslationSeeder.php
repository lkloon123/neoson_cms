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
        $languages = \App\Model\Language::all();

        foreach ($languages as $language) {
            \App\Model\Translation::forceCreate([
                'group' => 'validation',
                'key' => 'required',
                'language_id' => $language->id
            ]);

            \App\Model\Translation::forceCreate([
                'group' => 'validation',
                'key' => 'url',
                'language_id' => $language->id
            ]);

            \App\Model\Translation::forceCreate([
                'group' => 'menu',
                'key' => 'dashboard',
                'language_id' => $language->id
            ]);
        }
    }
}
