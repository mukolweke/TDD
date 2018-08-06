<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        \View::share('channels',\App\Channel::all());

        \View::composer('*', function ($view){
            $channel = Cache::rememberForever('cahnnels', function (){
               return Channel::all();
            });

            $view->with('channels', $channel);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
