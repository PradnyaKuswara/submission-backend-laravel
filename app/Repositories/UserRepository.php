<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all(): object|string
    {
        try {
            return $this->user->all();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(array $data): object|string
    {
        try {
            $data['password'] = bcrypt($data['password']);

            return $this->user->create($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($user, array $data): object|string
    {
        try {
            $user->update($data);

            return $user;
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function delete(object $user): object|string
    {
        try {
            $user->posts()->delete();
            $user->delete();

            return (object) [];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
