<?php

namespace App\Repositories;

use App\Interfaces\PostCategoryInterface;
use App\Models\PostCategory;

class PostCategoryRepository implements PostCategoryInterface
{
    private $postCategory;

    public function __construct(PostCategory $postCategory)
    {
        $this->postCategory = $postCategory;
    }

    public function all(): object|string
    {
        try {
            return $this->postCategory->latest()->paginate(perPage: 10);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(array $data): object|string
    {
        try {
            return $this->postCategory->create($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(object $postCategory, array $data): object|string
    {
        try {
            $postCategory->update($data);

            return $postCategory;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete(object $postCategory): object|string
    {
        try {
            $postCategory->delete();

            return (object) [];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
