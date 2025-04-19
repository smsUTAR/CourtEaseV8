<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD
use Illuminate\Support\Facades\Schema;//<-- add this
=======
>>>>>>> master

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
<<<<<<< HEAD
        Schema::defaultStringLength(191);//<-- add this
=======
        //
>>>>>>> master
    }
}
