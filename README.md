# HubSpot PHP API client

[![Version](https://img.shields.io/packagist/v/hubspot/hubspot-php.svg?style=flat-square)](https://packagist.org/packages/hubspot/hubspot-php)
[![Total Downloads](https://img.shields.io/packagist/dt/hubspot/hubspot-php.svg?style=flat-square)](https://packagist.org/packages/hubspot/hubspot-php)
[![Build Status](https://travis-ci.org/hubspot/hubspot-php.svg?branch=master)](https://travis-ci.org/hubspot/hubspot-php)
[![License](https://img.shields.io/packagist/l/hubspot/hubspot-php.svg?style=flat-square)](https://packagist.org/packages/hubspot/hubspot-php)

## Setup

**Composer:**

```bash
composer require "hubspot/hubspot-php"
```

## Sample apps

[Link](https://github.com/HubSpot/integration-examples-php)

## Quickstart

### Examples Using Factory

All following examples assume this step.

```php
$hubspot = SevenShores\Hubspot\Factory::create('api-key');

// OR create with OAuth2 access token

$hubspot = SevenShores\Hubspot\Factory::createWithOAuth2Token('access-token');

// OR instantiate by passing a configuration array.
// The only required value is the 'key'

$hubspot = new SevenShores\Hubspot\Factory([
  'key'      => 'demo',
  'oauth2'   => 'false', // default
]);
```
*Note:* You can prevent any error handling provided by this package by passing following options into client creation routine:
(applies also to `Factory::create()` and `Factory::createWithOAuth2Token()`)

```php
$hubspot = new SevenShores\Hubspot\Factory([
  'key'      => 'demo',
],
null,
[
  'http_errors' => false // pass any Guzzle related option to any request, e.g. throw no exceptions
],
false // return Guzzle Response object for any ->request(*) call
);
```

By setting `http_errors` to false, you will not receive any exceptions at all, but pure responses.
For possible options, see http://docs.guzzlephp.org/en/latest/request-options.html.

#### API Client comes with Middleware for implementation of Rate and Concurrent Limiting.
It provides an ability to turn on retry for failed requests with statuses 429 or 500. You can read more about working within the HubSpot API rate limits [here](https://developers.hubspot.com/docs/faq/working-within-the-hubspot-api-rate-limits).

```php
$handlerStack = \GuzzleHttp\HandlerStack::create();
$handlerStack->push(
    \SevenShores\Hubspot\RetryMiddlewareFactory::createRateLimitMiddleware(
        \SevenShores\Hubspot\Delay::getConstantDelayFunction()
    )
);
        
$handlerStack->push(
    \SevenShores\Hubspot\RetryMiddlewareFactory::createInternalErrorsMiddleware(
        \SevenShores\Hubspot\Delay::getExponentialDelayFunction(2)
    )
);

$guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

$config = [
    'key'      => 'demo',
    'oauth2'   => 'false',
];

$hubspot = new \SevenShores\Hubspot\Factory(config, new \SevenShores\Hubspot\Client($config, guzzleClient));
```

#### Get a single contact:

```php
$contact = $hubspot->contacts()->getByEmail("test@hubspot.com");

echo $contact->properties->email->value;
```

#### Paginate through all contacts:

```php
// Get an array of 10 contacts
// getting only the firstname and lastname properties
// and set the offset to 123456
$response = $hubspot->contacts()->all([
    'count'     => 10,
    'property'  => ['firstname', 'lastname'],
    'vidOffset' => 123456,
]);
```

Working with the data is easy!

```php
foreach ($response->contacts as $contact) {
    echo sprintf(
        "Contact name is %s %s." . PHP_EOL,
        $contact->properties->firstname->value,
        $contact->properties->lastname->value
    );
}

// Info for pagination
echo $response->{'has-more'};
echo $response->{'vid-offset'};
```

or if you prefer to use array access?

```php
foreach ($response['contacts'] as $contact) {
    echo sprintf(
        "Contact name is %s %s." . PHP_EOL,
        $contact['properties']['firstname']['value'],
        $contact['properties']['lastname']['value']
    );
}

// Info for pagination
echo $response['has-more'];
echo $response['vid-offset'];
```

Now with response methods implementing [PSR-7 ResponseInterface](https://github.com/php-fig/http-message/tree/master/src)

```php
$response->getStatusCode()   // 200;
$response->getReasonPhrase() // 'OK';
// etc...
```

### Example Without Factory

```php
<?php

require 'vendor/autoload.php';

use SevenShores\Hubspot\Http\Client;
use SevenShores\Hubspot\Resources\Contacts;

$client = new Client(['key' => 'demo']);

$contacts = new Contacts($client);

$response = $contacts->all();

foreach ($response->contacts as $contact) {
    //
}
```

### Example of using built in utils

```php
<?php

require 'vendor/autoload.php';

use SevenShores\Hubspot\Utils\OAuth2;

$authUrl = OAuth2::getAuthUrl(
    'clientId',
    'http://localhost/callaback.php',
    'contacts'
);

```

or using Factory:


```php
<?php

require 'vendor/autoload.php';

use SevenShores\Hubspot\Utils;

$authUrl = Utils::getFactory()->oAuth2()->getAuthUrl(
    'clientId',
    'http://localhost/callaback.php',
    'contacts'
);

```

## Status

If you see something not planned, that you want, make an [issue](https://github.com/HubSpot/hubspot-php/issues) and there's a good chance I will add it.

- [x] Analytics API
- [x] Calendar API :upadated:
- [x] Companies API :upadated:
- [x] Company Properties API :upadated:
- [x] Contacts API :upadated:
- [x] Contact Lists API :upadated:
- [x] Contact Properties API :upadated:
- [ ] Conversations Live Chat Widget API (Front End)
- [x] CMS Blog API (Blogs) :upadated:
- [x] CMS Blog Authors API (BlogAuthors) :upadated:
- [ ] CMS Blog Comments API (Comments)
- [x] CMS Blog Post API (BlogPosts)
- [x] CMS Blog Topics API (BlogTopics)
- [ ] CMS Domains API
- [x] CMS Files API (Files)
- [x] CMS HubDB API (HubDB) :upadated:
- [ ] CMS Layouts API
- [x] CMS Page Publishing API (Pages)
- [ ] CMS Site Maps
- [ ] CMS Site Search API
- [ ] CMS Templates API
- [ ] CMS URL Mappings API
- [x] CRM Associations API
- [ ] CRM Extensions API
- [x] CRM Object Properties API (ObjectProperties) :new:
- [x] CRM Pipelines API (CrmPipelines)
- [x] Deals API
- [x] Deal Pipelines API :deprecated:
- [x] Deal Properties API :upadated:
- [x] Ecommerce Bridge API :upadated:
- [x] Email Subscription API :upadated:
- [x] Email Events API :upadated:
- [x] Engagements API
- [x] Events API
- [x] Forms API :upadated:
- [x] Line Items API :new:
- [ ] Marketing Email API
- [x] Owners API :upadated:
- [x] Products API :new:
- [x] Social Media API
- [x] Tickets API
- [x] Timeline API :upadated:
- [ ] Tracking Code API
- [x] Transactional Email API
- [x] Workflows API :upadated:
- [x] Webhooks API
