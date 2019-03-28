<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/27/2019
 * Time: 10:49 AM.
 */

namespace App\Views;


class Asset
{
    protected $coreAsset = [];
    protected $theme;

    public function __construct($theme)
    {
        $this->coreAsset = array_merge($this->coreAsset,
            [
                'bootstrap' => asset('core/bootstrap/'),
                'jquery' => asset('core/jquery/'),
                'fontawesome' => asset('core/fontawesome/')
            ]
        );
        $this->theme = $theme;
    }

    public function getCss($name, $isMinified)
    {
        $extension = $isMinified ? 'min.css' : 'css';

        if ($this->searchForCoreAsset($name)) {
            //load from core asset
            return $this->coreAsset[$name] . "/css/$name.$extension";
        }

        if ($this->searchForThemeAsset("$name.$extension", 'css')) {
            return asset('themes/' . $this->theme . "/css/$name.$extension");
        }

        return null;
    }

    public function getJs($name, $isMinified)
    {
        $extension = $isMinified ? 'min.js' : 'js';

        if ($this->searchForCoreAsset($name)) {
            //load from core asset
            return $this->coreAsset[$name] . "/js/$name.$extension";
        }

        if ($this->searchForThemeAsset("$name.$extension", 'js')) {
            return asset('themes/' . $this->theme . "/js/$name.$extension");
        }

        return null;
    }

    protected function searchForCoreAsset($name)
    {
        if (isset($this->coreAsset[$name])) {
            //core asset found
            return true;
        }

        return false;
    }

    protected function searchForThemeAsset($name, $type)
    {
        $file = public_path('themes/' . $this->theme . "/$type/$name");
        if (file_exists($file)) {
            return true;
        }

        return false;
    }
}
