<?php

namespace App\Providers;

use App\Modules\WordReport\ReportDataService;
use App\Modules\WordReport\ReportRepository;
use App\Repositories\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Schema;
use function config;
use function dump;
use function var_dump;

class AppServiceProvider extends ServiceProvider
{
    private static $num = 0;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        $this->app->singleton(ReportDataService::class, function (Application $app) {
            return new ReportDataService($app->get(ReportRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
/*        if (config('app.env') != 'production') {
            \DB::listen(function ($event) {
                AppServiceProvider::$num++;
                dump('監聽 Query :' . AppServiceProvider::$num);
                $sql = \App\Repositories\BaseRepository::getQueryWithBindings($event->sql, $event->bindings);
                $sql = BaseRepository::getQueryWithBindings($event->sql, $event->bindings);
                dump($sql);
            });
        }*/
    }
}
