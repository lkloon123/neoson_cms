<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = \App\Model\User::create([
            'name' => 'NeoSon',
            'email' => 'lkloon123@hotmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('demo1234')
        ]);

        $superadmin->attachRole('superadmin');
    }
}
