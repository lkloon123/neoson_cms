<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 5/8/2019
 * Time: 4:15 PM.
 */

namespace App\Plugins;


use App\Bootstrap\Composer;
use App\Exceptions\PluginInstallException;
use Illuminate\Http\UploadedFile;
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

        $isPluginInstalled = $this->isPluginInstalled($figuredPluginInstallationDir[0] . '.' . $figuredPluginInstallationDir[1]);
        if ($isPluginInstalled) {
            throw new PluginInstallException('plugin has already installed');
        }

        $pluginInstallationPath = storage_path() . '/plugins/' . Str::snake($figuredPluginInstallationDir[0]) . '/' . Str::snake($figuredPluginInstallationDir[1]);
        if (!\File::isDirectory($pluginInstallationPath)) {
            \File::makeDirectory($pluginInstallationPath);
        }

        $archive->extractTo($pluginInstallationPath);
        $archive->close();

        $this->composer->updateAndLock();
    }

    public function uninstall($pluginInstallationPath)
    {
        \File::deleteDirectory($pluginInstallationPath);
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
}
