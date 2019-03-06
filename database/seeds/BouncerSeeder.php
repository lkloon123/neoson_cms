<?php

use App\User;
use Illuminate\Database\Seeder;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('superadmin')->everything();

        Bouncer::allow('admin')->everything();
        Bouncer::forbid('admin')->toManage(\App\User::class);

        Bouncer::forbid('banned')->everything();

        Bouncer::allow('editor')->toOwn(User::class)->to(['view', 'update']);
    }
}
