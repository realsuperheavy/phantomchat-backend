<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);

        Relation::enforceMorphMap([
            'user' => User::class
        ]);

        Model::preventLazyLoading(!$this->app->isProduction());

        if ('local' === config('app.env')) {
            DB::listen(function ($query): void {
                Log::info($query->sql);
                Log::info($query->bindings);
                //$query->time;
            });
        }
    }
}
