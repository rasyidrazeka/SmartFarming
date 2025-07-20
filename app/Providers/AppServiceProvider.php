<?php

namespace App\Providers;

use App\Models\BedLocationModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
        App::setLocale('id');
        View::composer('*', function ($view) {
            $locations = DB::table('locations')->get();
            $view->with('locations', $locations);
        });
    }
}
