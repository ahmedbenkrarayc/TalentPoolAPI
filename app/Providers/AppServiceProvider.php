<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AnnonceRepository;
use App\Repositories\Interfaces\IAnnonceRepository;
use App\Repositories\CandidatureRepository;
use App\Repositories\Interfaces\ICandidatureRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAnnonceRepository::class, AnnonceRepository::class);
        $this->app->bind(ICandidatureRepository::class, CandidatureRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
