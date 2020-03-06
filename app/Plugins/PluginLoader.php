<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/29/2019
 * Time: 4:38 PM.
 */

namespace App\Plugins;


use App\Bootstrap\Composer;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class PluginLoader
{
    protected $composer;
    protected $disabledConfigPath;
    protected $plugins;
    protected $pathMapper;

    protected $hasRegistered;
    protected $hasBooted;

    public function __construct($disabledPluginConfigFilePath, Composer $composer)
    {
        $this->composer = $composer;
        $this->disabledConfigPath = $disabledPluginConfigFilePath;
        $this->plugins = collect();
        $this->pathMapper = collect();

        $this->hasRegistered = false;
        $this->hasBooted = false;

        $this->loadPlugins();
    }

    public function loadPlugins()
    {
        $namespaces = $this->getPluginsNamespace();

        foreach ($namespaces as $namespace => $pluginPath) {
            //we register the plugin autoloader first
            $this->composer->registerPluginAutoLoader($pluginPath);

            $className = '\\' . $namespace . 'Plugin';
            if (class_exists($className)) {
                if ($this->plugins->contains($this->getPluginId($className))) {
                    continue;
                }
                $createdPlugin = new $className(app('app'));
                $createdPlugin->id = $this->getPluginId($className);
                if ($this->isDisabled($className)) {
                    $createdPlugin->isDisabled = true;
                }
                $this->plugins->put($createdPlugin->id, $createdPlugin);
                $this->pathMapper->put($createdPlugin->id, $pluginPath);
            }
        }
    }

    public function getPluginsNamespace()
    {
        $namespace = [];

        foreach (self::getInstalledPluginsComposerPath() as $pluginComposerPath => $pluginPath) {
            //load namespace
            /** @var Collection $parsedComposerJson */
            $parsedComposerJson = $this->parseComposerJson($pluginComposerPath);
            if (!$parsedComposerJson) {
                //there's some error in composer json
                //TODO: handle error plugin
            } else {
                if ($parsedComposerJson->has('autoload') && $parsedComposerJson->get('autoload')->has('psr-4')) {
                    //plugin namespace found
                    $namespace = Arr::add(
                        $namespace,
                        $parsedComposerJson
                            ->get('autoload')
                            ->get('psr-4')
                            ->keys()
                            ->first(),
                        $pluginPath
                    );
                } else {
                    //TODO: handle namespace not found error
                }
            }
        }

        return $namespace;
    }

    public static function getInstalledPluginsComposerPath()
    {
        $plugins = [];

        $searchPointer = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(self::getPluginsPath(), RecursiveDirectoryIterator::FOLLOW_SYMLINKS)
        );
        $searchPointer->setMaxDepth(2);
        $searchPointer->rewind();

        while ($searchPointer->valid()) {
            if ($searchPointer->getDepth() > 1 && $searchPointer->isFile() && strtolower($searchPointer->getFilename()) == "plugin.php") {
                //plugin found
                $pluginFilePath = dirname($searchPointer->getPathname());
                $pluginComposerFile = $pluginFilePath . '/composer.json';
                if (file_exists($pluginComposerFile)) {
                    $plugins[$pluginComposerFile] = $pluginFilePath;
                }
            }

            $searchPointer->next();
        }
        return $plugins;
    }

    public function registerAllPluginServiceProvider()
    {
        if (!$this->hasRegistered) {
            foreach ($this->plugins as $pluginId => $pluginClass) {
                /** @var AbstractPlugin $pluginClass */
                if (!$pluginClass->isDisabled) {
                    $this->registerPlugin($pluginClass);
                }
            }
        }

        $this->hasRegistered = true;

        return $this;
    }

    public function bootAllPluginServiceProvider()
    {
        if (!$this->hasBooted) {
            foreach ($this->plugins as $pluginId => $pluginClass) {
                /** @var AbstractPlugin $pluginClass */
                if (!$pluginClass->isDisabled) {
                    $this->bootPlugin($pluginClass);
                }
            }
        }

        $this->hasBooted = true;

        return $this;
    }

    public function registerPlugin(AbstractPlugin $pluginClass)
    {
        // register plugin config
        $configPath = $this->getPluginPath($pluginClass->id) . '/config';
        if (\File::isDirectory($configPath)) {
            $configFiles = scandir($configPath);
            foreach ($configFiles as $configFile) {
                if (\File::isFile($configPath . '/' . $configFile)) {
                    $config = app('config')->get(basename($configFile, '.php'), []);
                    app('config')->set(basename($configFile, '.php'), array_merge(require $configPath . '/' . $configFile, $config));
                }
            }
        }

        // run plugin register method
        $pluginClass->register();
    }

    public function bootPlugin(AbstractPlugin $pluginClass)
    {
        // boot plugin middleware
        /** @var Collection $middlewares */
        $middlewares = collect($pluginClass->registerMiddleware());
        if ($middlewares->has('global')) {
            Collection::wrap($middlewares->get('global'))
                ->each(function ($middlewareClass) {
                    app(Kernel::class)->pushMiddleware($middlewareClass);
                });
        }

        if ($middlewares->has('group')) {
            Collection::wrap($middlewares->get('group'))
                ->each(function ($middlewareClass, $key) {
                    app(Router::class)->middlewareGroup($key, $middlewareClass);
                });
        }

        if ($middlewares->has('route')) {
            Collection::wrap($middlewares->get('route'))
                ->each(function ($middlewareClass, $key) {
                    app(Router::class)->aliasMiddleware($key, $middlewareClass);
                });
        }

        // run plugin boot method if exist
        if (method_exists($pluginClass, 'boot')) {
            $pluginClass->boot();
        }
    }

    public function getLoadedPlugins()
    {
        return $this->plugins;
    }

    public function getPluginPath($pluginId)
    {
        return $this->pathMapper->get($pluginId);
    }

    public function readDisabledConfig()
    {
        return \File::exists($this->disabledConfigPath) ? json_decode(\File::get($this->disabledConfigPath), true) : [];
    }

    public function writeDisabledConfig($config)
    {
        \File::put($this->disabledConfigPath, json_encode($config));
    }

    public function reloadPlugins()
    {
        //reinitialize composer
        $this->composer->initialize();

        $this->plugins = collect();
        $this->pathMapper = collect();

        $this->hasRegistered = false;
        $this->hasBooted = false;

        $this->loadPlugins();
    }

    protected function getPluginId($plugin)
    {
        $splittedNamespace = explode('\\', $plugin);
        return $splittedNamespace[1] . '.' . $splittedNamespace[2];
    }

    protected function parseComposerJson($composerJsonFilePath)
    {
        $composerJsonStr = file_get_contents($composerJsonFilePath);
        return collect(json_decode($composerJsonStr, true))->recursive();
    }

    protected static function getPluginsPath()
    {
        return storage_path('plugins');
    }

    protected function isDisabled($plugin)
    {
        $pluginId = $this->getPluginId($plugin);
        $config = $this->readDisabledConfig();
        if (\in_array($pluginId, $config)) {
            return true;
        }

        return false;
    }
}
