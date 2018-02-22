<?php

namespace App\Modules\Market;

use Illuminate\Support\ServiceProvider;

use App\Modules\Market\Services\RedisBackend;

class TickerProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->singleton('Ticker', function ($app) {
		    return new RedisBackend;
		});
    }
}
