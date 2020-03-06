<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 5/8/2019
 * Time: 4:15 PM.
 */

namespace App\Plugins;


use App\Bootstrap\Composer;
use App\Enums\HookActions;
use App\Exceptions\PluginInstallException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpZip\ZipFile;

class UpdateManager
{
    protected $zipper;
    protected $composer;
    protected $pluginLoader;

    public function __construct(ZipFile $zipper, Composer $composer, PluginLoader $pluginLoader)
    {
        $this->zipper = $zipper;
        $this->composer = $composer;
        $this->pluginLoader = $pluginLoader;
    }

    public function install(UploadedFile $zipFile)
    {
        $archive = $this->zipper->openFile($zipFile);
        if (!$archive->hasEntry('composer.json') || !$archive->hasEntry('Plugin.php')) {
            throw new PluginInstallException('plugin must contain composer.json and Plugin.php');
        }

        $composerJson = $archive->getEntryContents('composer.json');

        $figuredPluginInstallationDir = $this->getPluginInstallationDir($composerJson);
        if (!$figuredPluginInstallationDir) {
            throw new PluginInstallException('plugin has incorrect psr4 namespace');
        }

        $pluginNamespace = $figuredPluginInstallationDir[0] . '\\' . $figuredPluginInstallationDir[1];
        $pluginId = str_replace('\\', '.', $pluginNamespace);

        $isPluginInstalled = $this->isPluginInstalled($pluginId);
        if ($isPluginInstalled) {
            throw new PluginInstallException('plugin has already installed');
        }

        $pluginInstallationPath = storage_path() . '/plugins/' . Str::snake($figuredPluginInstallationDir[0]) . '/' . Str::snake($figuredPluginInstallationDir[1]);
        if (!\File::isDirectory($pluginInstallationPath)) {
            \File::makeDirectory($pluginInstallationPath, 0755, true);
        }

        $archive->extractTo($pluginInstallationPath);
        $archive->close();

        $this->composer->installDependencies($pluginInstallationPath);

        //reload all plugins
        $this->pluginLoader->reloadPlugins();

        //get the plugin instance
        $pluginIns = app(PluginManager::class)->getPlugin($pluginId);

        //enable the plugin
        app(PluginManager::class)->enablePlugin($pluginId);

        $this->afterInstalled($pluginIns);
    }

    public function uninstall($pluginIns)
    {
        $pluginPath = $this->pluginLoader->getPluginPath($pluginIns->id);

        //dispatch plugin uninstalling hook
        \HookManager::dispatch(HookActions::PluginUninstalling, $pluginIns);

        //run plugin uninstall function
        $pluginIns->uninstall();

        //rollback all migrations
        foreach (array_reverse($pluginIns->registerMigration()) as $version => $migrationPaths) {
            foreach (array_reverse($migrationPaths) as $migrationPath) {
                \Artisan::call('migrate:rollback', ['--realpath' => true, '--path' => $pluginPath . DIRECTORY_SEPARATOR . $migrationPath]);
            }
        }

        //delete the plugin folder
        \File::deleteDirectory($pluginPath);

        //dispatch plugin installed hook
        \HookManager::dispatch(HookActions::PluginUninstalled);
    }

    protected function getPluginInstallationDir($composerJsonStr)
    {
        /** @var Collection $composerCollection */
        $composerCollection = collect(json_decode($composerJsonStr, true))->recursive();

        if ($composerCollection->has('autoload') && $composerCollection->get('autoload')->has('psr-4')) {
            //plugin namespace found

            $namespace = $composerCollection
                ->get('autoload')
                ->get('psr-4')
                ->keys()
                ->first();

            $splitedNamespace = explode('\\', $namespace);
            if (\count($splitedNamespace) >= 2) {
                return $splitedNamespace;
            }
        }

        return false;
    }

    protected function isPluginInstalled($pluginId)
    {
        return $this->pluginLoader->getLoadedPlugins()->has($pluginId);
    }

    protected function afterInstalled($pluginIns)
    {
        $pluginInformation = collect($pluginIns->pluginInformation());
        $pluginPath = $this->pluginLoader->getPluginPath($pluginIns->id);

        //run plugin install function
        $pluginIns->install();

        //run migration if version match
        foreach ($pluginIns->registerMigration() as $version => $migrationPaths) {
            if ($version !== $pluginInformation->get('ver')) {
                continue;
            }

            foreach (Arr::wrap($migrationPaths) as $migrationPath) {
                \Artisan::call('migrate', ['--realpath' => true, '--path' => $pluginPath . DIRECTORY_SEPARATOR . $migrationPath]);
            }
        }

        //run seeder if version match
        foreach ($pluginIns->registerSeeder() as $version => $seederClasses) {
            if ($version !== $pluginInformation->get('ver')) {
                continue;
            }

            foreach (Arr::wrap($seederClasses) as $seederClass) {
                \Artisan::call('db:seed', ['--class' => $seederClass]);
            }
        }

        //dispatch plugin installed hook
        \HookManager::dispatch(HookActions::PluginInstalled, $pluginIns);
    }
}
