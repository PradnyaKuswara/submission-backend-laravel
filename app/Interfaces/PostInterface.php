<?php

namespace App\Interfaces;

interface PostInterface
{
    public function all();

    public function create(array $data);

    public function update(object $post, array $data);

    public function delete(object $post);

    public function toggleActive(object $post);

    public function allFrontend();

    public function newestFrontend();
}
