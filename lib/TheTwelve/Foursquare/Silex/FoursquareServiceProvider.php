<?php

namespace TheTwelve\Foursquare\Silex;

use Silex;

class FoursquareServiceProvider implements Silex\ServiceProviderInterface
{

    public function register(Application $app)
    {

        // TODO: instantiate http client

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
