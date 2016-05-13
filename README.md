# ecrm-php-client

EnhancedCRM API library client for PHP

## Installation

The recommended way to install the client is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version :

```bash
composer require ecrm/ecrm-php-client
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

## Usage

```php
require 'vendor/autoload.php';

// Then we instantiate a client (as shown below)
```

### Build a client
__Using this api without authentication gives an error__

```php
$client = new \EnhancedCRM\Client(['accessToken' => '<YOUR_PERSONAL_ACCESS_TOKEN>']);
```

### Client Options

The following options are available while instantiating a client:

 * __accessToken__: Personal access token
 * __baseUrl__: Base url for the api
 * __userAgent__: Default user-agent for all requests
 * __timeout__: Request timeout
 * __verbose__: Verbose/debug mode

### Architecture

The library follows few architectural principles you should understand before digging deeper.
1. Interactions with resources are done via resource objects.
2. Resource objects are exposed as properties on client instance.
3. Resource objects expose resource-oriented actions.
4. Actions return associative arrays.

For example, to interact with leads API you will use `\EnhancedCRM\Resource\Leads`, which you can get if you call:

```php
$client = new \EnhancedCRM\Client(['accessToken' => '<YOUR_PERSONAL_ACCESS_TOKEN>']);
$client->leads; // \EnhancedCRM\Resource\Leads
```

When you'd like to create a resource:

```php
$client = new \EnhancedCRM\Client(['accessToken' => '<YOUR_PERSONAL_ACCESS_TOKEN>']);
$lead = $client->leads->create(['name' => 'Website redesign', 'contact_id' => $id]);
```

### Error handling

When you instantiate a client or make any request via resource objects, exceptions can be raised for multiple
of reasons e.g. a network error, an authentication error, an invalid param error etc. 

Sample below shows how to properly handle exceptions:

```php
try
{
  // Instantiate a client.
  $client = new \EnhancedCRM\Client(['accessToken' => getenv('ECRM_ACCESS_TOKEN')]);
  $lead = $client->leads->create(['organization_name' => 'Architecture company']);
}
catch (\EnhancedCRM\Errors\ConfigurationError $e)
{
  // Invalid client configuration option
}
catch (\EnhancedCRM\Errors\ResourceError $e)
{
  // Resource related error
  print('Http status = ' . $e->getHttpStatusCode() . "\n");
  print('Request ID = ' . $e->getRequestId() . "\n");
  foreach ($e->errors as $error)
  {
    print('field = ' . $error['field'] . "\n");
    print('code = ' . $error['code'] . "\n");
    print('message = ' . $error['message'] . "\n");
    print('details = ' . $error['details'] . "\n");
  }
}
catch (\EnhancedCRM\Errors\RequestError $e)
{
  // Invalid query parameters, authentication error etc.
}
catch (\EnhancedCRM\Errors\Connectionerror $e)
{
  // Network communication error, curl error is returned
  print('Errno = ' . $e->getErrno() . "\n");
  print('Error message = ' . $e->getErrorMessage() . "\n");
}
catch (Exception $e)
{
  // Other kind of exception
}
```
