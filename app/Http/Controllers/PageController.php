<?php

namespace App\Http\Controllers;

use anlutro\LaravelSettings\SettingStore;
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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    public function __construct(SettingStore $setting)
    {
        if ($setting->get('minify_output', false)) {
            $this->middleware([
                \RenatoMarinho\LaravelPageSpeed\Middleware\InlineCss::class,
                \RenatoMarinho\LaravelPageSpeed\Middleware\ElideAttributes::class,
                \RenatoMarinho\LaravelPageSpeed\Middleware\InsertDNSPrefetch::class,
                \RenatoMarinho\LaravelPageSpeed\Middleware\RemoveComments::class,
                \RenatoMarinho\LaravelPageSpeed\Middleware\RemoveQuotes::class,
                \RenatoMarinho\LaravelPageSpeed\Middleware\CollapseWhitespace::class,
            ]);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @param ViewRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(ViewRequest $request)
    {
        if ($request->get('only_own')) {
            $pages = \Auth::user()->pages()->with('author')->get();
        } else {
            $pages = Page::with('author')->get();
        }

        if ($pages->isEmpty()) {
            return response()->json([], 204);
        }

        return PageResource::collection($pages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        //purify content
        $validated['content'] = \Purifier::clean($validated['content'], 'youtube');

        /** @var Page $page */
        $page = \Auth::user()->pages()->create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'start_at' => $validated['publish_from_date'],
            'expired_at' => $validated['publish_to_date'],
            'content' => $validated['content'],
            'status' => PageStatus::getValue($validated['status'])
        ]);

        return response()->json([
            'id' => $page->id,
            'created_at' => $page->created_at->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param ViewRequest $request
     * @param int $id
     * @return Page|Page[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function show(ViewRequest $request, $id)
    {
        return new PageResource($request->get('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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
            'status' => PageStatus::getValue($validated['status'])
        ]);

        return response()->json([
            'id' => $page->id,
            'updated_at' => $page->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DeleteRequest $request, $id)
    {
        /** @var Page $page */
        $page = $request->get('page');
        $result = $page->delete();

        if (!$result) {
            throw new \Exception('Unable to delete page, please try again');
        }

        return response()->json([], 204);
    }

    public function search(SearchRequest $request)
    {
        $searchTitle = $request->get('title');
        $include = $request->get('include');

        if ($request->get('only_own')) {
            $queryBuilder = \Auth::user()->pages()->with('author');
        } else {
            $queryBuilder = Page::with('author');
        }

        if ($searchTitle) {
            $queryBuilder->where('title', 'like', "%{$searchTitle}%");
        }

        if ($include) {
            $queryBuilder->where('status', $include);
        } else {
            $queryBuilder->where('status', PageStatus::Publish);
        }

        $pages = $queryBuilder->get();

        if ($pages->isEmpty()) {
            throw new NotFoundHttpException('no result found');
        }

        return PageResource::collection($pages);
    }

    public function home()
    {
        Builder::setPage(null, PageType::Homepage);
        return view('themes.BlackrockDigital.templates.index');
    }

    public function getPage($slug)
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

        return view('themes.BlackrockDigital.templates.index');
    }
}
