<?php

namespace App\Interfaces;

interface PostCategoryInterface
{
    public function all();

    public function create(array $data);

    public function update(object $postCategory, array $data);

    public function delete(object $postCategory);
}
