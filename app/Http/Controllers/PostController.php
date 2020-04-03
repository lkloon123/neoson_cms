<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\DeleteRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Requests\Post\ViewRequest;
use App\Http\Resources\PostResource;
use App\Model\Post;
use Illuminate\Support\Arr;

class PostController extends Controller
{
    public function index(ViewRequest $request)
    {
        if ($request->get('only_own')) {
            $posts = $this->getUser()->posts()->with(['author', 'tags'])->get();
        } else {
            $posts = Post::with(['author', 'tags'])->get();
        }

        if ($posts->isEmpty()) {
            return response()->noContent();
        }

        return PostResource::collection($posts);
    }

    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        //purify content
        $validated['content'] = \Purifier::clean($validated['content'], 'youtube');

        /** @var Post $post */
        $post = $this->getUser()->posts()->create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'start_at' => $validated['publish_from_date'],
            'expired_at' => $validated['publish_to_date'],
            'content' => $validated['content'],
            'status' => PostStatus::getValue($validated['status']),
            'featured_img' => $validated['featuredImg']
        ]);

        $tags = Arr::pluck($validated['tags'], 'name');
        $post->syncTags($tags);

        return response()->json([
            'id' => $post->id,
            'created_at' => $post->created_at->format('Y-m-d H:i:s')
        ]);
    }

    public function show(ViewRequest $request, $id)
    {
        return new PostResource($request->get('post'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();

        //purify content
        $validated['content'] = \Purifier::clean($validated['content'], 'youtube');

        /** @var Post $post */
        $post = $request->get('post');
        $post->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'start_at' => $validated['publish_from_date'],
            'expired_at' => $validated['publish_to_date'],
            'content' => $validated['content'],
            'status' => PostStatus::getValue($validated['status']),
            'featured_img' => $validated['featuredImg']
        ]);

        $tags = Arr::pluck($validated['tags'], 'name');
        $post->syncTags($tags);

        return response()->json([
            'id' => $post->id,
            'updated_at' => $post->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function destroy(DeleteRequest $request, $id)
    {
        /** @var Post $post */
        $post = $request->get('post');
        $result = $post->delete();

        if (!$result) {
            throw new \Exception('Unable to delete post, please try again');
        }

        return response()->noContent();
    }

    public function count(ViewRequest $request)
    {
        if ($request->get('only_own')) {
            return response()->json(['count' => $this->getUser()->posts()->published()->withinSchedule()->count()]);
        }

        return response()->json(['count' => Post::published()->withinSchedule()->count()]);
    }
}
