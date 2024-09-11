<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

trait Slugable
{
    public function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => $this->generateUniqueSlug($value),
        );
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    private function generateUniqueSlug(string $value): string
    {
        return Str::slug($value).'-'.now()->format('YmdHis');
    }
}
