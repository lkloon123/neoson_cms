<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Bootstrap;

class ComposerScripts extends \Illuminate\Foundation\ComposerScripts
{
    protected static function clearCompiled()
    {
        $laravel = new Application(getcwd());

        if (file_exists($servicesPath = $laravel->getCachedServicesPath())) {
            @unlink($servicesPath);
        }

        if (file_exists($packagesPath = $laravel->getCachedPackagesPath())) {
            @unlink($packagesPath);
        }
    }
}