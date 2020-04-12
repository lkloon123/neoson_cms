<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/27/2019
 * Time: 11:47 AM.
 */

namespace App\Views;


use App\Model\Language;
use App\Model\Menu;
use App\Model\MenuItem;
use App\Model\Page;
use App\Views\AbstractClass\AbstractBuilder;

class MenuBuilder extends AbstractBuilder
{
    public function build($menuName)
    {
        $menuTree = $this->loadMenuTree($menuName);
        if (!$menuTree) {
            return [];
        }

        return $this->buildMenu($menuTree);
    }

    protected function loadMenuTree($menuName)
    {
        /** @var Menu $menu */
        $menu = Menu::where('name', $menuName)->first();
        if (!$menu) {
            return null;
        }

        return $menu->getTree();
    }

    protected function buildMenu($items)
    {
        $renderedItems = [];

        foreach ($items as $key => $item) {
            /** @var MenuItem $item */

            if ($item['children'] && \count($item['children']) > 0) {
                //this object has children
                $renderedItems[$key]['children'] = $this->buildMenu($item['children']);

                $renderedItems[$key]['parent'][] = $this->renderView('.menus.subitem',
                    array_merge(
                        [
                            'items' => \View::make('menuItems', ['dataItems' => $renderedItems[$key]['children']])
                        ],
                        $this->getMetaData($item)
                    )
                );
            } else {
                $renderedItems[$key]['parent'][] = $this->renderView('.menus.item', $this->getMetaData($item), false);
            }
        }

        return $renderedItems;
    }

    protected function getMetaData(MenuItem $item)
    {
        $metaData = [
            'meta' => $item->meta
        ];

        if ($item->meta['type'] === 'page') {
            $page = Page::find($item->meta['pageId']);
            $metaData = array_merge($metaData, [
                'title' => __($item->meta['menuLabel']),
                'url' => '/' . $page->slug,
            ]);
        }

        if ($item->meta['type'] === 'custom_link') {
            $metaData = array_merge($metaData, [
                'title' => __($item->meta['menuLabel']),
                'url' => $item->meta['url']
            ]);
        }

        if ($item->meta['type'] === 'auth') {
            $metaData = array_merge($metaData, [
                'title' => \Auth::check() ? __($item->meta['menuLabel']) : __($item->meta['guestLabel']),
                'url' => \Auth::check() ? '/login' : '/admin',
            ]);
        }

        if ($item->meta['type'] === 'language') {
            $languages = Language::whereIn('id',
                collect($item->meta['languageIds'])->map(function ($language) {
                    return $language['id'];
                })
            )->get();

            $metaData = array_merge($metaData, [
                'title' => $languages->where('code', \App::getLocale())->first()->country_iso,
                'languages' => $languages
            ]);
        }

        return $metaData;
    }
}
