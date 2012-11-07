<?php

namespace TheTwelve\Foursquare\Silex;

use Silex;

class FoursquareServiceProvider implements Silex\ServiceProviderInterface
{

    public function register(Application $app)
    {

        $app['foursquare.client'] = $app->share(function() use ($app) {

            switch ($app['foursquare.clientKey']) {

                case 'buzz':
                    $browser = \Buzz\Browser();
                    return \TheTwelve\Foursquare\HttpClient\BuzzHttpClient($browser);

                case 'symfony':
                default:
                    // the Symfony client is preferred with silex
                    return \TheTwelve\Foursquare\HttpClient\SymfonyHttpClient();
                    return;

            }

        });

        $app['foursquare'] = $app->share(function() use ($app) {

            $client = $app['foursquare.client'];

            $factory = new \TheTwelve\Foursquare\ApiGatewayFactory($client);
            $factory->useVersion($app['foursquare.version']);
            $factory->setEndpointUri($app['foursquare.endpoint']);

            return $factory;

        });

    }

    public function boot(Silex\Application $app)
    {}

}
