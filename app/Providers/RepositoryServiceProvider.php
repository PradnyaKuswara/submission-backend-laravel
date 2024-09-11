<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\PostCategoryInterface::class,
            \App\Repositories\PostCategoryRepository::class
        );

        $this->app->bind(
            \App\Interfaces\PostInterface::class,
            \App\Repositories\PostRepository::class
        );

        $this->app->bind(
            \App\Interfaces\BookmarkInterface::class,
            \App\Repositories\BookmarkRepository::class
        );

        $this->app->bind(
            \App\Interfaces\UserInterface::class,
            \App\Repositories\UserRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
