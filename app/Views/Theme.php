<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/29/2019
 * Time: 2:26 PM.
 */

namespace App\Views;

class Theme
{
    protected $activatedTheme;

    public function __construct($activatedTheme)
    {
        $this->activatedTheme = $activatedTheme;
    }

    public function getView($path, $additionalData = [])
    {
        $themeViewPath = $this->getThemeViewFromPath($path);
        if ($this->exist($path)) {
            return \View::make($themeViewPath, $additionalData);
        }

        return false;
    }

    public function getViewAndRender($path, $additionalData = [])
    {
        if ($view = $this->getView($path, $additionalData)) {
            return $view->render();
        }

        return $view;
    }

    public function exist($path)
    {
        return \View::exists($this->getThemeViewFromPath($path));
    }

    public function setTheme($name)
    {
        $this->activatedTheme = $name;
        return $this;
    }

    public function getTheme()
    {
        return $this->activatedTheme;
    }

    protected function getThemeViewFromPath($path)
    {
        return 'themes.' . $this->activatedTheme . ".$path";
    }

    public function __toString()
    {
        return $this->getTheme();
    }
}
