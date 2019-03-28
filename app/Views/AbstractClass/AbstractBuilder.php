<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/27/2019
 * Time: 12:19 PM.
 */

namespace App\Views\AbstractClass;


abstract class AbstractBuilder
{
    protected $theme;

    public function __construct($theme)
    {
        $this->theme = $theme;
    }

    protected function renderView($path, $additionalData = [], $render = true)
    {
        $themeViewPath = 'themes.' . $this->theme . ".$path";
        if (\View::exists($themeViewPath)) {
            $view = \View::make($themeViewPath, $additionalData);
            return $render ? $view->render() : $view;
        }

        return 'View not found';
    }
}
