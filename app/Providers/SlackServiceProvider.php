<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ThreadMeUp\Slack\Client;

class SlackServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Slack', function ($app) {
            return new Client([
                'token'    => getenv('SLACK_TOKEN'),
                'team'     => 'viget',
                'username' => 'pollie',
                'icon'     => false,
                'parse'    => '',
            ]);
        });
    }
}
