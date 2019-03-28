<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/27/2019
 * Time: 9:33 AM.
 */

namespace App\Views;


use App\Model\Page;
use App\Views\AbstractClass\AbstractBlock;
use App\Views\AbstractClass\AbstractBuilder;
use App\Views\Blocks\BlockFactory;

class Builder extends AbstractBuilder
{
    protected $asset;
    /* @var Page $currentPage */
    protected static $currentPage;

    public function __construct(Asset $asset, $theme)
    {
        parent::__construct($theme);
        $this->asset = $asset;
    }

    public static function setPage($page)
    {
        self::$currentPage = $page;
    }

    public function css($name, $isMinified = true)
    {
        return $this->asset->getCss($name, $isMinified);
    }

    public function js($name, $isMinified = true)
    {
        return $this->asset->getJs($name, $isMinified);
    }

    public function layout($name, $additionalData = [])
    {
        return $this->renderView(".layouts.$name", $additionalData);
    }

    public function menu($name)
    {
        return $this->renderView('.menus.menu',
            [
                'items' => \View::make('menuItems', ['dataItems' => app('menuBuilder')->build($name)])
            ]
        );
    }

    public function block($name)
    {
        /** @var AbstractBlock $block */
        $block = BlockFactory::make($name, self::$currentPage);
        if ($block === null) {
            return 'Block not found';
        }

        //display the content
        return $block->display();
    }
}
