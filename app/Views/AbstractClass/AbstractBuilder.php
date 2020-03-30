<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/27/2019
 * Time: 12:19 PM.
 */

namespace App\Views\AbstractClass;


use App\Plugins\PluginManager;
use App\Views\Theme;
use Illuminate\Support\Str;

abstract class AbstractBuilder
{
    protected $theme;
    protected $pluginManager;

    public function __construct(Theme $theme, PluginManager $pluginManager)
    {
        $this->theme = $theme;
        $this->pluginManager = $pluginManager;
    }

    protected function renderView($path, $additionalData = [], $render = true)
    {
        //attempt to render from plugin first before theme
        $view = $this->renderViewFromPlugin($path, $additionalData, $render);
        if ($view !== false) {
            return $view;
        }

        //we will look from theme if not found from plugin
        if ($render) {
            $view = $this->theme->getViewAndRender($path, $additionalData);
        } else {
            $view = $this->theme->getView($path, $additionalData);
        }

        if (!$view) {
            return 'View not found';
        }

        return $view;
    }

    protected function renderViewFromPlugin($path, $additionalData = [], $render = true)
    {
        if (Str::startsWith($path, '.')) {
            $path = substr($path, 1);
        }

        $allPlugins = $this->pluginManager->getAllPlugin();

        foreach ($allPlugins as $plugin) {
            $pluginId = $plugin->id;
            $viewPath = $pluginId . '::' . $path;

            if (!\View::exists($viewPath)) {
                continue;
            }

            $view = \View::make($viewPath, $additionalData);
            if ($render) {
                return $view->render();
            }

            return $view;
        }

        return false;
    }

    protected function getTheme()
    {
        return $this->theme;
    }
}
