<?php

namespace TheTwelve\Foursquare\Silex;

use Silex,
    TheTwelve\Foursquare\HttpClient,
    TheTwelve\Foursquare\Redirector;

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
                    // the Symfony client is preferred with silex
                    return new HttpClient\SymfonyHttpClient();

                default:
                    return new HttpClient\CurlHttpClient($app['foursquare.pathToCertificate']);

            }

        });

        $app['foursquare.redirector'] = $app->share(function() use ($app) {

            if (!isset($app['foursquare.redirectorKey'])) {
                return null;
            }

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
            $redirector = $app['foursquare.redirector'];

            $factory = new \TheTwelve\Foursquare\ApiGatewayFactory($client, $redirector);
            $factory->useVersion($app['foursquare.version']);
            $factory->setEndpointUri($app['foursquare.endpoint']);
            $factory->setClientCredentials($app['foursquare.clientId'], $app['foursquare.clientSecret']);

            return $factory;

        });

    }

    public function boot(Silex\Application $app)
    {}

}
