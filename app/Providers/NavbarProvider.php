<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NavbarProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->shownavbar();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function shownavbar(){
        view()->composer('layouts.navbar','App\Http\ViewComposers\NavbarComposer');
    }
}
