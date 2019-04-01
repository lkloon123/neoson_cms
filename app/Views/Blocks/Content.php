<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/28/2019
 * Time: 10:11 AM.
 */

namespace App\Views\Blocks;

use App\Views\AbstractClass\AbstractBlock;

class Content extends AbstractBlock
{
    public function display()
    {
        if ($this->isHomepage()) {
            //homepage, return post
            return \PageContent::block('PostItemList');
        }
        return $this->currentPage->content;
    }
}
