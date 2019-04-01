<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Views\Blocks;


use App\Views\AbstractClass\AbstractBlock;

class Title extends AbstractBlock
{
    public function display()
    {
        if ($this->isHomepage()) {
            return 'Home';
        }

        return $this->currentPage->title;
    }
}