<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Our admin panel uses Bootstrap 5, so use Bootstrap pagination links.
        Paginator::useBootstrapFive();
    }
}
