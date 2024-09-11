<?php

namespace App\Interfaces;

interface BookmarkInterface
{
    public function all();

    public function create($post);

    public function delete($post);
}
