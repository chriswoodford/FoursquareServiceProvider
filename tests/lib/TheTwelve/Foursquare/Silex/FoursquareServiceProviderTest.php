<?php

use Silex\Application,
    TheTwelve\Foursquare\Silex\FoursquareServiceProvider;

class TheTwelve_Foursquare_Silex_FoursquareServiceProviderTest
    extends PHPUnit_Framework_TestCase
{

    public function testInstantiation()
    {

        $app = new Application();

        $app->register(new FoursquareServiceProvider(), array(
            'foursquare.version' => 2,
        	'foursquare.endpointUri' => 'https://api.foursquare.com',
        	'foursquare.clientKey' => 'symfony',
        ));

        $this->assertInstanceOf('TheTwelve\Foursquare\ApiGatewayFactory', $app['foursquare']);

    }

}
