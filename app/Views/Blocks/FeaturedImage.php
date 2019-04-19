<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Views\Blocks;


use App\Views\AbstractClass\AbstractBlock;

class FeaturedImage extends AbstractBlock
{
    public function display()
    {
        if ($this->isHomepage()) {
            return '';
        }

        if ($this->additionalData->has('urlOnly') && $this->additionalData->get('urlOnly')) {
            return $this->currentPage->featured_img;
        }

        return '<img src="' . $this->currentPage->featured_img . '">';
    }
}
