<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/27/2019
 * Time: 12:19 PM.
 */

namespace App\Views\AbstractClass;


use App\Views\Theme;

abstract class AbstractBuilder
{
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    protected function renderView($path, $additionalData = [], $render = true)
    {
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

    protected function getTheme()
    {
        return $this->theme;
    }
}
