<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/28/2019
 * Time: 10:11 AM.
 */

namespace App\Views\Blocks;


use App\Enums\PageType;
use App\Views\AbstractClass\AbstractBlock;

class Content extends AbstractBlock
{
    public function display()
    {
        if ($this->isHomepage()) {
            //homepage, return post
            return '<p>post here, will be implement later</p>';
        }
        return $this->currentPage->content;
    }

    protected function isHomepage()
    {
        return $this->currentPage === PageType::Homepage;
    }
}
