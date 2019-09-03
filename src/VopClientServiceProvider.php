<?php
namespace Agegg\VopClient;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;

class VopClientServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->setupConfig();
    }

    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/vop.php');
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('vop.php')]);
        }
        $this->mergeConfigFrom($source, 'vop');
    }

    public function register()
    {
        $this->registerFactory($this->app);
        $this->registerManager($this->app);
    }

    protected function registerFactory($app)
    {
        $app->singleton('vopclient.factory', function ($app) {
            return new Factories\VopClientFactory();
        });
        $app->alias('vopclient.factory', 'Agegg\VopClient\Factories\VopClientFactory');
    }

    protected function registerManager($app)
    {
        $app->singleton('vopclient', function ($app) {
            $config = $app['config'];
            $factory = $app['vopclient.factory'];
            return new VopClientManager($config, $factory);
        });
        $app->alias('vopclient', 'Agegg\VopClient\VopClientManager');
    }

    public function provides()
    {
        return [
            'vopclient',
            'vopclient.factory',
        ];
    }
}
