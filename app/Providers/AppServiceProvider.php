<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
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
        $category = DB::table('category')->where('CatActive','=',1)->Get();
        $categoryAll = DB::table('category')->get();
        view()->share(compact('category','categoryAll'));
        Paginator::useBootstrap();
    }
}
