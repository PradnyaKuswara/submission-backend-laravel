<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCategoryRequest;
use App\Http\Resources\PostCategoryCollection;
use App\Http\Resources\PostCategoryResource;
use App\Interfaces\PostCategoryInterface;
use App\Models\PostCategory;
use Illuminate\Http\JsonResponse;

class PostCategoryController extends BaseController
{
    protected $postCategoryInterface;

    public function __construct(PostCategoryInterface $postCategoryInterface)
    {
        $this->postCategoryInterface = $postCategoryInterface;
    }

    public function index(): JsonResponse
    {
        $postCategories = $this->postCategoryInterface->all();

        return $this->sendResponse(new PostCategoryCollection($postCategories), 'Post categories retrieved successfully.');
    }

    public function find(PostCategory $postCategory): JsonResponse
    {
        return $this->sendResponse(new PostCategoryResource($postCategory), 'Post category retrieved successfully.');
    }

    public function store(PostCategoryRequest $request): JsonResponse
    {
        $result = $this->postCategoryInterface->create($request->validated());

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse(new PostCategoryResource($result), 'Post category created successfully.', 201);
    }

    public function update(PostCategoryRequest $request, PostCategory $postCategory): JsonResponse
    {
        $result = $this->postCategoryInterface->update($postCategory, $request->validated());

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse(new PostCategoryResource($result), 'Post category updated successfully.');
    }

    public function destroy(PostCategory $postCategory): JsonResponse
    {
        $result = $this->postCategoryInterface->delete($postCategory);

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse($result, 'Post category deleted successfully.');
    }
}
