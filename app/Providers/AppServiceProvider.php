<?php

namespace App\Providers;

use App\Reply;
use App\Topic;
use App\Observers\ReplyObserver;
use App\Observers\TopicObserver;
use VIACreative\SudoSu\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->isLocal()) {
            $this->app->register(ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Topic::observe(TopicObserver::class);
        Reply::observe(ReplyObserver::class);
    }
}
