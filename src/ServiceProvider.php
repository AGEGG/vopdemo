<?php

namespace Agegg\Vop;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Vop::class, function () {
            return new Vop(config('services.vop.appKey'), config('services.vop.appSecret'));
        });

        $this->app->alias(Vop::class, 'vop');
    }

    public function provides()
    {
        return [Vop::class, 'vop'];
    }
}
