<?php

namespace App\Models;

use App\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategory extends Model
{
    use GenerateUuid, HasFactory;

    protected $fillable = [
        'uuid',
        'name',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_category_id');
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}