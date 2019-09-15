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
use Chumper\Zipper\Zipper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class UpdateManager
{
    protected $zipper;
    protected $composer;
    protected $pluginLoader;

    public function __construct(Zipper $zipper, Composer $composer, PluginLoader $pluginLoader)
    {
        $this->zipper = $zipper;
        $this->composer = $composer;
        $this->pluginLoader = $pluginLoader;
    }

    public function install(UploadedFile $zipFile)
    {
        $archive = $this->zipper->make($zipFile);
        if (!$archive->contains('composer.json') || !$archive->contains('Plugin.php')) {
            throw new PluginInstallException('plugin must contain composer.json and Plugin.php');
        }

        $composerJson = $archive->getFileContent('composer.json');

        $figuredPluginInstallationDir = $this->getPluginInstallationDir($composerJson);

        if (!$figuredPluginInstallationDir) {
            throw new PluginInstallException('plugin has incorrect psr4 namespace');
        }

        $isPluginInstalled = $this->isPluginInstalled($figuredPluginInstallationDir[0] . '.' . $figuredPluginInstallationDir[1]);

        if ($isPluginInstalled) {
            throw new PluginInstallException('plugin has already installed');
        }

        $archive->extractTo(storage_path() . '/plugins/' . Str::snake($figuredPluginInstallationDir[0]) . '/' . Str::snake($figuredPluginInstallationDir[1]));
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
