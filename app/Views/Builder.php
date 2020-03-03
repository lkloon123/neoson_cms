<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/27/2019
 * Time: 9:33 AM.
 */

namespace App\Views;


use App\Enums\PageType;
use App\Model\Page;
use App\Views\AbstractClass\AbstractBlock;
use App\Views\AbstractClass\AbstractBuilder;
use App\Views\Blocks\BlockFactory;

class Builder extends AbstractBuilder
{
    /* @var Page $currentPage */
    protected static $currentPage;
    protected static $currentPageType;

    public static function setPage($page, $pageType = PageType::Page)
    {
        self::$currentPage = $page;
        self::$currentPageType = $pageType;
    }

    public function css($name, $isMinified = true)
    {
        return app(Asset::class)->getCss($name, $isMinified);
    }

    public function js($name, $isMinified = true)
    {
        return app(Asset::class)->getJs($name, $isMinified);
    }

    public function section($name, $additionalData = [])
    {
        return $this->renderView(".sections.$name", $additionalData);
    }

    public function menu($name)
    {
        return $this->renderView('.menus.menu',
            [
                'items' => \View::make('menuItems', ['dataItems' => app(MenuBuilder::class)->build($name)])
            ]
        );
    }

    public function setting($name, $default = '')
    {
        return app('config')->get($name, $default);
    }

    public function block($name, array $additionalData = [])
    {
        /** @var AbstractBlock $block */
        $block = BlockFactory::make($name, $additionalData, self::$currentPage, self::$currentPageType);
        if ($block === null) {
            return 'Block not found';
        }

        //display the content
        return $block->display();
    }

    public function is($pageType)
    {
        return self::$currentPageType === $pageType;
    }
}
