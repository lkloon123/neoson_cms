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
use App\Model\Tag;
use App\Views\Theme;
use Illuminate\Support\Collection;

abstract class AbstractBlock extends AbstractBuilder
{
    /* @var Page|Post|Tag $currentPage */
    protected $currentPage;
    protected $additionalData;
    protected $currentPageType;

    public function __construct($additionalData, $currentPage, $currentPageType)
    {
        parent::__construct(app(Theme::class));
        if (!($additionalData instanceof Collection)) {
            $additionalData = Collection::make($additionalData);
        }
        $this->additionalData = $additionalData;
        $this->currentPage = $currentPage;
        $this->currentPageType = $currentPageType;
    }

    protected function isHomepage()
    {
        return $this->currentPageType === PageType::Homepage;
    }

    protected function isTag()
    {
        return $this->currentPageType === PageType::Tag;
    }

    protected function isPost()
    {
        return $this->currentPageType === PageType::Post;
    }

    abstract public function display();
}
