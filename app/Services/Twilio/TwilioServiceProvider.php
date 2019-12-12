<?php

namespace App\Services\Twilio;

use Twilio\Rest\Client as TwilioClient;
use Illuminate\Support\ServiceProvider;

class TwilioServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TwilioClient::class, function () {
            $config = config('services.twilio');
            $client = new TwilioClient($config['sid'], $config['token']);
            return $client;
        });

        $this->app->alias(TwilioClient::class, 'twilio');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['twilio'];
    }
}
