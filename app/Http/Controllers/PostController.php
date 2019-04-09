<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\DeleteRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Requests\Post\ViewRequest;
use App\Http\Resources\PostResource;
use App\Model\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ViewRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(ViewRequest $request)
    {
        if ($request->get('only_own')) {
            $posts = \Auth::user()->posts()->with('author')->get();
        } else {
            $posts = Post::with('author')->get();
        }

        if ($posts->isEmpty()) {
            return response()->json([], 204);
        }

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        //purify content
        $validated['content'] = \Purifier::clean($validated['content'], 'youtube');

        /** @var Post $post */
        $post = \Auth::user()->posts()->create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'start_at' => $validated['publish_from_date'],
            'expired_at' => $validated['publish_to_date'],
            'content' => $validated['content'],
            'status' => PostStatus::getValue($validated['status'])
        ]);

        return response()->json([
            'id' => $post->id,
            'created_at' => $post->created_at->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param ViewRequest $request
     * @param  int $id
     * @return Post|Post[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function show(ViewRequest $request, $id)
    {
        return new PostResource($request->get('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
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
            'status' => PostStatus::getValue($validated['status'])
        ]);

        return response()->json([
            'id' => $post->id,
            'updated_at' => $post->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DeleteRequest $request, $id)
    {
        /** @var Post $post */
        $post = $request->get('post');
        $result = $post->delete();

        if (!$result) {
            throw new \Exception('Unable to delete post, please try again');
        }

        return response()->json([], 204);
    }
}
