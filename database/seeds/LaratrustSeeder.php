<?php

use App\Model\Role;
use Illuminate\Database\Seeder;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $sa = new Role();
        $sa->name = 'superadmin';
        $sa->display_name = 'Super Admin';
        $sa->save();

        $editor = new Role();
        $editor->name = 'editor';
        $editor->display_name = 'Editor';
        $editor->save();
    }
}
