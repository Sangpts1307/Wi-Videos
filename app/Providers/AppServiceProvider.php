<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \App\Repositories\Users\UserRepositoryInterface::class,
            \App\Repositories\Users\UserEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Follows\FollowRepositoryInterface::class,
            \App\Repositories\Follows\FollowEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Comments\CommentRepositoryInterface::class,
            \App\Repositories\Comments\CommentEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Likes\LikeRepositoryInterface::class,
            \App\Repositories\Likes\LikeEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Pushes\PushRepositoryInterface::class,
            \App\Repositories\Pushes\PushEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Videos\VideoRepositoryInterface::class,
            \App\Repositories\Videos\VideoEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Reports\ReportRepositoryInterface::class,
            \App\Repositories\Reports\ReportEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
