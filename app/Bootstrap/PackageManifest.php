<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 5/3/2019
 * Time: 4:13 PM.
 */

namespace App\Bootstrap;

use App\Plugins\PluginLoader;
use Illuminate\Support\Collection;

class PackageManifest extends \Illuminate\Foundation\PackageManifest
{
    protected function packagesToIgnore()
    {
        $ignoredPackages = [];

        if (!file_exists($this->basePath . '/composer.json')) {
            return [];
        }

        foreach (PluginLoader::getInstalledPluginsComposerPath() as $pluginComposerPath => $pluginPath) {
            /** @var Collection $parsedComposerJson */
            $parsedComposerJson = $this->parseComposerJson($pluginComposerPath);
            if (isset($parsedComposerJson['extra']['laravel']['dont-discover'])) {
                $dontDiscovers = $parsedComposerJson['extra']['laravel']['dont-discover'];
                foreach ($dontDiscovers as $dontDiscover) {
                    $ignoredPackages[] = $dontDiscover;
                }
            }
        }

        $rootIgnoredPackage = $this->parseComposerJson($this->basePath . '/composer.json')['extra']['laravel']['dont-discover'] ?? [];

        return array_unique(
            array_merge($ignoredPackages, $rootIgnoredPackage)
        );
    }

    protected function parseComposerJson($composerJsonFilePath)
    {
        $composerJsonStr = file_get_contents($composerJsonFilePath);
        return json_decode($composerJsonStr, true);
    }
}
