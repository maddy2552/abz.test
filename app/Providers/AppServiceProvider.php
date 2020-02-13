<?php

namespace App\Providers;

use App\Position;
use Illuminate\Support\ServiceProvider;
use App\Observers\PositionObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Position::observe(PositionObserver::class);
    }
}
