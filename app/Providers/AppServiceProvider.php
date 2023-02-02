<?php
declare(strict_types=1);

namespace App\Providers;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(FakerGenerator::class, function ($app) {
            return FakerFactory::create($app['config']->get('app.faker_locale', 'en_US'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            $url = Config::get('app.url_frontend');

            return "{$url}/reset-password/{$token}";
        });
    }
}
