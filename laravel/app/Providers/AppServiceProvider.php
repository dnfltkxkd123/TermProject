<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Test;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        Test::creating(function($test){
            if(!empty($test->account)){
                $test -> account = \Crypt::encrypt($test->account);
            }
        });
        */
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
