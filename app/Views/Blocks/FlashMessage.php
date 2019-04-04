<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Views\Blocks;


use App\Views\AbstractClass\AbstractBlock;

class FlashMessage extends AbstractBlock
{
    public function display()
    {
        if (\Session::has('flash-message')) {
            return $this->renderView('.forms.flash_message', [
                'message' => \Session::get('flash-message')
            ]);
        }

        return null;
    }
}
