<?php

use App\Model\Page;
use App\Model\User;
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
        //setup roles and permission
        Bouncer::allow('superadmin')->everything();
        $superAdmins = User::whereIs('superadmin')->get();

        Bouncer::allow('admin')->everything();
        Bouncer::forbid('admin')->toManage(User::class);
        $admins = User::whereIs('admin')->get();

        Bouncer::forbid('banned')->everything();

        Bouncer::allow('editor')->toOwn(User::class)->to(['view', 'update']);
        Bouncer::allow('editor')->toOwn(Page::class)->to(['view', 'update', 'delete']);
        Bouncer::allow('editor')->to(['viewall', 'create'], Page::class);
        Bouncer::allow('editor')->to('login_admin');
    }
}
