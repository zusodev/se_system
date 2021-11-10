<?php

namespace App\Providers;

use App\Modules\WordReport\ReportDataService;
use App\Modules\WordReport\ReportRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Schema;
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
        /*if (config("app.env") != "production") {
            \DB::listen(function ($event) {
                AppServiceProvider::$num++;
                $sql = \App\Repositories\BaseRepository::getQueryWithBindings($event->sql, $event->bindings);
                var_dump($sql);
                echo '<br>';
            });
        }*/
    }
}
