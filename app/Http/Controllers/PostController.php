<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Interfaces\PostInterface;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends BaseController
{
    protected $postInterface;

    public function __construct(PostInterface $postInterface)
    {
        $this->postInterface = $postInterface;
    }

    public function index(): JsonResponse
    {
        $posts = $this->postInterface->all();

        return $this->sendResponse(new PostCollection($posts), 'Post retrieved successfully.');
    }

    public function find(Post $post): JsonResponse
    {
        return $this->sendResponse(new PostResource($post), 'Post retrieved successfully.');
    }

    public function store(PostRequest $request): JsonResponse
    {
        $result = $this->postInterface->create($request->validated());

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse(new PostResource($result), 'Post created successfully.', 201);
    }

    public function update(PostRequest $request, Post $post): JsonResponse
    {
        $result = $this->postInterface->update($post, $request->validated());

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse(new PostResource($result), 'Post updated successfully.');
    }

    public function destroy(Post $post): JsonResponse
    {
        $result = $this->postInterface->delete($post);

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse($result, 'Post deleted successfully.');
    }

    public function toggleActive(Post $post): JsonResponse
    {
        $result = $this->postInterface->toggleActive($post);

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse(new PostResource($result), 'Post updated successfully.');
    }

    public function allFrontend(): JsonResponse
    {
        $posts = $this->postInterface->allFrontend();

        return $this->sendResponse(new PostCollection($posts), 'Post retrieved successfully.');
    }

    public function newestFrontend(): JsonResponse
    {
        $posts = $this->postInterface->newestFrontend();

        return $this->sendResponse(new PostCollection($posts), 'Post retrieved successfully.');
    }
}
