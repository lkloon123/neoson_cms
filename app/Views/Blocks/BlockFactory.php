<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/28/2019
 * Time: 10:12 AM.
 */

namespace App\Views\Blocks;

class BlockFactory
{
    public static function make($name, $additionalData, $currentPage, $currentPageType)
    {
        if (!$name) {
            return null;
        }

        $className = __NAMESPACE__ . '\\' . ucfirst($name);

        if (class_exists($className)) {
            return new $className($additionalData, $currentPage, $currentPageType);
        }

        return null;
    }
}
