<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/29/2019
 * Time: 4:09 PM.
 */

namespace App\Views\Blocks;

use App\Enums\PageType;
use App\Model\Post;
use App\Views\AbstractClass\AbstractBlock;
use Illuminate\Support\Arr;

class PostItemList extends AbstractBlock
{
    public function display()
    {
        //display list of post
        return $this->buildPostItemList();
    }

    protected function buildPostItemList()
    {
        $postBuilder = Post::with('author')
            ->published()
            ->withinSchedule()
            ->orderBy('created_at', 'desc')
            ->take(5);

        if ($this->isTag()) {
            $postBuilder->withAllTags(Arr::wrap($this->currentPage->name));
        }

        $postList = $postBuilder->get();
        $renderedPostItems = '';

        foreach ($postList as $post) {
            $renderedPostItems .= $this->buildPostItem($post);
        }

        return $this->renderView('.blogs.postlist', [
            'postItems' => $renderedPostItems
        ]);
    }

    protected function buildPostItem(Post $post)
    {
        return $this->renderView('.blogs.postitem', $this->getMetaData($post));
    }

    protected function getMetaData(Post $post)
    {
        return [
            'title' => $post->title,
            'description' => $post->description,
            'content' => $post->content,
            'author' => $post->author->name,
            'created_at' => $post->created_at,
            'url' => '/' . $post->slug
        ];
    }
}
