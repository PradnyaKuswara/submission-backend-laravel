<?php

namespace App\Http\Controllers;

use App\Interfaces\BookmarkInterface;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class BookmarkController extends BaseController
{
    protected $bookmarkInterface;

    public function __construct(BookmarkInterface $bookmarkInterface)
    {
        $this->bookmarkInterface = $bookmarkInterface;
    }

    public function index(): JsonResponse
    {
        $bookmarks = $this->bookmarkInterface->all();

        return $this->sendResponse($bookmarks, 'Bookmarks retrieved successfully.');
    }

    public function store(Post $post): JsonResponse
    {
        $result = $this->bookmarkInterface->create($post);

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse($result, 'Bookmark created successfully.', 201);
    }

    public function destroy(Post $post): JsonResponse
    {
        $result = $this->bookmarkInterface->delete($post);

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse($result, 'Bookmark deleted successfully.');
    }
}
