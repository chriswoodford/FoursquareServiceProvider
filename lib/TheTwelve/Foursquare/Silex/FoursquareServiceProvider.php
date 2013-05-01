<?php

namespace TheTwelve\Foursquare\Silex;

use Silex,
    TheTwelve\Foursquare\HttpClient;

class FoursquareServiceProvider implements Silex\ServiceProviderInterface
{

    public function register(Silex\Application $app)
    {

        $app['foursquare.client'] = $app->share(function() use ($app) {

            switch ($app['foursquare.clientKey']) {

                case 'buzz':
                    $browser = new \Buzz\Browser();
                    return new HttpClient\BuzzHttpClient($browser);

                case 'symfony':
                default:
                    // the Symfony client is preferred with silex
                    return new HttpClient\SymfonyHttpClient();
                    return;

            }

        });

        $app['foursquare.redirector'] = $app->share(function() use ($app) {

            switch ($app['foursquare.redirectorKey']) {

                case 'symfony':
                    // the Symfony client is preferred with silex
                    return new Redirector\SymfonyRedirector();

                default:
                    return new Redirector\HeaderRedirector();

            }

        });

        $app['foursquare'] = $app->share(function() use ($app) {

            $client = $app['foursquare.client'];

            $factory = new \TheTwelve\Foursquare\ApiGatewayFactory($client);
            $factory->useVersion($app['foursquare.version']);
            $factory->setEndpointUri($app['foursquare.endpoint']);
            $factory->setClientCredentials($app['foursquare.clientId'], $app['foursquare.clientSecret']);

            return $factory;

        });

    }

    public function boot(Silex\Application $app)
    {}

}
