<?php

namespace App\Http\Controllers;

use App\Enums\PageStatus;
use App\Enums\PageType;
use App\Http\Requests\Page\CreateRequest;
use App\Http\Requests\Page\DeleteRequest;
use App\Http\Requests\Page\SearchRequest;
use App\Http\Requests\Page\UpdateRequest;
use App\Http\Requests\Page\ViewRequest;
use App\Http\Resources\PageResource;
use App\Model\Page;
use App\Model\Post;
use App\Views\Builder;
use App\Views\Theme;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    public function index(ViewRequest $request)
    {
        if ($request->get('only_own')) {
            $pages = $this->getUser()->pages()->with('author')->get();
        } else {
            $pages = Page::with('author')->get();
        }

        if ($pages->isEmpty()) {
            return response()->noContent();
        }

        return PageResource::collection($pages);
    }

    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        //purify content
        $validated['content'] = \Purifier::clean($validated['content'], 'youtube');

        /** @var Page $page */
        $page = $this->getUser()->pages()->create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'start_at' => $validated['publish_from_date'],
            'expired_at' => $validated['publish_to_date'],
            'content' => $validated['content'],
            'status' => PageStatus::getValue($validated['status']),
            'featured_img' => $validated['featuredImg']
        ]);

        return response()->json([
            'id' => $page->id,
            'created_at' => $page->created_at->format('Y-m-d H:i:s')
        ]);
    }

    public function show(ViewRequest $request, $id)
    {
        return new PageResource($request->get('page'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();

        //purify content
        $validated['content'] = \Purifier::clean($validated['content'], 'youtube');

        /** @var Page $page */
        $page = $request->get('page');
        $page->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'start_at' => $validated['publish_from_date'],
            'expired_at' => $validated['publish_to_date'],
            'content' => $validated['content'],
            'status' => PageStatus::getValue($validated['status']),
            'featured_img' => $validated['featuredImg']
        ]);

        return response()->json([
            'id' => $page->id,
            'updated_at' => $page->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function destroy(DeleteRequest $request, $id)
    {
        /** @var Page $page */
        $page = $request->get('page');
        $result = $page->delete();

        if (!$result) {
            throw new \Exception('Unable to delete page, please try again');
        }

        return response()->noContent();
    }

    public function search(SearchRequest $request)
    {
        if ($request->get('only_own')) {
            $queryBuilder = $this->getUser()->pages()->with('author');
        } else {
            $queryBuilder = Page::with('author');
        }

        $pages = $queryBuilder
            ->when($request->get('title'), function (\Illuminate\Database\Eloquent\Builder $query, $searchTitle) {
                $query->where('title', 'like', "%{$searchTitle}%");
            })
            ->when($request->get('include'),
                function (\Illuminate\Database\Eloquent\Builder $query, $include) {
                    $query->where('status', $include);
                },
                function (\Illuminate\Database\Eloquent\Builder $query) {
                    $query->where('status', PageStatus::Publish);
                })
            ->get();

        if ($pages->isEmpty()) {
            throw new NotFoundHttpException('no result found');
        }

        return PageResource::collection($pages);
    }

    public function count(ViewRequest $request)
    {
        if ($request->get('only_own')) {
            return response()->json(['count' => $this->getUser()->pages()->published()->withinSchedule()->count()]);
        }

        return response()->json(['count' => Page::published()->withinSchedule()->count()]);
    }

    public function home(Theme $theme)
    {
        Builder::setPage(null, PageType::Homepage);
        return view('themes.' . $theme->getTheme() . '.templates.index');
    }

    public function getPage($slug, Theme $theme)
    {
        $page = Page::published()
            ->withinSchedule()
            ->where('slug', $slug)
            ->first();

        if ($page === null) {
            //try to find from post
            $post = Post::published()
                ->withinSchedule()
                ->where('slug', $slug)
                ->firstOrFail();

            Builder::setPage($post, PageType::Post);
        } else {
            Builder::setPage($page);
        }

        return view('themes.' . $theme->getTheme() . '.templates.index');
    }
}
