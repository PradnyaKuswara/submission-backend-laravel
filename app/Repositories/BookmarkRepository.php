<?php

namespace App\Repositories;

use App\Interfaces\BookmarkInterface;

class BookmarkRepository implements BookmarkInterface
{
    public function all(): object|string
    {
        try {
            return request()->user()->bookmarks;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create($post): bool|string
    {
        try {

            if (request()->user()->bookmarks()->where('post_id', $post->id)->exists()) {
                return 'Post already bookmarked';
            }

            request()->user()->bookmarks()->attach($post);

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($post): bool|string
    {
        try {
            request()->user()->bookmarks()->detach($post);

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
