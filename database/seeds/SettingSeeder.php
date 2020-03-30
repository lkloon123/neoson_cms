<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Setting::create([
            'setting_key' => 'site_title',
            'setting_value' => config('app.name'),
            'config_key' => 'app.name',
            'type' => 'string',
            'group' => 'general',
            'meta' => [
                'type' => 'text',
                'label' => 'Site Title',
                'validators' => ['required' => false],
            ],
        ]);

        \App\Model\Setting::create([
            'setting_key' => 'site_description',
            'setting_value' => config('app.description'),
            'config_key' => 'app.description',
            'type' => 'string',
            'group' => 'general',
            'meta' => [
                'type' => 'text',
                'label' => 'Site Description',
                'validators' => ['required' => false],
            ],
        ]);

        \App\Model\Setting::create([
            'setting_key' => 'site_copyright',
            'setting_value' => 'Copyright © NeoSon (Theme designed by Blackrock Digital)',
            'config_key' => null,
            'type' => 'string',
            'group' => 'general',
            'meta' => [
                'type' => 'text',
                'label' => 'Copyright Text',
                'validators' => ['required' => false],
            ],
        ]);

        \App\Model\Setting::create([
            'setting_key' => 'admin_email',
            'setting_value' => '',
            'config_key' => null,
            'type' => 'string',
            'group' => 'general',
            'meta' => [
                'type' => 'text',
                'label' => 'Admin Email',
                'description' => 'This email address for admin usage only',
                'validators' => ['required' => false],
            ],
        ]);
    }
}
