<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/29/2019
 * Time: 4:33 PM.
 */

namespace App\Plugins;


use Illuminate\Support\ServiceProvider;

abstract class AbstractPlugin extends ServiceProvider
{
    public $id;
    public $isDisabled = false;

    abstract public function pluginInformation();

    /**
     * This function is to run all migration during installation purpose
     * Override this method and return an array of migration file path
     *
     * example:
     * [
     *    '1.0' => ['migration/2020_01_01_012345_create_test_table.php'],
     *    '2.0' => ['migration/2020_01_01_012345_update_test_table.php'],
     * ]
     *
     * Migration class should be at global namespace (without any namespace)
     * Migration class should extends Illuminate\Database\Migrations\Migration
     * Migration class should include public up() and down() function
     *
     * @return array
     */
    public function registerMigration()
    {
        return [];
    }

    /**
     * This function is to run all seeder during installation purpose
     * Override this method and return an array of seeder class
     *
     * example:
     * [
     *    '1.0' => [ExampleSeeder::class],
     *    '2.0' => [ExampleSeederTwo::class],
     * ]
     *
     * Seeder class should extends Illuminate\Database\Seeder
     * Seeder class should include a public run() function
     *
     * @return array
     */
    public function registerSeeder()
    {
        return [];
    }

    public function registerMiddleware()
    {
        return [
            //global => [SomeMiddleware::class]
            //group  => [SomeMiddleware::class]
            //route  => [SomeMiddleware::class]
        ];
    }

    /**
     * This function will be called during install process，
     * Override this if you have something to run when install
     */
    public function install()
    {
    }

    /**
     * This function will be called during uninstall process
     * Override this if you have something to run when uninstall
     */
    public function uninstall()
    {
    }
}
