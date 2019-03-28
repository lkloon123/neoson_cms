<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/28/2019
 * Time: 10:10 AM.
 */

namespace App\Views\AbstractClass;


use App\Model\Page;

abstract class AbstractBlock
{
    /* @var Page $currentPage */
    protected $currentPage;

    public function __construct($currentPage)
    {
        $this->currentPage = $currentPage;
    }

    abstract public function display();
}
