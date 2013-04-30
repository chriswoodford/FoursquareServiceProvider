# Foursquare API Client Service Provider (Silex) by TheTwelve Labs
==================================================================

A Silex Service Provider for our Foursquare API Client  
[https://github.com/chriswoodford/foursquare-php](https://github.com/chriswoodford/foursquare-php)

## Installation
--------------

[Composer](http://getcomposer.org) is currently the only way to install the 
foursquare client into your project.

### Create your composer.json file

      {
          "require": {
              "thetwelvelabs/foursquare-service-provider": "0.1.*"
          }
      }

### Download composer into your application root

      $ curl -s http://getcomposer.org/installer | php

### Install your dependencies

      $ php composer.phar install
 
## Usage
---------

Register the service provider

      $app->register(new TheTwelve\Foursquare\Silex\FoursquareServiceProvider(), array(
          'foursquare.version' => 2,
          'foursquare.endpoint' => 'https://api.foursquare.com',
          'foursquare.clientKey' => 'symfony',
      ));


Get an instance of the [TheTwelve\Foursquare\ApiGatewayFactory](https://github.com/chriswoodford/foursquare-php)

      $factory = $app['foursquare'];

