<?php

namespace App\Repositories;

use App\Interfaces\PostInterface;
use App\Models\Post;

class PostRepository implements PostInterface
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function all(): object|string
    {
        try {
            if (request()->user()->is_admin) {
                return $this->post->with('user', 'category')->paginate(10);
            }

            return $this->post->where('user_id', request()->user()->id)->with('user', 'category')->paginate(10);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(array $data): object|string
    {
        try {
            $data['slug'] = $data['title'];
            $data['user_id'] = request()->user()->id;

            $data = collect($data)->except('thumbnail')->toArray();

            $post = $this->post->create($data);

            $post->addMediaFromRequest('thumbnail')->usingName($post->title)->toMediaCollection('posts' . '-' . $post->uuid);

            return $post;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(object $post, array $data): object|string
    {
        try {
            if ($data['title'] !== $post->title) {
                $data['slug'] = $data['title'];
            }

            $data['user_id'] = request()->user()->id;

            $data = collect($data)->except('thumbnail')->toArray();

            $post->update($data);

            // delete old thumbnail
            $post->clearMediaCollection('posts' . '-' . $post->uuid);

            $post->addMediaFromRequest('thumbnail')->usingName($post->title)->toMediaCollection('posts' . '-' . $post->uuid);

            return $post;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete(object $post): object|string
    {
        try {
            $post->delete();

            return (object) [];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function toggleActive(object $post): object|string
    {
        try {
            $post->update([
                'is_active' => ! $post->is_active,
            ]);

            return $post;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function allFrontend(): object|string
    {
        try {
            return $this->post->with('user', 'category')->where('is_active', true)->latest()->paginate(perPage: 8);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function newestFrontend(): object|string
    {
        try {
            return $this->post->with('user', 'category')->where('is_active', true)->latest()->take(5)->latest()->paginate(4);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
