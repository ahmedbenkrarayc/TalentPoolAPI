<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AnnonceRepository;
use App\Repositories\Interfaces\IAnnonceRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAnnonceRepository::class, AnnonceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
