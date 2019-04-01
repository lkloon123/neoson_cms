<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/28/2019
 * Time: 10:10 AM.
 */

namespace App\Views\AbstractClass;


use App\Enums\PageType;
use App\Model\Page;
use App\Model\Post;

abstract class AbstractBlock extends AbstractBuilder
{
    /* @var Page|Post $currentPage */
    protected $additionalData;
    protected $currentPage;
    protected $currentPageType;

    public function __construct($additionalData, $currentPage, $currentPageType)
    {
        parent::__construct(app('setting')->get('activated_theme'));
        $this->additionalData = $additionalData;
        $this->currentPage = $currentPage;
        $this->currentPageType = $currentPageType;
    }

    protected function isHomepage()
    {
        return $this->currentPageType === PageType::Homepage;
    }

    abstract public function display();
}
