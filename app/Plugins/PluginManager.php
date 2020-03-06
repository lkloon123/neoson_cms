<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/30/2019
 * Time: 12:36 PM.
 */

namespace App\Plugins;


use Illuminate\Http\UploadedFile;

class PluginManager
{
    protected $pluginLoader;
    protected $updateManager;

    public function __construct(PluginLoader $pluginLoader, UpdateManager $updateManager)
    {
        $this->pluginLoader = $pluginLoader;
        $this->updateManager = $updateManager;
    }

    public function getAllPlugin()
    {
        return $this->pluginLoader->getLoadedPlugins();
    }

    public function getPlugin($id)
    {
        /** @var AbstractPlugin $plugin */
        foreach ($this->getAllPlugin() as $pluginId => $plugin) {
            if ($pluginId === $id) {
                return $plugin;
            }

            if (collect($plugin->pluginInformation())->get('name') === $id) {
                return $plugin;
            }
        }

        return null;
    }

    public function disablePlugin($id)
    {
        if (optional($this->getPlugin($id))->isDisabled) {
            //already disabled, simple return
            return false;
        }

        $disabledConfig = $this->pluginLoader->readDisabledConfig();
        $disabledConfig[] = $id;
        $this->pluginLoader->writeDisabledConfig($disabledConfig);

        $this->getPlugin($id)->isDisabled = true;

        return true;
    }

    public function enablePlugin($id)
    {
        if (!optional($this->getPlugin($id))->isDisabled) {
            //already enabled, simple return
            return false;
        }

        $disabledConfig = $this->pluginLoader->readDisabledConfig();
        if (($key = array_search($id, $disabledConfig)) !== false) {
            unset($disabledConfig[$key]);
            $disabledConfig = array_values($disabledConfig);
        }
        $this->pluginLoader->writeDisabledConfig($disabledConfig);

        $this->getPlugin($id)->isDisabled = false;

        return true;
    }

    public function installPlugin(UploadedFile $zipFile)
    {
        $this->updateManager->install($zipFile);
    }

    public function uninstallPlugin($id)
    {
        //we will disable the plugin first to ensure everything works perfectly
        $this->disablePlugin($id);

        //delete the plugin files
        $this->updateManager->uninstall($this->getPlugin($id));

        return true;
    }
}
