<?php

namespace App\Interfaces;

interface UserInterface
{
    public function all();

    public function create(array $data);

    public function update(object $post, array $data);

    public function delete(object $post);
}
