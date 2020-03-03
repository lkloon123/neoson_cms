<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/5/2019
 * Time: 11:11 AM.
 */

namespace App\Http\Controllers;

use App\Enums\PageType;
use App\Http\Requests\Tag\CreateRequest;
use App\Http\Requests\Tag\DeleteRequest;
use App\Http\Requests\Tag\SearchRequest;
use App\Http\Requests\Tag\UpdateRequest;
use App\Http\Requests\Tag\ViewRequest;
use App\Http\Resources\TagResource;
use App\Model\Tag;
use App\Views\Builder;
use App\Views\Theme;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController extends Controller
{
    public function index(ViewRequest $request)
    {
        $tags = Tag::getAllWithCount();

        if ($tags->isEmpty()) {
            return response()->noContent();
        }

        return TagResource::collection($tags);
    }

    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        $nameExist = Tag::findFromString($validated['name']);
        if ($nameExist) {
            throw new ConflictHttpException('name [' . $validated['name'] . '] already exist');
        }

        $slugExist = Tag::findFromSlug($validated['slug'])->first();
        if ($slugExist) {
            throw new ConflictHttpException('slug [' . $validated['slug'] . '] already exist');
        }

        $tag = Tag::create([
            'name' => $validated['name'],
            'slug' => $validated['slug']
        ]);

        return response()->json([
            'id' => $tag->id
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();

        /** @var Tag $tag */
        $tag = $request->get('tag');

        $tag->update([
            'name' => $validated['name'],
            'slug' => $validated['slug']
        ]);

        return response()->json([
            'id' => $tag->id
        ]);
    }

    public function destroy(DeleteRequest $request, $id)
    {
        /** @var Tag $tag */
        $tag = $request->get('tag');
        $result = $tag->delete();

        if (!$result) {
            throw new \Exception('Unable to delete tag, please try again');
        }

        return response()->noContent();
    }

    public function search(SearchRequest $request)
    {
        $name = $request->get('name');
        $locale = app()->getLocale();

        if ($name) {
            $tags = Tag::where("name->{$locale}", 'like', "%{$name}%")->get(['id', 'name']);
        } else {
            $tags = Tag::all(['id', 'name']);
        }

        if ($tags->isEmpty()) {
            throw new NotFoundHttpException('no result found');
        }

        return TagResource::collection($tags);
    }

    public function getTag($slug, Theme $theme)
    {
        $tag = Tag::findFromSlug($slug)->firstOrFail();

        Builder::setPage($tag, PageType::Tag);

        return view('themes.' . $theme->getTheme() . '.templates.index');
    }
}
