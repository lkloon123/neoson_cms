<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Views\Blocks;


use App\Model\Tag;
use App\Views\AbstractClass\AbstractBlock;

class Tags extends AbstractBlock
{
    public function display()
    {
        $tags = Tag::orderBy('order_column')
            ->take(5)
            ->get();

        $renderedTagElements = '';

        foreach ($tags as $tag) {
            $renderedTagElements .= $this->renderView('.blogs.tag', [
                'name' => $tag->name,
                'link' => '/tag/' . $tag->slug
            ]);
        }

        return $this->renderView('.blogs.taglist', [
            'tagItems' => $renderedTagElements
        ]);
    }
}