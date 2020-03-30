<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/30/2019
 * Time: 12:36 PM.
 */

namespace App\Plugins;


use App\Enums\HookActions;
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

    public function disablePlugin($pluginIns)
    {
        if (optional($pluginIns)->isDisabled) {
            //already disabled, simple return
            return false;
        }

        \HookManager::dispatch(HookActions::PluginDisabling, $pluginIns);

        $disabledConfig = $this->pluginLoader->readDisabledConfig();
        $disabledConfig[] = $pluginIns->id;
        $this->pluginLoader->writeDisabledConfig($disabledConfig);

        $pluginIns->isDisabled = true;

        \HookManager::dispatch(HookActions::PluginDisabled, $pluginIns);

        return true;
    }

    public function enablePlugin($pluginIns)
    {
        if (!optional($pluginIns)->isDisabled) {
            //already enabled, simple return
            return false;
        }

        \HookManager::dispatch(HookActions::PluginEnabling, $pluginIns);

        $disabledConfig = $this->pluginLoader->readDisabledConfig();
        if (($key = array_search($pluginIns->id, $disabledConfig)) !== false) {
            unset($disabledConfig[$key]);
            $disabledConfig = array_values($disabledConfig);
        }
        $this->pluginLoader->writeDisabledConfig($disabledConfig);

        $pluginIns->isDisabled = false;

        \HookManager::dispatch(HookActions::PluginEnabled, $pluginIns);

        return true;
    }

    public function installPlugin(UploadedFile $zipFile)
    {
        $this->updateManager->install($zipFile);
    }

    public function uninstallPlugin($id)
    {
        $pluginIns = $this->getPlugin($id);

        //we will disable the plugin first to ensure everything works perfectly
        $this->disablePlugin($pluginIns);

        //delete the plugin files
        $this->updateManager->uninstall($pluginIns);

        return true;
    }
}
