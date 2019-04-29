<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/26/2019
 * Time: 5:04 PM.
 */

namespace App\Views\Blocks;

use App\Views\AbstractClass\AbstractBlock;

class Post extends AbstractBlock
{
    public function display()
    {
        return $this->renderView('.blogs.post', [
            'content' => $this->currentPage->content,
            'author' => $this->currentPage->author->name,
            'posted_on' => $this->currentPage->start_at,
            'tags' => $this->currentPage->tags->map(function ($tag) {
                $tag->link = '/tag/' . $tag->slug;
                return $tag;
            })
        ]);
    }
}
